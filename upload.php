<?php
//On vérifie si un fichier a été envoyer 
if(isset($_FILES["image"]) && $_FILES["image"]["error"] === 0){
  //On a recu l'image
  // On procède au vérifications
  // On vérifie toujours l'extension et le type MIME
  $allowed = [
    "jpg" =>"image/jpeg",
    "jpeg" =>"image/jpeg",
    "png" => "image/png"
  ];

   $filename = $_FILES["image"]["name"];
   $filetype = $_FILES["image"]["type"];
   $filesize = $_FILES["image"]["size"];

   $extension = pathinfo($filename, PATHINFO_EXTENSION);
   //On vérifie l'absence de l'extension dans les $allowed ou l'absence du type MIME dans les valeurs
   if(!array_key_exists($extension,$allowed) || !in_array($filetype,$allowed)){
    // Ici soit l'extensio soit le type est incorrect
    die("erreur: format de fichier incorrect");

}

// Ici le type est correct
//On limite a 1Mo
if($filesize> 1024*1024){
    die("fichier trop volumineux");
}
//oN GENERE UN NOM UNIQUE
$newname = md5(uniqid());

//On génère le chemin
$newfilename = __DIR__ . "/assets/upload/$newname.$extension";

if(!move_uploaded_file($_FILES["image"]["tmp_name"],$newfilename)){
    die("l'upload a echoué");
}
//protege du script camouflé dans des images
chmod($newfilename, 0644);

}
  

?>
<!DOCTYPE html>
<html lang="fr">
<head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>upload</title>
    <link rel="icon" type="image/x-icon" href="assets/images/cryptopunk0436.png">
    <!-- BOOSTRAP CSS  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<body>
   <h1>Ajout de fichier </h1>
   <form method="post" enctype="multipart/form-data">
    <div>
     <label for="fichier">Fichier</label>
     <input type="file" name ="image" id="fichier">
    </div>

    <button type="submit">ENVOYER</button>
   </form>

</body>
</html>