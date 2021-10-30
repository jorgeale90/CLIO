<?php
namespace App\Controller;

use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\SettingService;
use App\Entity\Post;
use App\Entity\Category;

class ArchiveController extends AbstractController
{
    /**
     * @Route("/archive", name="archive")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(Request $request, SettingService $setting, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $posts_qb = $em->getRepository(Post::class)->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->getQuery();

        $itemsPerPage = 20;
        $page = $request->get('page') ? $request->get('page') : 1;
        $posts = $paginator->paginate(
                $posts_qb,
                $page,
                $itemsPerPage
            );

        return $this->render('archive/index.html.twig', [
            'controller_name' => 'ArchiveController',
            'posts' => $posts,
            'menu' => $setting->getMenu(),
            'base' => $setting->get()
        ]);
    }

    /**
     * @Route("/blog/archive/{category}", name="archive_cat")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function post_category(Request $request, SettingService $setting, $category, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();

        $cat = $em->getRepository(Category::class)->findOneBy(['name' => $category]);

        $posts_qb = $em->getRepository(Post::class)->createQueryBuilder('p')
            ->where(':category = p.category')
            ->setParameter('category', $cat)
            ->orderBy('p.id', 'DESC')
            ->getQuery();

        $itemsPerPage = 10;
        $page = $request->get('page') ? $request->get('page') : 1;
        $posts = $paginator->paginate(
            $posts_qb,
            $page,
            $itemsPerPage
        );

        return $this->render('archive/index.html.twig', [
            'category' => $category,
            'tag' => null,
            'posts' => $posts,
            'menu' => $setting->getMenu(),
            'base' => $setting->get()
        ]);
    }

    /**
     * @Route("/archive/tags/{tag}", name="tag_single")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function findTag(Request $request, SettingService $setting, $tag, PaginatorInterface $paginator) {
        $em = $this->getDoctrine()->getManager();

        $posts_qb = $em->getRepository(Post::class)->createQueryBuilder('p')
            ->where('p.tags like :tag')
            ->setParameter(':tag', '%' . $tag . '%')
            ->orderBy('p.id', 'DESC')
            ->getQuery();

        $itemsPerPage = 10;
        $page = $request->get('page') ? $request->get('page') : 1;
        $posts = $paginator->paginate(
            $posts_qb,
            $page,
            $itemsPerPage
        );

        return $this->render('archive/index.html.twig', [
            'tag' => $tag,
            'category' => null,
            'posts' => $posts,
            'menu' => $setting->getMenu(),
            'base' => $setting->get()
        ]);
    }

}
