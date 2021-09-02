<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\User;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        // return parent::index();
        $repo=$this->getDoctrine()->getRepository(User::class);
        $repoProduct=$this->getDoctrine()->getRepository(Product::class);
        $repoCat=$this->getDoctrine()->getRepository(Category::class);
        $categories=$repoCat->findAll();
        $nbCat=count($categories);
        $products=$repoProduct->findAll();
        $nbProduct=count($products);
        $users=$repo->findAll();
        $usersLenght=count($users);
        // dd($usersLenght);
        return $this->render('bundles/EasyAdminBundle/welcome.html.twig',[
            'nbUsers'=>$usersLenght,
            'nbProduct'=>$nbProduct,
            'nbCat'=>$nbCat
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Mon Site');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Tableau de bord', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Catégorie', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('Produit', 'fas fa-list', Product::class);

    }
}
