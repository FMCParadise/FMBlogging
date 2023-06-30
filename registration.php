<?php
// Ce fichier enregistre un utilisateur sur la base de données

// On se connecte à la base de données
require 'assets/includes/connection.php';

$tableau = [];

// On vérifie si les champs sont vides
if (!empty($_POST['lastname']) && !empty($_POST['firstname']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['gpdr'])) {
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gpdr = $_POST['gpdr'];

    // Vérification des critères du mot de passe
    if (!preg_match('/[A-Z]/', $password)) {
        $tableau = ['Le mot de passe doit contenir au moins une lettre majuscule (Uppercase missing).'];
    }

    if (!preg_match('/[0-9]/', $password)) {
        $tableau = [' Le mot de passe doit contenir au moins un chiffre (Number missing).'];
    }

    if (!preg_match('/[!@#$%^&*]/', $password)) {
        $tableau = ['Le mot de passe doit contenir au moins un caractère spécial (Special char missing).'];
    }

    if (strlen($password) < 16) {
        $tableau = ['Le mot de passe est trop court, il doit contenir au moins 16 caractères (Too short, password must be at least 16 characters long).'];

    }

    if (empty($tableau)) {
        $hash = password_hash($password, PASSWORD_ARGON2ID);

        $sql = "INSERT INTO  `authors` (`lastname`,`firstname`, `email`, `password`, `gpdr`) VALUES (:lastname, :firstname, :email, :hash, :gpdr)";

        $query = $db->prepare($sql);

        $query->bindValue(':lastname', $lastname, PDO::PARAM_STR);
        $query->bindValue(':firstname', $firstname, PDO::PARAM_STR);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->bindValue(':hash', $hash, PDO::PARAM_STR);
        $query->bindValue(':gpdr', $gpdr, PDO::PARAM_BOOL);

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
    <title>M'INSCRIRE</title>
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


<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>M'INSCRIRE</title>
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

				
				<div class="form-check">
					<input class="form-check-input" name="gpdr"  type="checkbox" value="1" id="flexCheckDefault">
					<label class="form-check-label" for="flexCheckDefault">
						RGPD
					</label>
				</div><br>




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