<?php
// Ce fichier connecte la base de données
// Constantes permettant la connexion
const DBHOST = 'localhost';
const DBNAME = 'blog';
const DBUSER = 'root';
const DBPASS = '';

// Ne rien modifier ci-dessous !!!!
$dsn = 'mysql:host=' . DBHOST . ';dbname=' . DBNAME;

// On essaie de se connecter
try {
	// On "instancie" la connexion
	$db = new PDO($dsn, DBUSER, DBPASS);

	// On configure les transactions SQL en UTF-8
	$db->exec('SET NAMES utf8');
} catch (PDOException $exception) {
	// Ici ça n'a pas fonctionné
	echo 'Une erreur est survenue : ' . $exception->getMessage();
	// On stoppe l'exécution du PHP
	die;
}
