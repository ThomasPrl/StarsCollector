<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use App\Entity\Star;
use App\Entity\Space;
use App\Entity\Member;
use App\Entity\Sky;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(SpaceCrudController::class)->generateUrl();
        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('StarsCollector');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Menu', 'fa fa-home');
        yield MenuItem::linkToCrud('Stars', 'fas fa-list', Star::class);
        yield MenuItem::linkToCrud('Space', 'fas fa-list', Space::class);
        yield MenuItem::linkToCrud('Member', 'fas fa-list', Member::class);
        yield MenuItem::linkToCrud('Sky', 'fas fa-list', Sky::class);
    }
}
