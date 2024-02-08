<?php

namespace App\Controller\Admin;

use App\Entity\Livre;
use App\Entity\Auteur;
use App\Entity\Emprunt;
use App\Entity\Adherent;
use App\Entity\Categorie;
use App\Entity\Reservations;
use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('API');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Gestion des Livres');
        yield MenuItem::linkToCrud('Livres', 'fa fa-book', Livre::class);
        yield MenuItem::linkToCrud('Auteurs', 'fa fa-user', Auteur::class);
        yield MenuItem::linkToCrud('Catégories', 'fa fa-list', Categorie::class);
        yield MenuItem::section('Gestion des Emprunts et Réservations');
        yield MenuItem::linkToCrud('Emprunts', 'fa fa-book', Emprunt::class);
        yield MenuItem::linkToCrud('Réservations', 'fa fa-book', Reservations::class);
        yield MenuItem::section('Gestion des Adhérents');
        yield MenuItem::linkToCrud('Adhérents', 'fa fa-book', Adherent::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-book', Utilisateur::class);
    }
}
