<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Platform;
use App\Entity\Game;
use App\Entity\Album;
use App\Entity\Song;
use App\Entity\Website;
use App\Entity\Video;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Portfolio')
            ->generateRelativeUrls();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Back to the website', 'fa fa-home', '/');
        yield MenuItem::linkToDashboard('Dashboard', 'fa ...');
        yield MenuItem::linkToUrl('Log out', 'fa ...', '/logout');
        yield MenuItem::section();
        yield MenuItem::linkToCrud('Platform', 'fas fa-list', Platform::class);
        yield MenuItem::linkToCrud('Game', 'fas fa-list', Game::class);
        yield MenuItem::linkToCrud('Album', 'fas fa-list', Album::class);
        yield MenuItem::linkToCrud('Song', 'fas fa-list', Song::class);
        yield MenuItem::linkToCrud('Website', 'fas fa-list', Website::class);
        yield MenuItem::linkToCrud('Video', 'fas fa-list', Video::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
