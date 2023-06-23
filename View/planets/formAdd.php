<?php
include 'View/parts/header.php';
?>
<h1>Ajouter une planète</h1>

<a class="btn btn-outline-warning m-2 " href="index.php?controller=planetes&action=planetlist">back</a>
<section class="container">
    <div class="row">
<!--        enctype est indispensable pour les uploads-->
        <form method="post" enctype="multipart/form-data" class="row">
            <div class="col-md-12">
                <label for="nom" class="form-label">Nom :</label>
                <input type="text"
                       value="<?php if(array_key_exists('nom', $_POST)){
                           echo(htmlspecialchars($_POST['nom']));} ?>"
                       name="nom" id="nom" class="form-control
            <?php if (array_key_exists("nom", $errors)) {
                    echo ('is-invalid');
                } ?>">
                <div id="validateName" class="invalid-feedback">
                    <?php if (array_key_exists("nom", $errors)) {
                        echo ($errors['nom']);
                    } ?>
                </div>

            </div>


            <div class="col-md-12">
                <label for="Description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="Description"></textarea>
            </div>

            <div class="col-md-12">

                <label for="validationServer04" class="form-label">Terrain</label>
                <select class="form-select
                <?php if (array_key_exists("terrain", $errors)) {
                    echo('is-invalid');
                }; ?>" name="terrain" id="validationServer04">
                    <option value="">Pas d'infos</option>
                    <?php
                    // permet d'afficher les terrains de la static qu'on peut d'ailleurs ajouter directement
                    foreach (PlanetController::$allowedTerrain as $terrain){
                        // pour garder la selection :
                        $selected='';
                        if(array_key_exists("terrain", $_POST) && $_POST["terrain"] == $terrain){
                            $selected = 'selected';
                        }
                        echo('<option '.$selected.' value="'.$terrain.'">'.$terrain.'</option>');
                    }
                    ?>

                </select>
                <div class="invalid-feedback">
                    <?php if (array_key_exists("terrain", $errors)) {
                        echo($errors['terrain']);
                    }; ?>
                </div>
            </div>

            <div class="col-md-12">
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
<script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous">
</script>