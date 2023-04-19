<?php

namespace App\Controller\Admin;

use App\Entity\Geolocation;
use App\Entity\Station;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdminDashboardController extends AbstractDashboardController
{
    public function __construct(
        private Security $security
    )
    {
    }

    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin Dashboard')
            ->disableDarkMode()
            ->generateRelativeUrls();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Return to app', 'fa fa-home', '/');
        if ($this->security->isGranted('ROLE_ADMIN')){
            yield MenuItem::subMenu('Entities', 'fa fa-bars')->setSubItems([
                MenuItem::linkToCrud('Users', 'fas fa-list', UserCrudController::getEntityFqcn()),
                MenuItem::linkToCrud('Stations', 'fas fa-list', Station::class),
                MenuItem::linkToCrud('Geolocations', 'fas fa-list', Geolocation::class),
                MenuItem::linkToCrud('Subscriptions', 'fas fa-list', SubscriptionCrudController::getEntityFqcn()),
                MenuItem::linkToCrud('Contracts', 'fas fa-list', ContractCrudController::getEntityFqcn()),
                MenuItem::linkToCrud('Subscription Types', 'fas fa-list', SubscriptionTypeCrudController::getEntityFqcn())
            ]);
        } else {
            yield MenuItem::linkToCrud('Users', 'fas fa-list', UserCrudController::getEntityFqcn());
            yield MenuItem::linkToCrud('Subscriptions', 'fas fa-list', SubscriptionCrudController::getEntityFqcn());
            yield MenuItem::linkToCrud('Contracts', 'fas fa-list', ContractCrudController::getEntityFqcn());
        }
    }
}
