##  ## ##  ## ## #####  ###### ###### ##  ##
##  ## ### ## ## ##  ## ##  ## ##     ## ## 
##  ## ###### ## #####  ###### ##     ####  
##  ## ## ### ## ##  ## ##  ## ##     ## ## 
###### ##  ## ## #####  ##  ## ###### ##  ##

IO2
Projet de fin de semestre
Groupe 160 : Lionel ALVES VIEIRA, Ilias FADILI, Erwan FROMENT



######################################
###                                ###
###   Comment utiliser UniBack ?   ###
###                                ###
######################################

1. Prérequis :
	Pour commencer, veuillez installer JavaScript sur votre machine. Il est également indispensable d'avoir un outil permettant d'utiliser PHP et SQL. 
	Nous vous conseillons -et utiliserons en tant qu'exemple- XAMPP, un ensemble de logiciels permettant de mettre en place un serveur Web local.
	Les outils de XAMPP nécessaires sont Apache et MySQL.


2. Mise en place de la base de données :
	Une fois que tout est installé, lancez Apache et MySQL, puis tapez "localhost/phpmyadmin" dans la barre de recherche de votre navigateur.
	Sur l'onglet de gauche, cliquez sur "Nouvelle base de données".
	Un nouvel onglet "Création d'une base de données" devrait apparaître devant vous. 
	Tapez "bddres" dans le champ "Nom de base de données" et appuyez sur le bouton "Créer".
	La table devrait être vide. Glissez le fichier SQL fourni dans le dossier : "bddres.sql". 

	Il ne reste plus qu'une étape pour établir la base de données. 
	Sur le même écran, vous devriez trouver une liste d'onglets cliquable en haut.
	Cliquez sur "privilèges", puis ajouter un compte d'utilisateur (en bas) et enfin, entrez respectivement :
		- testadmin
		- localhost
		- 123
		- 123

	Laissez les autres champs vides, puis cochez tout dans "privilèges globaux". 
	Enfin exécutez.

	Bravo, la base de données est maintenant opérationnelle !


3. Lancement du site :
	Pour accéder au site, entrez "localhost/uniBack". 
	Créez votre compte et vous voilà prêt à découvrir UniBack !


4. Mode admin :
	Pour tester le mode admin, tout a déjà été préparé pour vous ! 
	Pour ce faire, rendez-vous sur la page de connexion. 
		-> Il faut au préalable vous déconnecter (le cas échéant).
	
	Enfin, connectez-vous avec le compte suivant :
		- Identifiant : root
		- Mot de passe : admin