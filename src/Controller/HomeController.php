<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PlatformRepository;
use App\Repository\GameRepository;
use App\Repository\AlbumRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PlatformRepository $platforms, GameRepository $games, AlbumRepository $albums): Response
    {
        return $this->render('home/index.html.twig', [
            'platforms' => $platforms->findAll(),
            'games' => $games->findAll(),
            'albums' => $albums->findAll(),
        ]);
    }
}
