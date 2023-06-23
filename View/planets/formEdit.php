<?php
include 'View/parts/header.php';
?>
<h1>Modifier la planète <?php echo($planet->getNom()); ?></h1>

<a class="btn btn-outline-warning m-2 " href="index.php?controller=planetes&action=planetlist">back</a>
<section class="container">
    <div class="row">"
        <form method="post"  enctype="multipart/form-data" class="row">
            <div class="col-md-12">
                <label for="nom" class="form-label">Nom de la planète</label>

                <input type="text" name="nom" class="form-control <?php
                if (array_key_exists("nom", $errors)) {
                    echo('is-invalid');
                }
                ?>" value="<?php echo($planet->getNom()); ?>" id="nom">

                <div id="validateNom" class="invalid-feedback">
                    <?php
                    if (array_key_exists("nom", $errors)) {
                        echo($errors["nom"]);
                    };
                    ?>
                </div>
            </div>

            <div class="col-md-12">
                <label for="Description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="Description">
                    <?php echo($planet->getDescription()); ?>
                </textarea>
            </div>

            <div class="col-md-12">
                <label for="validationCustom04" class="form-label">Terrain</label>
                <select class="form-select
                 <?php  if(array_key_exists("terrain", $errors)){echo('is-invalid');}?>" name="terrain" id="validationCustom04">
                    <option  value="">Pas d'infos</option>
                    <?php
                    foreach (PlanetController::$allowedTerrain as $terrain){
                        $selected = '';
                        if($planet->getTerrain() == $terrain){
                            $selected = 'selected';
                        }
                        echo('<option '.$selected.' value="'.$terrain.'">'.$terrain.'</option>');
                    }
                    ?>
                </select>
                <div class="invalid-feedback">
                    <?php  if(array_key_exists("terrain", $errors)){echo($errors["terrain"]);}?>
                </div>
            </div>


            <div class="col-md-12">
                <span>Aperçu de l'image actuelle</span><br>
                <img class="img-thumbnail" src="public/img/<?php echo($planet->getPicture())?>"><br>
                <span>Attention tout ajout écrase le précédent</span><br>
                <label for="picture" class="form-label">Photo</label>
                <input type="file" name="picture" class="form-control
            <?php if(array_key_exists("picture", $errors)){echo('is-invalid');}?>" id="picture">
                <div class="invalid-feedback">
                    <?php if(array_key_exists("picture", $errors)){echo($errors["picture"]);}?>
                </div>
            </div>


            <div class="col-12">
                <button class="btn btn-outline-warning m-2" type="submit">Valider</button>
            </div>
        </form>
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