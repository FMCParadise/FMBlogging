<?php
// Fichier index.php qui contient le formulaire de connexion

require 'assets/includes/connection.php';
session_start();

$error_message = ""; // Définition de la variable $error_message avec une valeur par défaut pour afficher l'erreur

// On vérifie si les champs sont vides
if (!empty($_POST['email']) && !empty($_POST['password'])) {
	$email = $_POST['email'];
	$password = $_POST['password'];

	// On écrit le SQL
	$sql = 'SELECT * FROM authors WHERE email = :email';
	// prepare
	$query = $db->prepare($sql);

	// bind
	$query->bindValue(':email', $email, PDO::PARAM_STR);

	// execute
	$query->execute();

	$author = $query->fetch(PDO::FETCH_ASSOC);

	if ($author && password_verify($password, $author['password'])) {
		// Créer une session pour l'utilisateur avec l'email comme identifiant
		$_SESSION['email'] = $author['email'];

		// Rediriger vers home.php
		header('Location: home.php');
		exit();
	} else {
		// Erreur
		$error_message = "Vous avez saisi un identifiant ou un mot de passe invalide. Veuillez les ressaisir.";
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
		<h3>CONNEXION</h3>
		<div class="mt-4">
			<form method="POST">
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
					<button type="submit" class="btn btn-primary">Me connecter</button>
				</div>
				<a href="registration.php">M'enregistrer</a>
			</form>
		</div>
	</div>
</body>

</html>