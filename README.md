# API REST de TodoList avec Symfony et Docker pour gerer l'environement et les dependances



## Set up le projet, ça ne demande pas beacoup 😅  

Cloner le projet

~~~bash  
  git clone https://github.com/koddyb/todoAPI.git
~~~

Naviguer dans le repertoire du projet

~~~bash  
  cd todoAPI
~~~

Demarer les services dans docker (ça prendras un peu de temps pour construire les images) 

~~~bash  
docker-compose up -d --build
~~~

Accerder au projet symfony

~~~bash  
npm run startdocker exec -it php-fpm bash
~~~

mettre à jours les dépendences 

~~~bash
composer update
~~~

Effectuer les migrations vers la base de donneé
~~~bash
symfony console doctrine:database:create

symfony console make:migration

symfony console doctrine:migrations:migrate
~~~

une fois tout installer vous pouvez lancer l'API 
