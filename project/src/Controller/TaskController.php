<?php

namespace App\Controller;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/tasks')]
class TaskController extends AbstractController
{
    // Création d'une tâche. Endpoint : POST /api/tasks

    #[Route('', name: 'create_task', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return new JsonResponse(['error' => 'JSON invalide'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $titre = $data['titre'] ?? null;
        $description = $data['description'] ?? null;
        $status = $data['status'] ?? null;

        // on verifie que les champs obligatoires sont présents, la verification peu etre faite coté client
        if (!$titre || !$status) {
            return new JsonResponse(['error' => 'Les champs titre et status sont obligatoires'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $task = new Task();
        $task->setTitre($titre);
        $task->setDescription($description);
        $task->setStatus($status);

        $entityManager->persist($task);
        $entityManager->flush();

        return new JsonResponse([
            'message' => 'Tâche créée avec succès',
            'task'    => [
                'id'          => $task->getId(),
                'titre'       => $task->getTitre(),
                'description' => $task->getDescription(),
                'status'      => $task->getStatus()
            ]
        ], JsonResponse::HTTP_CREATED);
    }

    // Liste de toutes les tâches. Endpoint : GET /api/tasks
    #[Route('', name: 'list_tasks', methods: ['GET'])]
    public function list(EntityManagerInterface $entityManager): JsonResponse
    {
        $tasks = $entityManager->getRepository(Task::class)->findAll();

        $data = [];
        foreach ($tasks as $task) {
            $data[] = [
                'id'          => $task->getId(),
                'titre'       => $task->getTitre(),
                'description' => $task->getDescription(),
                'status'      => $task->getStatus()
            ];
        }

        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }

    // Mise à jour du statut d'une tâche existante. Endpoint : PUT /api/tasks/{id}
     
    #[Route('/{id}', name: 'update_task', methods: ['PUT'])]
    public function update(int $id, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $task = $entityManager->getRepository(Task::class)->find($id);
        if (!$task) {
            return new JsonResponse(['error' => 'Tâche non trouvée'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        if (!$data) {
            return new JsonResponse(['error' => 'JSON invalide'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $status = $data['status'] ?? null;
        if (!$status) {
            return new JsonResponse(['error' => 'Le champ status est obligatoire'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $task->setStatus($status);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Tâche mise à jour avec succès'], JsonResponse::HTTP_OK);
    }

    
    // Suppression d'une tâche. Endpoint : DELETE /api/tasks/{id}
    #[Route('/{id}', name: 'delete_task', methods: ['DELETE'])]
    public function delete(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $task = $entityManager->getRepository(Task::class)->find($id);
        if (!$task) {
            return new JsonResponse(['error' => 'Tâche non trouvée'], JsonResponse::HTTP_NOT_FOUND);
        }

        $entityManager->remove($task);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Tâche supprimée avec succès'], JsonResponse::HTTP_OK);
    }
}
