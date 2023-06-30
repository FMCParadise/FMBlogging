<?php
// Ce fichier enregistre un utilisateur sur la base de données

// On se connecte à la base de données
require 'assets/includes/connection.php';
//Cette méthode registerUser() vérifie si les champs requis (lastname, firstname, email, password, gpdr) 
//ont été soumis via la méthode POST. Si tous les champs sont remplis, les valeurs sont attribuées aux propriétés
// correspondantes de la classe.

// Ce fichier enregistre un utilisateur sur la base de données

class UserRegistration
{
	private $lastname;
	private $firstname;
	private $email;
	private $password;
	private $gpdr;
	private $db;

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function registerUser()
	{
		// On vérifie si les champs sont vides
		if (!empty($_POST['lastname']) && !empty($_POST['firstname']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['gpdr'])) {
			$this->lastname = $_POST['lastname'];
			$this->firstname = $_POST['firstname'];
			$this->email = $_POST['email'];
			$this->password = $_POST['password'];
			$this->gpdr = $_POST['gpdr'];
		}
	}

	private function validatePasswordCriteria()
	{
		$tableau = [];

		if (!preg_match('/[A-Z]/', $this->password)) {
			$tableau[] = 'Le mot de passe doit contenir au moins une lettre majuscule (Uppercase missing).';
			return false;
		}

		if (!preg_match('/[0-9]/', $this->password)) {
			$tableau[] = 'Le mot de passe doit contenir au moins un chiffre (Number missing).';
			return false;
		}

		if (!preg_match('/[!@#$%^&*]/', $this->password)) {
			$tableau[] = 'Le mot de passe doit contenir au moins un caractère spécial (Special char missing).';
			return false;
		}

		if (strlen($this->password) < 16) {
			$tableau[] = 'Le mot de passe est trop court, il doit contenir au moins 16 caractères ';
		}
		if (!$this->validatePasswordCriteria()) {
		}


		// Vérification des critères du mot de passe
		//Cette ligne appelle la méthode validatePasswordCriteria() pour vérifier si le mot de passe respecte certains critères. 
		//Si la méthode renvoie false, le script s'arrête avec exit(), 
		//affichant un message d'erreur.

		// Erreur
		if (!empty($_POST)) {
			echo "Veuillez remplir tous les champs obligatoires et accepter les conditions.";
		}

		// On hash le mot de passe
		//Ces lignes préparent et exécutent une requête SQL pour
		// insérer les données de l'utilisateur dans la table advisors de la base de données. 
		//Les valeurs des propriétés sont liées aux paramètres de la requête pour éviter les injections SQL.

		$hash = password_hash($this->password, PASSWORD_ARGON2ID);

		// On écrit le SQL pour créer un nouvel auteur
		$sql = "INSERT INTO  `authors` (`lastname`, `firstname`, `email`, `password`, `gpdr`) VALUES (:lastname, :firstname, :email, :hash, :gpdr)";

		// prepare
		$query = $this->db->prepare($sql);

		// bind
		$query->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
		$query->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
		$query->bindValue(':email', $this->email, PDO::PARAM_STR);
		$query->bindValue(':hash', $hash, PDO::PARAM_STR);
		$query->bindValue(':gpdr', $this->gpdr, PDO::PARAM_BOOL);

		// execute
		$query->execute();

		// Créer une session pour l'utilisateur
		session_start();
		$_SESSION['email'] = $this->email; // utiliser l'e-mail comme identifiant

		// Rediriger vers home.php
		header('Location: home.php');
		exit();
	}
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Me connecter</title>
	<link rel="icon" type="image/x-icon" href="assets/images/cryptopunk0436.png">
	<!-- BOOSTRAP CSS  -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
	<!-- BOOTSTRAP JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container">
			<a class="navbar-brand" href="#">LE BLOG DES CHAUVELUS</a>
		</div>
	</nav>
	<div class="container">
		<div class="mt-4"></div>
		<h3>INSCRIPTION</h3>
		<div class="mt-4">
			<form method="POST">

				<div class="mb-3">
					<label for="text" class="form-label">Nom de Famille :</label>
					<input type="text" name="lastname" class="form-control" id="lastname" />
				</div>

				<div class="mb-3">
					<label for="text" class="form-label">Prénom :</label>
					<input type="text" name="firstname" class="form-control" id="firstname" />
				</div>

				<div class="mb-3">
					<label for="email" class="form-label">Email :</label>
					<input type="email" name="email" class="form-control" id="email" />
				</div>


				<div class="mb-3">
					<label for="password" class="form-label">Mot de passe :</label>
					<input type="password" name="password" class="form-control" id="password" />
				</div>

				<?php if (!empty($error_message)) : ?>
					<div class="mb-3 errormsg"><?php echo $error_message; ?></div>
				<?php endif; ?>
				<div class="mb-3">
					<button type="submit" class="btn btn-primary">M'inscrire</button>
				</div>
				<a href="registration.php">M'enregistrer</a>
			</form>
		</div>
	</div>
</body>

</html>