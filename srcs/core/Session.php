<?php

/*
Le protocole HTTP est fondamentalement "sans état" (stateless). Cela signifie que chaque requête envoyée par 
le navigateur au serveur est traitée de manière totalement indépendante. 
Le serveur n'a aucune mémoire des requêtes précédentes : 
il ne peut pas savoir, par défaut, si l'utilisateur qui demande la page B est le même que 
celui qui vient de s'authentifier sur la page A.

Le mécanisme de session résout ce problème structurel :
Il permet de stocker des variables (les données de l'utilisateur) de manière sécurisée côté serveur.
Il génère un identifiant unique de session, qui est transmis au navigateur (généralement via un cookie).
Lors des requêtes suivantes, le navigateur renvoie cet identifiant, permettant au serveur de retrouver les variables associées et de "reconnaître" l'utilisateur.
*/

class Session {

	## La gestion des sessions représente une fonctionnalité globale 
	## au sein de l'application. Instancier un nouvel objet Session 
	## à chaque lecture ou écriture de donnée serait redondant et inefficace. 
	## L'utilisation de méthodes statiques permet d'invoquer ces fonctions 
	## directement depuis n'importe quel emplacement de l'architecture 
	## (routeur, contrôleur, etc.) en agissant comme une boîte à outils utilitaire globale.
	public static function start() {

		$status = session_status();
		if ($status == PHP_SESSION_NONE) {
			session_start();
		}
	}

	## Besoin d'une variable globale $_SESSION
	## La clé sera les infos de session, et on stocke la valeur
	## par exemple: clé = id => valeur = 15
	public static function set(string $key, $value) {
		$_SESSION[$key] = $value;
	}


	public static function get(string $key) {
		return $_SESSION[$key] ?? null;
	}

	public static function destroy() {
		session_destroy();
	}
}