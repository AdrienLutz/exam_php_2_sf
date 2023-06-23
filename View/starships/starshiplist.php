<!--<!doctype html>-->
<!--<html lang="en">-->
<!--<head>-->
<!--    <meta charset="UTF-8">-->
<!--    <meta name="viewport" content="width=device-width, initial-scale=1">-->
<!--    <meta http-equiv="X-UA-Compatible" content="ie=edge">-->
<!--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">-->
<!--    <title>Document</title>-->
<!--</head>-->
<!--<section>-->

<?php
include 'View/parts/header.php';
?>
    <h1>Les vaisseaux</h1>
<a class="btn btn-outline-warning " href="index.php?controller=vaisseaux&action=ajout">Ajouter un vaisseau</a>
    <a class="btn btn-outline-warning " href="index.php?controller=default&action=home">back</a>
    <section class="container"
    <div class="row">

        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">Taille</th>
                <th scope="col">Fonction</th>
                <th scope="col">Picture</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($starships as $starship){
                ?>
                <tr>
                    <th scope="row"><?php echo($starship->getId())?></th>
                    <td><?php echo($starship->getNom())?></td>
                    <td><?php echo($starship->getTaille())?></td>
                    <td><?php echo($starship->getFonction())?></td>
                    <td><img style="max-height: 50px" src="public/img/<?php echo($starship->getPicture())?>" alt="un vaisseau de l'univers star wars"></td>
                    <td>
                        <a href="index.php?controller=vaisseaux&action=detail&id=<?php echo($starship->getId()); ?>">Voir <?php echo($starship->getNom()); ?></a>
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
<script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous">
</script>