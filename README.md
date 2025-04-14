# API REST de TodoList avec Symfony et Docker pour gerer l'environement et les dependances

> [!IMPORTANT]
> Vous devez avoir docker🐋 d'installer dans votre Ordi

## Set up le projet, ça ne demande pas beacoup @-@  

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
~~~
~~~bash
symfony console make:migration
~~~
~~~bash
symfony console doctrine:migrations:migrate
~~~
> [!NOTE]
> Si vous avez des erreurs sur des bases de données déja crées ou existantes?
> pas d'inquiétude,
> ### conitnuez
> Assurez vous de n'avoir aucun serveur lancer sur localhost!

une fois tout Terminer vous pouvez lancer l'API http://localhost/ 
