<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Comment;
use App\Entity\Conference;
use App\Entity\Speaker;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        // return parent::index();

        return $this->render('admin/my-dashboard.html.twig',[
            'title' => 'Bienvenu sur le tableau de bord des conférences',
            'description' => 'Vous allez pouvoir gérer les différents lieux de conférences ainsi que leurs commentaires',
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle("<img src='https://s2.qwant.com/thumbr/0x0/7/b/22597c2e0755884c634bd896431c00b6709406df357fad137e8c528e4582ef/Logo_Diginamic_Passeport-e1492187736114.png?u=http%3A%2F%2Fwww.diginamic.fr%2Fwp-content%2Fuploads%2F2018%2F01%2FLogo_Diginamic_Passeport-e1492187736114.png&q=0&b=1&p=0&a=0'/>Conférences Digiteam");
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Accueil Administrateur', 'fa fa-home');
        yield MenuItem::linkToCrud('Conférences', 'fas fa-map-marker-alt', Conference::class);
        yield MenuItem::linkToCrud('Commentaires', 'fas fa-comments', Comment::class);
        yield MenuItem::linktoCrud('Conférenciers','fas fa-list',Speaker::class);
        yield MenuItem::linkToUrl('Accueil du site','fa fa-home','/');
        
    }
}
