<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Category;
use App\Entity\Course;
use App\Entity\Purchase;
use App\Entity\Module;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        $url = $adminUrlGenerator
            ->setController(\App\Controller\Admin\CourseCrudController::class)
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Course Admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::linkToCrud('Users', 'fa fa-user', User::class);
        yield MenuItem::linkToCrud('Categories', 'fa fa-list', Category::class);
        yield MenuItem::linkToCrud('Courses', 'fa fa-book', Course::class);
        yield MenuItem::linkToCrud('Purchases', 'fa fa-shopping-cart', Purchase::class);
        yield MenuItem::linkToCrud('Modules', 'fa fa-layer-group', Module::class);
    }
}
