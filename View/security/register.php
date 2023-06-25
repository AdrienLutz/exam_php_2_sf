<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Créer un compte !</title>
</head>
<body>
<div class="container">
    <h1>Créer un compte</h1>


    <form method="post">

        <div class="col-md-12">
            <label for="username">Username</label>
            <input id="username" type="text" name="username"
                   value="<?php if(array_key_exists("username",$_POST)){echo($_POST["username"]);} ?>"
                   class="form-control <?php if (array_key_exists('username', $errors)){echo('is-invalid');}?>">
            <div id="validateUsername" class="invalid-feedback">
                <?php if (array_key_exists("username", $errors)) {echo($errors["username"]);}; ?>
            </div>
        </div>

        <div class="col-md-12">
            <label for="nom">Nom *</label>
            <input id="nom" type="text" name="nom"
                   value="<?php if(array_key_exists("nom",$_POST)){echo($_POST["nom"]);} ?>"
                   class="form-control <?php if (array_key_exists('nom', $errors)){echo('is-invalid');}?>">
            <div id="validateNom" class="invalid-feedback">
                <?php if (array_key_exists("nom", $errors)) {echo($errors["nom"]);}; ?>
            </div>
        </div>

        <div class="col-md-12">
            <label for="prenom">Prénom *</label>
            <input id="prenom" type="text" name="prenom"
                   value="<?php if(array_key_exists("prenom",$_POST)){echo($_POST["prenom"]);} ?>"
                   class="form-control <?php if (array_key_exists('prenom', $errors)){echo('is-invalid');}?>">
            <div id="validatePrenom" class="invalid-feedback">
                <?php if (array_key_exists("prenom", $errors)) {echo($errors["prenom"]);}; ?>
            </div>
        </div>

        <div class="col-md-12">
            <label for="password">Mot de passe *</label>
            <input id="password" type="password" name="password"
                   class="form-control <?php if (array_key_exists('password', $errors)){echo('is-invalid');}?>">
            <div id="validatePassword" class="invalid-feedback">
                <?php if (array_key_exists("password", $errors)) {echo($errors["password"]);}; ?>
            </div>
        </div>

        <div class="col-md-12">
            <label for="password">Confirmation du mot de passe *</label>
            <input id="password" type="password" name="confirm_password"
                   class="form-control <?php if (array_key_exists('confirm-password', $errors)){echo('is-invalid');}?>">
            <div id="validatePassword" class="invalid-feedback">
                <?php if (array_key_exists("confirm_password", $errors)) {echo($errors["confirm_password"]);}; ?>
            </div>
        </div>

        <input type="submit" class="btn btn-success m-2">


        <a class="btn btn-outline-warning"
           href="index.php?controller=default&action=home">Home</a>

        <a class="btn btn-outline-warning"
           href="index.php?controller=security&action=login">Retour</a>

    </form>
</div>

<?php
include 'View/parts/footer.php';
?>
<script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous">
</script>