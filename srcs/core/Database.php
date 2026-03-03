<?php

## Mise en place du PDO (PHP Data Objects)
## On fait la liaison entre PHP et MariaDB car ils parlent pas la même langue
## PDO est une interface native de PHP, qui va servir de pont
## Il va permettre de lutter contre les injections SQL. 
## Les requêtes sont préparées, au lieu d'insérer les mots du user dans la requête, 
## le PDO envoie d'abord la structure de la requête à la base de données
## puis il envoie ensuite les données du user séparement 

## On doit récupérer les valeurs des données de notre .env 
## PHP peut lire les variables nativement

class Database {

	## On stocke notre PDO en private pour le réutiliser plus tard
	private $pdo;

	function __construct() {
		$host = getenv('DB_HOST');
		$name = getenv('DB_NAME');
		$port = getenv('DB_PORT');
		$user = getenv('DB_USER');
		$pwd = getenv('DB_PASS');

		## Notre PDO a besoin d'une adresse formatée spécifiquement
		## Ça lui permet de savoir où se connecter = dsn (data source name)
		$dsn = 'mysql:' . 'host=' . $host . ';dbname=' . $name . ';port=' . $port;

		## On donne des options de sécurité à notre PDO
		## 1. Déclenchement des execeptions quand une requête SQL échoue
		## 2. Renvoi des données de la base en tableau associatif
		## les clés sont les noms des colonnes de la table
		$options = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		];
		
		## On lance un try and catch pour éviter les erreurs fatales
		## lors de la connection à la base de données
		try {

			## On créé une nouvelle isntance de PDO
			## On lui donne notre dsn, user et password
			$this->pdo = new PDO($dsn, $user, $pwd, $options);

		} catch (PDOException $error) {
			echo 'Error connecting on database';
			die();
		}
	}

	public function getConnection() {
		return $this->pdo;
	}
}