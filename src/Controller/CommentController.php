<?php

namespace App\Controller;

use App\Entity\CommentMark;
use App\Entity\Post;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentMarkRepository;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/comments")
 */
class CommentController extends AbstractController
{
    /**
     * @param Request           $request           HTTP request
     * @param Post              $post              Post
     * @param CommentRepository $commentRepository Comment repository
     *
     * @return Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/create",
     *     methods={"GET", "POST"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="comment_create",
     * )
     */
    public function create(Request $request, Post $post, CommentRepository $commentRepository): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setPost($post);
            $comment->setUser($user);
            $commentRepository->save($comment);
            $this->addFlash('app_success', 'Comentario creado satisfactoriamente!!!');

            return $this->redirectToRoute('post_show', ['id' => $post->getId()]);
        }elseif($form->isSubmitted())
        {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Ha ocurrido un Error. Verifique que su comentario sea mayor de 3 letras!!!');

            return $this->redirectToRoute('post_show', ['id' => $post->getId()]);
        }

        return $this->render(
            'comments/create.html.twig',
            [
                'form' => $form->createView(),
                'post' => $post,
            ]
        );
    }

    /**
     * @param Request           $request           HTTP request
     * @param Comment           $comment           Comment entity
     * @param CommentRepository $commentRepository Comment repository
     *
     * @return Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="comment_delete",
     * )
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Comment::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Comentario!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Comentario satisfactoriamente!!!');
        }

        return $this->redirectToRoute('main_index');
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
            return $this->redirectToRoute('post_show', ['id' => $comment->getPost()->getId()]);
        }

        $mark = new CommentMark();
        $mark->setUser($user);
        $mark->setComment($comment);
        $mark->setMark($bool ? 1 : -1);
        $commentMarkRepository->save($mark);

        return $this->redirectToRoute('post_show', ['id' => $comment->getPost()->getId()]);
    }
}