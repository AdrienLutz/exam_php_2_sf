<?php
include 'View/parts/header.php';
?>
<h1>Ajouter un vaisseau</h1>

<a class="btn btn-outline-warning m-2 " href="index.php?controller=vaisseaux&action=starshiplist">back</a>
<section class="container">
    <div class="row">"
        <form method="post" class="row">
            <div class="col-md-12">
                <label for="nom" class="form-label">Nom du vaisseau</label>

                <input type="text" name="nom" class="form-control <?php
                if (array_key_exists("nom", $errors)) {
                    echo('is-invalid');
                }
                ?>" value="<?php if (array_key_exists("nom", $errors)) echo($_POST['nom']); ?>" id="nom">

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
                <textarea class="form-control" name="description" id="Description"></textarea>
            </div>

            <div class="col-md-12">
                <label for="validationServer04" class="form-label">Fonction</label>
                <select class="form-select
                <?php if (array_key_exists("fonction", $errors)) {
                    echo('is-invalid');
                }; ?>" name="fonction" id="validationServer04">
                    <option value="">Pas d'infos</option>
                    <?php
                    // permet d'afficher les fonctions de la static qu'on peut d'ailleurs ajouter directement
                    foreach (StarshipController::$allowedFonction as $fonction){
                        // pour garder la selection :
                        $selected='';
                        if(array_key_exists("fonction", $_POST) && $_POST["fonction"] == $fonction){
                            $selected = 'selected';
                        }
                        echo('<option '.$selected.' value="'.$fonction.'">'.$fonction.'</option>');
                    }
                    ?>

                </select>
                <div class="invalid-feedback">
                    <?php if (array_key_exists("fonction", $errors)) {
                        echo($errors['fonction']);
                    }; ?>
                </div>
            </div>

            <div class="col-md-12">
                <label for="picture" class="form-label">Photographie</label>
                <input type="text" name="picture" class="form-control
                    <?php
                if (array_key_exists("picture", $errors)) {
                    echo('is-invalid');
                }
                ?>
                    " id="picture">
                <div class="invalid-feedback">
                    <?php if(array_key_exists("picture", $errors)){echo($errors["picture"]);}?>
                </div>

            </div>

            <div class="col-md-12">
                <label for="taille">
                    Taille
                </label>
                <input type="number" class="form-control
            <?php  if(array_key_exists("taille", $errors)){echo('is-invalid');} ?>"
                       value="<?php if(array_key_exists("taille", $_POST)){echo($_POST["taille"]);};?>"
                       step="0.01" id="taille" name="taille">
                <div id="validateNom" class="invalid-feedback">
                    <?php if(array_key_exists("taille", $errors)){echo($errors["taille"]);}?>
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