# Hackathon Php,Js,Test Unitaire

## Gestion du Planning des employés d'une société de BTP

Ce projet a pour objectif de proposer une solution permettant d’optimiser et de fiabiliser l'affectation des salariés sur les chantiers. Il vise à éliminer les erreurs de planification tout en facilitant le travail administratif afin de garantir une meilleure gestion RH sur le terrain.

### Problématiques 

* Multiples affectations des salariés : De nombreux employés sont assignés à plusieurs chantiers en même temps. Cela crée des conflits d'horaires et entraîne des retards. La gestion actuelle des plannings n'est pas optimisée et engendre une surcharge de travail.

* Inadéquation des compétences et des besoins : Les chantiers ne sont pas toujours adaptés aux compétences des employés, ce qui affecte la qualité, la sécurité et l'efficacité du travail. La planification ne tient pas suffisamment compte des profils des salariés.

* Gestion administrative complexe : L'affectation des salariés nécessite une gestion administrative lourde et la moindre erreur peut entraîner des erreurs de planification, affectant ainsi la productivité globale.

### Fonctionnalités réalisées
* Comme exprimé précédemment, l’entreprise Edifis Pro à besoin d’un outil qui faciliterait sa gestion des plannings de ses employés. Pour répondre à cela, nous avons décidé de développer une solution sous Symfony (très célèbre framework php) qui sera reliée à une base de données relationnelle SQL.

* Afin de mettre en place ce logiciel, nous devons structurer visuellement et par des schémas notre projet.
(L’ensemble des images présentées ci-dessous sont disponibles dans le dossier  du projet) 

* En premier lieu, le maquettage est là pour donner une ligne de mire au projet. Ci-dessous vous trouverez une proposition de l’ensemble des pages du logiciel BatiCrew. C’est à partir de cela qu’on va pouvoir définir nos diagrammes.

* Maquette figma [ici](https://www.figma.com/design/SpaQJTavWMnomgD2EdFy6m/Hackaton?node-id=0-1&p=f)

* Dans un deuxième temps, le diagramme de cas d’utilisation. Ce dernier nous permet d’avoir un visuel d’ensemble sur les interactions entre les acteurs : l’administration et les ouvriers via BatiCrew.

* Diagramme de cas d'utilisation : /diagramme/diagramme_use_case

* Troisièmement, l’ensemble des diagrammes de séquence et d’activité qui permettent de voir comment les différentes parties de l’application communiquent entre elles. C’est en quelque sorte le fil rouge du projet pour les parties les plus complexes. 

* Diagrammes de séquence et d'activité dans le dossier : /diagrammes/diagramme_sequence

* Et pour finir, le diagramme entité-association de notre base de données. Il s’agit là de la partie la plus importante car elle nous permet de visualiser l’agencement des données et de ce que l’application doit retourner à l’utilisateur. 

* Diagramme de classe dans le dossier : /diagrammes/diagramme_classe


### Pré-requis
* Connaissance en HTML, CSS, PHP, JS, Symfony
* Avoir un éditeur avec un terminal intégré

### Démarrage
* Se placer dans le répertoire de travail : ``cd chemin/vers/le/projet``
* Installer les dependances :  ``composer install``
* Penser à définir le port de votre base de donnée dans le ``.env`` -> ``DATABASE_URL``
* Créez la base de données avec ``symfony console doctrine:database:create``
* Mettre à jour avec les commandes :
* ``symfony console make:migration``
* ``symfony console doctrine:migrations:migrate``
* Aller dans le dossier /database/data.sql pour appliquer les valeurs par défaut dans votre BDD.
* Lancer en local :  ``symfony serve``
* Utilisez le compte :
* admin@yopmail.com (mot de passe: 123456789) pour se connecter en tant qu'administrateur
* nathan@yopmail.com (mot de passe: 123456789) pour se connecter en tant qu'ouvrier

### Techno utilisés 
* Symfony

### Auteurs
* **Soumaya GAMBO MAGAGI** _alias_ [@Soumy-lang](https://github.com/Soumy-lang)
* **Jade COTTIN** _alias_ [@Koruji](https://github.com/Koruji)
* **Romain LIÉNARD** _alias_ [@r0om1ain](https://github.com/r0om1ain)
* **Bechir HASSABELKERIM** _alias_ [@kingBechir](https://github.com/kingBechir)

Lisez la liste des [contributeurs](https://github.com/Koruji/Hackaton2025-ipssi/graphs/contributors) pour voir la contribution des membres du groupe !
