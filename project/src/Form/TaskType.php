<?php
namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

// Classe TaskType qui définit le formulaire pour l'entité Task
class TaskType extends AbstractType
{
    // On contruit le formulaire
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Champ "titre" de type texte
            ->add('titre', TextType::class, [
                'label' => 'Titre',
                'attr'  => [ // on attributs le HTML pour le champ
                    'id'          => 'task_titre',
                    'placeholder' => 'Titre de la tâche',
                    'class'       => 'w-full mb-4 bg-gray-700 border border-gray-600 rounded px-4 py-2 text-gray-100'
                ],
            ])
            // Champ "description" de type textarea
            ->add('description', TextareaType::class, [
                'label'    => 'Description',
                'required' => false,
                'attr'     => [
                    'id'          => 'task_description',
                    'placeholder' => 'Description de la tâche',
                    'class'       => 'w-full mb-4 bg-gray-700 border border-gray-600 rounded px-4 py-2 text-gray-100'
                ],
            ])
            // Champ "status" de type choix (dropdown)
            ->add('status', ChoiceType::class, [
                'label'   => 'Statut', 
                'choices' => [ 
                    'En attente' => 'En attente', // Valeur "pending" pour "En attente"
                    'Terminée'   => 'Terminée', // Valeur "completed" pour "Terminée"
                ],
                'attr'    => [ // Attributs HTML pour le champ
                    'id'    => 'task_status',
                    'class' => 'w-full mb-4 bg-gray-700 border border-gray-600 rounded px-4 py-2 text-gray-100' // Classes CSS
                ],
            ])
        ;
    }

    // Méthode pour configurer les options du formulaire
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class, // Associe le formulaire à l'entité Task
        ]);
    }
}
