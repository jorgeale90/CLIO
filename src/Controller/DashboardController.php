<?php
namespace App\Controller;

use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Post;
use App\Entity\Comment;
use App\Entity\User;
use App\Service\SettingService;
use App\Filter\PostFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;

/**
 * @Route("/admin")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(SettingService $setting)
    {
        $em = $this->getDoctrine()->getManager();

        $posts_qb = $em->getRepository(Post::class)->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->getQuery();

        $comments_qb = $em->getRepository(Comment::class)->createQueryBuilder('c')
            ->orderBy('c.id', 'DESC')
            ->getQuery();

        $users_qb = $em->getRepository(User::class)->createQueryBuilder('u')
            ->orderBy('u.id', 'DESC')
            ->getQuery();

        $posts = $posts_qb->execute();
        $comments = $comments_qb->execute();
        $users = $users_qb->execute();

        return $this->render('dashboard/index.html.twig', [
            'current' => 'admin',
            'headline' => 'Dashboard',
            'posts' => $posts,
            'comments' => $comments,
            'users' => $users,
            'base' => $setting->get()
        ]);
    }

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/posts/", name="admin_posts", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function posts(Request $request, PaginatorInterface $paginator, PostRepository $postRepository, FilterBuilderUpdaterInterface $query_builder_updater)
    {
        if ($postRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Post almacenados en la Base de Datos!!!');
        }

        $filterBuilder = $this->em->getRepository(Post::class)
            ->createQueryBuilder('c')
            ->orderBy('c.date_created', 'DESC');

        $form = $this->get('form.factory')->create(PostFilterType::class);

        if ($request->query->has($form->getName())) {
            $form->submit($request->query->get($form->getName()));
            $query_builder_updater->addFilterConditions($form, $filterBuilder);
        }

        $query = $filterBuilder->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->get('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('dashboard/posts.html.twig', array(
            'form' => $form->createView(),
            'pagination' => $pagination
        ));
    }
}
