<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PlatformRepository;
use App\Repository\GameRepository;
use App\Repository\AlbumRepository;
use App\Repository\WebsiteRepository;
use App\Repository\VideoRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PlatformRepository $platforms, GameRepository $games, AlbumRepository $albums, WebsiteRepository $websites, VideoRepository $videos): Response
    {
        return $this->render('home/index.html.twig', [
            'platforms' => $platforms->findAll(),
            'games' => $games->findAll(),
            'albums' => $albums->findAll(),
            'videos' => $videos->findAll(),
            'websites' => $websites->findAll(),
        ]);
    }

    #[Route('/3d', name: 'app_3d')]
    public function threeD(): Response
    {
        return $this->render('home/3d.html.twig');
    }
}
