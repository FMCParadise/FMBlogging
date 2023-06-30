<?php
// Ce fichier est le tableau de bord qui affiche tous les articles disponibles.

// On se connecte à la base de données
require '../assets/includes/connection.php';

// On démarre la session
session_start();

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['email'])) {
    // Récupérer l'e-mail de l'utilisateur connecté
    $email = $_SESSION['email'];

    // Requête SQL pour sélectionner le nom et le prénom de l'auteur en fonction de l'email
    $sql = 'SELECT lastname, firstname, id FROM authors WHERE email = :email';

    // Préparation de la requête
    $query = $db->prepare($sql);
    $query->bindValue(':email', $email, PDO::PARAM_STR);

    // Exécution de la requête
    $query->execute();

    // Récupération des résultats
    $author = $query->fetch(PDO::FETCH_ASSOC);

    // Requête SQL pour récupérer tous les articles avec leurs catégories
    $sql = "SELECT p.*, GROUP_CONCAT(c.name SEPARATOR ', ') AS categories
            FROM posts p
            LEFT JOIN posts_categories pc ON p.id = pc.posts_id
            LEFT JOIN categories c ON pc.categories_id = c.id
            GROUP BY p.id";

    // Préparation de la requête
    $query = $db->prepare($sql);

    // Exécution de la requête
    $query->execute();

    // Récupération des résultats
    $posts = $query->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil</title>
    <link rel="icon" type="image/x-icon" href="assets/images/cryptopunk0436.png">

    <!-- BOOTSTRAP CSS  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</head>

<body>

    <!-- HEADER -->
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">LE BLOG DES CHAUVELUS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../home.php">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../articles.php">Articles</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Catégories
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="chevelu.php">Chevelu</a></li>
                                <li><a class="dropdown-item" href="non-chevelu">Non-Chevelu</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="trans-chevelu.php">Trans-Chevelu</a></li>
                                
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled">[ BIENTÔT ] - S'abonner à la Hairletter !</a>
                        </li>
                    </ul>
                    <li class="nav-item list-unstyled me-4">
                        <a class="nav-link logout" href="logout.php">Déconnexion</a>
                    </li>
                </div>
            </div>
        </nav>
    </header>

    <!-- MAIN -->
    <main>
        <div class="container">
            <h1 class="text-center my-5">Page d'accueil du blog des chauves luisants !</h1>
            <h4 class="my-3">Bienvenue : <?php echo $author['lastname'] . ' ' . $author['firstname']; ?></h4>
            <div class="row">
                <?php foreach ($posts as $post) { ?>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <img src="assets/images/cryptopunk0436.png" class="card-img-top" alt="Image de l'article">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $post['title']; ?></h5>
                                <p class="card-text"><?php echo substr($post['content'], 0, 200); ?></p>
                                <p class="card-text">Catégories : <?php echo $post['categories']; ?></p>
                                <a href="article.php?id=<?php echo $post['id']; ?>" class="btn btn-primary">Lire l'article</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-light text-center fixed-bottom">
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2023 chauvelus.fr
        </div>
    </footer>

</body>

</html>
