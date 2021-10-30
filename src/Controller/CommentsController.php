<?php

namespace App\Controller;

use App\Entity\CommentMark;
use App\Repository\CommentMarkRepository;
use App\Repository\CommentRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Comment;
use App\Form\Type\CommentForm;
use App\Entity\User;

/**
 * @Route("/admin/comentario")
 */
class CommentsController extends AbstractController
{
    public $comentarioRepository;

    public function __construct(CommentRepository $comentarioRepository)
    {
        $this->comentarioRepository = $comentarioRepository;
    }

    /**
     * @Route("/comments", name="comments")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(CommentRepository $commentRepository): Response
    {
        return $this->render('comments/index.html.twig', [
            'comments' => $commentRepository->findBy([], ['date_created' => 'DESC'])
        ]);
    }

    /**
     * @Route("/{id}/edit", name="comment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Comment $comm): Response
    {
        $form = $this->createForm(CommentForm::class, $comm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Comentario del Post satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Comentario : %s', $comm->getComment()));

            return $this->redirectToRoute('comments');
        }

        return $this->render('comments/edit.html.twig', [
            'comm' => $comm,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="coment_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Comment::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Comentario del Post!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Comentario del Post satisfactoriamente!!!');
        }

        return $this->redirectToRoute('comments');
    }

    /**
     * @param Comment               $comment               Comment entity
     * @param int                   $bool                  boolean
     * @param CommentMarkRepository $commentMarkRepository Comment Mark Repository
     *
     * @return Response HTTP response
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/mark/{bool}",
     *     methods={"GET"},
     *     name="comment_mark",
     *     requirements={"id": "[1-9]\d*", "bool": "0|1"},
     * )
     */
    public function mark(Comment $comment, int $bool, CommentMarkRepository $commentMarkRepository): Response
    {
        $user = $this->getUser();
        $alreadyMarked = $commentMarkRepository->alreadyVoted($comment, $user);

        if ($alreadyMarked) {
            $this->addFlash('app_danger', 'Permisos denegados');
            return $this->redirectToRoute("post_single", ['slug' => $comment->getPost()->getSlug()]);
        }

        $mark = new CommentMark();
        $mark->setUser($user);
        $mark->setComment($comment);
        $mark->setMark($bool ? 1 : -1);
        $commentMarkRepository->save($mark);

        return $this->redirectToRoute("post_single", ['slug' => $comment->getPost()->getSlug()]);
    }
}
