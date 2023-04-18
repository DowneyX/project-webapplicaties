<?php

namespace App\Controller\AdministrativeUser;

use App\Controller\Admin\ContractCrudController;
use App\Controller\Admin\SubscriptionCrudController;
use App\Controller\Admin\UserCrudController;
use App\Entity\Geolocation;
use App\Entity\Station;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdministrativeUserDashboardController extends AbstractDashboardController
{
    #[Route('/administrative-dashboard', name: 'app_administrative_user')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Administrative User Dashboard')
            ->disableDarkMode()
            ->generateRelativeUrls();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Return to app', 'fa fa-home', '/');
        yield MenuItem::linkToCrud('Users', 'fas fa-list', UserCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud('Subscriptions', 'fas fa-list', SubscriptionCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud('Contracts', 'fas fa-list', ContractCrudController::getEntityFqcn());
    }
}
