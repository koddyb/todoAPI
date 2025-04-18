<?php

// Ce contrôleur se contentera de retourner la vue (le template) qui contiendra votre interface graphique, qui se trouve dans le dossier templates/frontend/index.html.twig
namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontendController extends AbstractController
{
    #[Route('/', name: 'frontend_index')]
    public function index(EntityManagerInterface $em): Response
    {
        // on passe un formulaire vide a la vue
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        return $this->render('frontend/index.html.twig', [
            'taskForm' => $form->createView(),
        ]);
    }
}

