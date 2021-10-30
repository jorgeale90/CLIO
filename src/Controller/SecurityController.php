<?php

namespace App\Controller;

use App\Entity\Especialista;
use App\Entity\User;
use App\Form\EspecialistaType;
use App\Form\UserType;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Service\NotificationSystem;

class SecurityController extends AbstractController
{

    public $notifier;

    public function __construct(NotificationSystem $notifier)
    {
        $this->notifier = $notifier;
    }

    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // Retrive the last email entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($error) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Ha ocurrido un error!!!');
            $flashBag->add('app_error', sprintf('Error: %s', $error->getMessageKey()));
        }

        return $this->render('user/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): Response
    {
        // controller can be blank: it will never be executed!
    }

    /**
     * @Route("/register", name="user_registration")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return RedirectResponse|Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new Especialista();
        $form = $this->createForm(EspecialistaType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user->getCredentials(), $user->getCredentials()->getPassword());
            $user->getCredentials()->setPassword($password);
            $user->getCredentials()->setRoles(['ROLE_ESPECIALISTA']);
            $entityManager = $this->getDoctrine()->getManager();
            $message = $user->getCredentials()->getFirstname() . ' ' . $user->getCredentials()->getLastname() . ' se ha registrado en el sistema.';
            $this->notifier->sendNotificationToParentUser($message);
            $entityManager->persist($user);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado su cuenta satisfactoriamente. Espere que el administrador active su cuenta!!!');

            return $this->redirectToRoute('app_login');
        }

        return $this->render(
            'user/register.html.twig',
            array('form' => $form->createView())
        );
    }
}