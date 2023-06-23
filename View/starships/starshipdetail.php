<?php
include 'View/parts/header.php';
?>
<h1>Les vaisseaux<?php echo($starship->getNom()); ?></h1>
<a class="btn btn-outline-warning " href="index.php?controller=vaisseaux&action=starshiplist">back</a>
<section class="container"
<div class="row">

    <div class="col-lg-4">
        <img class="img-fluid" style="max-height:200px" src="public/img/<?php echo($starship->getPicture()) ?>">
    </div>
    <div class="col-lg-4">
        <h2>Les infos concernant <?php echo($starship->getNom()); ?></h2>
        <li>Fonction = <?php echo($starship->getFonction()); ?></li>
        <li>Taille = <?php echo($starship->getTaille()); ?></li>
    </div>
</div>
</section>
<?php
include 'View/parts/footer.php';
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>
</html>