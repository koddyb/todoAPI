<?php

// Ce contrôleur se contentera de retourner la vue (le template) qui contiendra votre interface graphique, qui se trouve dans le dossier templates/frontend/index.html.twig

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontendController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        return $this->render('frontend/index.html.twig');
    }
}

