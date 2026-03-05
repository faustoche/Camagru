<?php

class HomeController {
	public function index() {

		## Démarrage de la temporisation de sortie 
		## Mise en pause de l'affichage
		ob_start();

		## On charge la vue qu'on veut 
		require_once __DIR__ . '/../views/home.php';

		# Récupération du contenu mis en mémoire dans la variable $content
		## Nettoyage du tampon
		$content = ob_get_clean();

		## Appel du layout général qui va lire $content et l'afficher
		require_once __DIR__ . '/../views/layout.php';
	}
}