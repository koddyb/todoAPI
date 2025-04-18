document.addEventListener('DOMContentLoaded', () => {
    // URL de l'API pour les tâches
    const apiUrl = '/api/tasks';
    const form   = document.getElementById('create-task-form');//On récupere le formulaire par son id
  
    // on vérifie si le formulaire existe
    if (!form) {
      console.error('Formulaire #create-task-form introuvable');
      return;
    }
  
    // La Fonction pour récuperer et afficher les tâches
    const fetchTasks = () => {
      fetch(apiUrl) // Appel a l'API pour récupérer les tâches
        .then(res => res.json()) // Conversion de la eéponse en JSON
        .then(data => {
          const ul = document.getElementById('tasks'); // Liste des tâches
          ul.innerHTML = ''; // Réinitialise le contenu de la liste
          data.forEach(t => { // Parcours chaque tache
            const li = document.createElement('li'); // Crée les elements pour chaque tâche
            li.className = 'bg-gray-800 p-6 rounded-lg shadow-lg flex justify-between items-center';
            //Div pour chaques tâches
            li.innerHTML = `
              <div>
                <h3 class="text-xl font-bold">${t.titre}</h3> <!-- Titre de la tâche -->
                <p class="text-gray-400">${t.description || ''}</p> <!-- Description de la tâche -->
                <p class="text-sm">${t.status}</p> <!-- Statut de la tâche -->
              </div>
              <div>
                <!-- Bouton pour mettre à jour la tâche -->
                <button data-id="${t.id}" class="update-btn bg-green-600 hover:bg-green-700 text-white py-1 px-3 rounded mr-2">
                  Mettre à jour
                </button>
                <!-- Bouton pour supprimer la tâche -->
                <button data-id="${t.id}" class="delete-btn bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded">
                  Supprimer
                </button>
              </div>`;
            ul.appendChild(li); // on ajoute l'element li a la liste
          });
          attachListeners(); // on attache les événements aux boutons
        })
        .catch(console.error); // on gère les erreurs
    };
  
    //Fonction pour attacher les événements aux boutons
    const attachListeners = () => {
      // Bouttons de suppression
      document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.onclick = () => {
          if (!confirm('Voulez-vous vraiment supprimer ?')) return; // Confirmation avant la suppression
          fetch(`${apiUrl}/${btn.dataset.id}`, { method: 'DELETE' }) // Appel API pour supprimer
            .then(() => fetchTasks()) // On Recharge la suppression
            .catch(console.error);
        };
      });
    
      // Boutton de mise à jour
      document.querySelectorAll('.update-btn').forEach(btn => {
        btn.onclick = () => {
          const li      = btn.closest('li'); 
          const current = li.querySelector('p.text-sm').innerText.trim(); 
          const status  = (current === 'Terminée' ? 'En attente' : 'Terminée'); // On alterne le statut 
          fetch(`${apiUrl}/${btn.dataset.id}`, {
            method:  'PUT', // Appel API pour mettre a jour
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify({ status }) // On envoie le nouveau statut
          })
          .then(() => fetchTasks()) // On recharge les taches après la mise a jour
          .catch(console.error);
        };
      });
    };
  
    // Gestion de la soumission du formulaire
    form.addEventListener('submit', e => {
      e.preventDefault(); 
  
      // Récupère les champs du formulaire
      const titreEl       = document.getElementById('task_titre');
      const descriptionEl = document.getElementById('task_description');
      const statusEl      = document.getElementById('task_status');
  
      // on vérifie si les champs nécessaires existent
      if (!titreEl || !statusEl) {
        console.error('Champs du formulaire introuvables');
        return;
      }
  
      // on préparerépare les données à envoyer
      const data = {
        titre:       titreEl.value,
        description: descriptionEl.value,
        status:      statusEl.value
      };
  
      // Appel de l'API pour créer une nouvelle tâche
      fetch(apiUrl, {
        method:  'POST',
        headers: { 'Content-Type': 'application/json' },
        body:    JSON.stringify(data) // On envoie les données au serveur 
      })
      .then(() => {
        form.reset(); 
        fetchTasks(); 
      })
      .catch(console.error);
    });
  
    // chargement initial des taches
    fetchTasks();
});