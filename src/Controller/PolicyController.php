<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PolicyController extends AbstractController
{
    #[Route('/the-end-of-an-age/policy', name: 'teoaa_policy')]
    public function teoaa(): Response
    {
        return $this->render('policy/index.html.twig', [
            'controller_name' => 'PolicyController',
            'app_name' => 'The End of an Age',
        ]);
    }

    #[Route('/falling/policy', name: 'falling_policy')]
    public function falling(): Response
    {
        return $this->render('policy/index.html.twig', [
            'controller_name' => 'PolicyController',
            'app_name' => 'falling',
        ]);
    }
}
