# PJlook
Application de gestion de projet

### A Initialisation du projet

##  1 Cloner le projet
 utliser la commande suivante gith clone https://github.com/promisegandonou/PJlook.git

 cd PJlook

##  2 Exécuter les migrations et les seeders
    php artisan migrate 
    php artisan db:seed

##  3 Démarer le serveur
       Utiliser la commande php artisan serve pour démarer le serveur 

##  4  Accéder au lien 
       L'application s'exécute sur  127.0.0.1:8000

### B Utilisation

## 1 La page de connexion s'affiche dès le lancement de l'application

- Sur cette meme page, vous pouvez vous enrégistrer ou vous connecter. Pour une première utilisation, cliquez sur le bouton s'enrégistrer.

    * Au niveau de la sidebar, accédez à l'onglet Créer un projet.
     Entrez les informations au niveau du formulaire
     Par défaut, l'utilisateur connecté qui à créé le dépot est 'Chef Projet'

# page liste des Projets
L'utilisateur peux voir la liste des projet en cliquant sur le boiuton liste des projets.

Il est redirigé vers une  page qui lui permet d'afficher et de gérer un projet avec différentes sections interactives sous forme d'onglets. L'interface est construite avec Bootstrap et intègre plusieurs fonctionnalités pour la gestion des projets.

## 🏗 Structure de la Vue

La vue est divisée en plusieurs onglets :

### 📌 Informations Générales
Cet onglet affiche les détails essentiels du projet :
- **Statut Actuel** : Indique l'état actuel du projet sous forme de badge.
- **Bouton de modification** (visible uniquement pour les utilisateurs autorisés) permettant de modifier le projet.
- **Cartes récapitulatives** contenant :
  - Le **titre** du projet.
  - La **description** du projet.
  - La **date de début** et la **date de fin prévue**.

![Information générales] https://imgur.com/a/Gbh1raC.png
---

### ✅ Gestion des Tâches
Cet onglet affiche la liste des tâches associées au projet :
- Un tableau interactif listant les tâches avec leur **numéro**, **titre**, **date de début**, **date d’échéance**, et **actions**.

- Un bouton **"Ajouter une tâche"** (accessible aux utilisateurs ayant les droits) permettant de créer une nouvelle tâche. 

![Liste des tâches du projet] https://imgur.com/mHtAj7E.png

En cliquant sur le bouton Afficher, l'on peux accéder à la page de détail des taches avec les différants fichier associer à chaque tache du projet

![Détail de la tache] https://imgur.com/9JuUrJV.png

---

### 📂 Fichiers du Projet
Cet onglet permet de gérer les fichiers attachés au projet :
- Un formulaire permettant de **téléverser** des fichiers et de les associer à une tâche spécifique.
- Une liste affichant les fichiers existants avec la possibilité de les **télécharger** ou de les **supprimer**.

---

### 👥 Membres du Projet
Cet onglet affiche les membres associés au projet :
- Une liste des **membres** avec leur **nom**, **prénom**, et leur **rôle** dans le projet.
- Un bouton permettant **d'inviter de nouveaux membres** (disponible le chef projet uniquement).

  ![Nouvelle invitation envoyée] https://imgur.com/w3g1A5K.png

---

## 🎨 Technologies Utilisées
- **Blade** (Moteur de templates Laravel)
- **Bootstrap** (Framework CSS pour la mise en page et les composants UI)
- **Font Awesome** (Icônes utilisées pour une meilleure lisibilité)
- **jQuery et AJAX** (Gestion des onglets et interactions dynamiques)

## 🔒 Gestion des Permissions
Certaines actions, comme **modifier le projet, ajouter une tâche ou inviter des membres**, sont limitées aux utilisateurs ayant des permissions spécifiques. Seul le **Chef projet peux inviter des membres sur le projet. Le chef Projet et le chef projet adjoint peuvent gérer les taches et les assigner aux membres.

 Lorsque le chef projet soummet le formulaire d'invitation, la personne concernée reçoit un email avec un bouton de confirmation sur lequel il clique pour accepter l'invitation. 

 ![Email d'invitation reçue avec un bouton d'acceptation] https://imgur.com/N1HKzOz.png

---








## Exécuter les commandes  php artisan migrate
## ensuite exécuter la commande php artisan migrate db:seed



## Démarer le projet avec php artisan serve



