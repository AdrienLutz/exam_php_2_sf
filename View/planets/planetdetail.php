<?php
include 'View/parts/header.php';
?>
<h1>La planète <?php echo($planet->getNom()); ?></h1>
<a class="btn btn-outline-warning " href="index.php?controller=planetes&action=planetlist">back</a>
<section class="container"
<div class="row">

    <div class="col-lg-4">
        <img class="img-fluid" style="max-height:200px" src="public/img/<?php echo($planet->getPicture()) ?>">
    </div>
    <div class="col-lg-4">
        <h2>Les infos concernant <?php echo($planet->getNom()); ?></h2>
        <li>Description = <?php echo($planet->getDescription()); ?></li>
        <li>Terrain = <?php echo($planet->getTerrain()); ?></li>
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