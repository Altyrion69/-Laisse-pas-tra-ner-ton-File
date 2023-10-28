<?php

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // controle du formulaire 
  if (!isset($_POST['firstname']) || trim($_POST['firstname']) === '')
    $errors[] = "⚠️ Le prénom est obligatoire";
  if (!isset($_POST['lastname']) || trim($_POST['lastname']) === '')
    $errors[] = "⚠️ Le nom est obligatoire";
  if (!isset($_POST['dateOfBirth']) || trim($_POST['dateOfBirth']) === '')
    $errors[] = "⚠️ La date de naissance est obligatoire";

  $uploadDir = 'public/uploads/';
  
  $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);
  
  $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
  
  $authorizedExtensions = ['jpg', 'png', 'gif', 'webp'];
  
  $maxFileSize = 1048576;




  if ((!in_array($extension, $authorizedExtensions))) {
    $errors[] = '⚠️ Veuillez sélectionner une image de type Jpg , png , gif ou webp !';
  }

  
  if (file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize) {
    $errors[] = "⚠️ Votre fichier doit faire moins de 1Mo !";
  }

  //si tout est ok
  if (empty($errors)) {

    $uniqueFileName = uniqid('avatar') . '.' . $extension;
    $uploadFile = $uploadDir . $uniqueFileName;
    move_uploaded_file($_FILES['avatar']['name'], $uploadFile);
    
    echo '<span style="font-size : 50px; color: green">' . "🎊 Merci, tout a bien été enregistrer 🎊" . '</span>';
  }
}



?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulaire</title>
</head>

<body>


  <form method="post" enctype="multipart/form-data">

    <fieldset>
      <h1>Formulaire</h1>
      <?php // Affichage des éventuelles erreurs 
      if (count($errors) > 0) : ?>
        <div>
          <ul>
            <?php foreach ($errors as $error) : ?>
              <li><?= $error ?></li>
            <?php endforeach; ?>
      <?php endif; ?>

      <label for="lastname" placeholder="Prénom" required>Nom</label>
      <input type="text" id="lastname" name="lastname" /></br>

      <label for="firstname" placeholder="Nom" required>Prénom</label>
      <input type="text" id="firstname" name="firstname" /></br>

      <label for="dateOfBirth">Date de naissance</label>
      <input type="date" id="dateOfBirth" name="dateOfBirth" /></br>

    </fieldset>

    <label for="imageupload">Uploader une image</label>
    <input type="file" name="avatar" id="imageUpload" /></br>
    <button type="submit" name="send">Envoyer</button>

  </form>
</body>

</html>