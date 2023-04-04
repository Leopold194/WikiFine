# WikiFine Project from "Les Gagnants's"

## Les règles pour merge une Pull Request
### Créer une branche
**Toujours créer une branche avant tout développement d'un _Work Item_ !**
#### Démarche à suivre:
1. Sur Visual Studio Code, dans le sous menu de l'onglet Git :
    - Branche -> Créer une branche à partir de... -> Insérer le nom de la branche.
##### Écriture de la branche
Il faut être  rigoureux lors de l'écriture de la branche, ça permettra de retrouver plus vite les commit et apporter de l'aide en cas de besoin.</br>
Il faut toujours commencer par **"users"**/**"votre pseudo"**(à ne pas changer par la suite)/**"L'intitulé de votre tâche"**.</br></br>
Exemple: 
> users/zadde/update-README

Après avoir choisi le nom, il faut sélectionner comme référence **"MAIN"**.</br>
Après cette étape vous serez prêt à développer !

## Les règles pour créer une nouvelle page du site
### Importer les templates
**Créer un nouveau fichier .php dans le dossier pages**</br>
*Ajouter en haut du nouveau fichier :*
<?php require 'templates/head.php'; ?>
Ajouter entre les deux, les balises link pour lier le fichier CSS utilisé pour uniquement votre page
<?php require 'templates/navbar.php'; ?>
Commencer directement l'intérieur de la balise body sans mettre la balise ouvrante
*Cloturer votre fichier par les balises ouvrantes et fermantes de body et html*
