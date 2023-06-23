<?php
include 'View/parts/header.php';
?>
<h1>Les planètes</h1>
<a class="btn btn-outline-warning " href="index.php?controller=planetes&action=ajout">Ajouter une planète</a>
<a class="btn btn-outline-warning " href="index.php?controller=default&action=home">Retour</a>
<br>

<!--autre façon de faire le bouton-->
<!--<a href="index.php?controller=default&action=home">-->
<!--<button class="btn btn-outline-warning"> back2 </button></a>-->
<section class="container">
    <div class="row">

        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">Description</th>
                <th scope="col">Terrain</th>
                <th scope="col">Picture</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($planets as $planet) {
                ?>
                <tr>
                    <th scope="row"><?php echo($planet->getId()) ?></th>
                    <td><?php echo($planet->getNom()) ?></td>
                    <td><?php echo($planet->getDescription()) ?></td>
                    <td><?php echo($planet->getTerrain()) ?></td>
                    <td><img style="max-height: 50px" src="public/img/<?php echo($planet->getPicture()) ?>" alt="une planete"></td>
                    <td>
                        <a href="index.php?controller=planetes&action=detail&id=<?php echo($planet->getId()); ?>">Voir <?php echo($planet->getNom()); ?></a>
                        <br>
                        <a href="index.php?controller=planetes&action=update&id=<?php echo($planet->getId()); ?>">Mettre à jour <?php echo($planet->getNom()); ?></a>
                        <br>
                        <a href="index.php?controller=planetes&action=delete&id=<?php echo($planet->getId()); ?>">Supprimer la planète <?php echo($planet->getNom()); ?></a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</section>
<?php
include 'View/parts/footer.php';
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
