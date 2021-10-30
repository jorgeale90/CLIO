<?php

namespace App\Controller;

use App\Entity\Galeria;
use App\Entity\PostMark;
use App\Form\SearchForm;
use App\Form\UserType;
use App\Form\Type\UserBlogType;
use App\Repository\CommentMarkRepository;
use App\Repository\PostMarkRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Comment;
use App\Entity\Post;
use App\Repository\PostRepository;
use App\Entity\Category;
use App\Form\PostForm;
use App\Form\CommentForm;
use App\Service\SettingService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class BlogController extends AbstractController
{
    protected $itemsPerPage = 3 ;
    private $passwordEncoder;
    public $postRepository;

    public function __construct(PostRepository $postRepository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->postRepository = $postRepository;
    }

    /**
     * @Route("/blog/listpost", name="post_list")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function post_list(Request $request, SettingService $setting, PaginatorInterface $paginator) {

        $em = $this->getDoctrine()->getManager();

        $page = $request->get('page') ? $request->get('page') : 1;

        $posts_qb = $em->getRepository(Post::class)
            ->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->getQuery();

        $posts_qb_pagin = $em->getRepository(Post::class)
            ->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->getQuery();

        $popular_qb = $em->getRepository(Post::class)
            ->createQueryBuilder('p')
            ->orderBy('p.view_count', 'DESC')
            ->getQuery();

        $comment_qb = $em->getRepository(Comment::class)
            ->createQueryBuilder('c')
            ->orderBy('c.id', 'DESC')
            ->getQuery();

        $posts = $posts_qb->setMaxResults(10)->execute();
        $popular_posts = $popular_qb->setMaxResults(7)->execute();
        $comments = $comment_qb->setMaxResults(5)->execute();

        $paginador = $paginator->paginate(
            $posts_qb_pagin,
            $page,
            $this->itemsPerPage
        );

        $categories = $em->getRepository(Category::class)->findAll();

        $searchForm = [];

        $form = $this->createForm(SearchForm::class, $searchForm);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $qb = $em->getRepository(Post::class)
                ->createQueryBuilder('p')
                ->where('p.title like :title or p.content like :content')
                ->setParameter('title', '%' . $data['query'] . '%')
                ->setParameter('content', '%' . $data['query'] . '%')
                ->orderBy('p.id', 'DESC')
                ->getQuery();
                                            
            $posts = $qb->execute();
        }

        return $this->render(
            "blog/post_list.html.twig",
            [
                'paginator' => $paginador,
                'posts' => $posts,
                'popular' => $popular_posts,
                'comments' => $comments,
                'form' => $form->createView(),
                'base' => $setting->get(),
                'menu' => $setting->getMenu(),
                'category' => $categories
            ]
        );
    }

    private function slugify($title) {
        $slug = str_replace('\'', '', strtolower($title));
        return strip_tags(str_replace(' ', '-', stripslashes($slug))) . '-' . \uniqid();
    }

    /**
     * @Route("/user/post/new", name="post_new")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function post_new(Request $request, SettingService $setting) {
        $post = new Post();

        $form = $this->createForm(PostForm::class, $post, ['cats' => $this->getDoctrine()->getManager()]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $data = $form->getData();
            $user = $this->getUser();

            if ($form->get('tags')) {
                $tags_str = $form->get('tags')->getData();
                $tags_arr = explode(',', $tags_str);

                for ($i = 0; $i < sizeof($tags_arr); $i++) {
                    $tags_arr[$i] = strtolower(trim($tags_arr[$i]));
                }

                $data->setTags($tags_arr);
            }

            // $data->setCategory($form->get('category'));
            $data->setSlug($this->slugify($form->get('title')->getData()));
            $data->setUser($user);
            $data->setViewCount(0);
            $data->setDateCreated(new \DateTime("now"));

            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Post satisfactoriamente!!!');

            return $this->redirectToRoute("post_list");
        }

        return $this->render(
            "blog/post_new.html.twig",
            [
                'form' => $form->createView(),
                'headline' => 'New Post',
                'current' => 'posts',
                'base' => $setting->get(),
                'menu' => $setting->getMenu()
            ]
        );
    }

    /**
     * @Route("/user/post/edit/{id}", name="post_edit")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function post_edit(Request $request, SettingService $setting, $id) {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Post::class)->find($id);

        $tags_str = null;

        if ($post->getTags()) {
            $tags_str = implode(',', $post->getTags());
        }

        $form = $this->createForm(PostForm::class, $post, ['cats' => $this->getDoctrine()->getManager(), 'tags' => $tags_str]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            if ($form->get('tags')) {
                $tags_str = $form->get('tags')->getData();
                $tags_arr = explode(',', $tags_str);

                for ($i = 0; $i < sizeof($tags_arr); $i++) {
                    $tags_arr[$i] = strtolower(trim($tags_arr[$i]));
                }

                $data->setTags($tags_arr);
            }

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Post satisfactoriamente!!!');

            return $this->redirectToRoute("admin_posts");
        }

        return $this->render(
            "blog/post_new.html.twig",
            [
                'form' => $form->createView(),
                'post' => $post,
                'headline' => 'Edit Post',
                'id' => $id,
                'current' => 'posts',
                'menu' => $setting->getMenu(),
                'base' => $setting->get()
            ]
        );
    }

    /**
     * @Route("/user/post/delete/{id}", name="delete")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function post_delete(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Post::class)->find($id);
        $comments = $em->getRepository(Comment::class)->findBy(['post' => $id]);

        foreach ($comments as $comment) {
            $em->remove($comment);
            $em->flush();
        }

        $em->remove($post);
        $em->flush();

        $this->addFlash(
            'success',
            "Post has been deleted successfully."
        );
        return $this->redirectToRoute("admin_posts");
    }


    /**
     * @Route("/post/{slug}", name="post_single")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function post_single(Request $request, SettingService $setting, Post $pos, $slug, PostMarkRepository $postMarkRepository, CommentMarkRepository $commentMarkRepository) {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Post::class)->findOneBy(['slug' => $slug]);

        $mark = $postMarkRepository->countMarkValue($pos);
        $user = $this->getUser();
        $alreadyMarked = $postMarkRepository->alreadyVoted($pos, $user);

        $comments = $post->getComments();

        $comment_form = $this->createForm(CommentForm::class, []);

        $comment_form->handleRequest($request);

        if ($comment_form->isSubmitted() && $comment_form->isValid()) {
            $data = $comment_form->getData();

            $c = new Comment();

            $c->setUser($this->getUser());
            $c->setComment($data['comment']);
            $c->setDateCreated(new \DateTime("now"));
            $c->setPost($post);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($c);
            $manager->flush();

            return $this->redirectToRoute("post_single", ['slug' => $post->getSlug()]);
        }

        // Update view count
        $post->setViewCount($post->getViewCount() + 1);
        $em->flush();

        // Get other posts
        $qb = $em->getRepository(Post::class)
            ->createQueryBuilder('p')
            ->andWhere('p.id != :id')
            ->setParameter('id', $post->getId())
            ->orderBy('p.view_count', 'DESC')
            ->getQuery();

        $all_posts = $qb->setMaxResults(5)->execute();

        return $this->render(
            "blog/post_single.html.twig",
            [
                'post' => $post,
                'pos' => $pos,
                'mark' => $mark,
                'alreadyMarked' => $alreadyMarked,
                'commentMarkRepository' => $commentMarkRepository,
                'posts' => $all_posts,
                'comments' => $comments,
                'comment_form' => $comment_form->createView(),
                'menu' => $setting->getMenu(),
                'base' => $setting->get()
            ]
        );
    }

    /**
     * @param Post               $post               Post entity
     * @param int                $bool               boolean
     * @param PostMarkRepository $postMarkRepository Post Mark Repository
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
     *     name="post_mark",
     *     requirements={"id": "[1-9]\d*", "bool": "0|1"},
     * )
     */
    public function mark(Post $post, int $bool, PostMarkRepository $postMarkRepository): Response
    {
        $user = $this->getUser();
        $alreadyMarked = $postMarkRepository->alreadyVoted($post, $user);

        if ($alreadyMarked) {
            $this->addFlash('app_danger', 'Error!!!');
            return $this->redirectToRoute("post_single", ['slug' => $post->getSlug()]);
        }

        $mark = new PostMark();
        $mark->setUser($user);
        $mark->setPost($post);
        $mark->setMark($bool ? 1 : -1);
        $postMarkRepository->save($mark);

        return $this->redirectToRoute("post_single", ['slug' => $post->getSlug()]);
    }

    /**
     * @Route("/activatefijarpost", name="fijar_en_portada", methods={"GET","POST"})
     */
    public function activateFijarPost(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $value = $request->get('value') == 'false' ? false : true;
        $id = $request->get('id');
        $menu = $this->postRepository->findOneBy(['fijar_post' => true]);
        $fijarpost = $this->postRepository->find($id);
        $action = 'fijar_post';
        if ($menu) {
            $menu->setFijarPost(false);
            $entityManager->persist($menu);
        }

        $fijarpost->setFijarPost($value);
        $entityManager->persist($fijarpost);
        $entityManager->flush();

        return new JsonResponse(array('response' => $action));
    }

    /**
     * @Route("/activateicono", name="icono_en_portada", methods={"GET","POST"})
     */
    public function activateIcono(Request $request)
    {
        $value = $request->get('value') == 'false' ? false : true;
        $id = $request->get('id');
        $iconopost = $this->postRepository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $action = 'sharing_icons';
        $iconopost->setSharingIcons($value);
        $entityManager->persist($iconopost);
        $entityManager->flush();

        return new JsonResponse(array('response' => $action));
    }

    /**
     * @Route("/activatecomentario", name="comentario_en_post", methods={"GET","POST"})
     */
    public function activateComentario(Request $request)
    {
        $value = $request->get('value') == 'false' ? false : true;
        $id = $request->get('id');
        $comentariopost = $this->postRepository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $action = 'allow_comments';
        $comentariopost->setAllowComments($value);
        $entityManager->persist($comentariopost);
        $entityManager->flush();

        return new JsonResponse(array('response' => $action));
    }

    /**
     * @Route("/post/perfil/usershow", name="blog_perfil_user", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function perfilUserBlog(Request $request, SettingService $setting, UserRepository $userRepository): Response
    {
        $em = $this->getDoctrine()->getManager();

        $posts_qb = $em->getRepository(Post::class)->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->getQuery();

        $galery_qb = $em->getRepository(Galeria::class)->createQueryBuilder('g')
            ->orderBy('g.id', 'DESC')
            ->getQuery();

        $postss = $posts_qb->setMaxResults(10)->execute();
        $galeryss = $galery_qb->setMaxResults(10)->execute();

        $user = $this->getUser();

        $form = $this->createForm(UserBlogType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $plainpwd = $user->getPassword();
            $encoded = $this->passwordEncoder->encodePassword($user,$plainpwd);
            $user->setPassword($encoded);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_logout');
        }

        return $this->render('user/perfilblog.html.twig', [
            'perfilusers' => $userRepository->findAll(),
            'posts' => $postss,
            'user'    => $user,
            'galeryss' => $galeryss,
            'menu' => $setting->getMenu(),
            'form' => $form->createView(),
        ]);
    }
}
