<?php
class PlanetController extends SecurityController
{
    private $pm;

    public static $allowedTerrain = [
        "Désert",
        "Forêt",
        "Glace",
        "Marais",
        "Œcuménopole"
    ];

    public static $allowedPicture = [
        "image/jpeg",
        "image/png"
    ];

    public function __construct()
    {
        // éviter que le constructeur de sécurité écrase celui-ci
        parent::__construct();

        $this->pm = new PlanetManager();
    }

    public function displayAll()
    {
        $planets = $this->pm->getAll();
        require 'View/planets/planetlist.php';
    }

    public function displayOne($id)
    {
        $planet = $this->pm->getOne($id);
        if (is_null($planet)) {
            header("Location:index.php?controller=default&action=not-found&scope=planete ");
        }
        require 'View/planets/planetdetail.php';
    }

    public function ajout()
    {
        // vérifier le droit de se connecter
        parent::isLoggedIn();
        $errors = [];

        // vérifier quel type de requête a été envoyé
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {

            // vérifier le formulaire via 3 conditions au sein de la methode privée appelée ici
            $errors = $this->checkform();

            // si formulaire valide, enregistrement des données
            if(count($errors)==0){
                $uniqFileName=null;
                // gérer l'"upload" de fichier (jamais par le nom de base, il faudra le renommer !)
                if(!in_array($_FILES["picture"]["type"], self::$allowedPicture)){
                    $errors["picture"] = "Type de fichiers refusé (seulement png, jpg, jpeg)";
                }
                if($_FILES["picture"]["error"] != 0){
                    $errors["picture"] = "Erreur de l\'upload";
                }

                if($_FILES["picture"]["size"] >1000000){
                    $errors["picture"] = "Image trop lourde (max 1mo)";
                }

                // générer un nom unique pour pas se faire écraser
                if(count($errors)==0) {
                    // gérer les extensions ([0] c'est img, [1] c'est le format)
                    $extension = explode('/', $_FILES["picture"]["type"])[1];
                    // changement de nom du fichier
                    $uniqFileName = uniqid().'.'.$extension;
                    // "upload" du fichier
                    move_uploaded_file($_FILES["picture"]["tmp_name"],"public/img/".$uniqFileName);
                    }

                $planet = new Planet (null, $_POST["nom"], $_POST["description"], $_POST["terrain"], $uniqFileName);
                $this->pm-> add($planet);
                // rediriger l'utilisateur vers la liste
                header ("Location:index.php?controller=planetes&action=planetlist");

            }
        }
        require 'View/planets/formAdd.php';
    }

    private function checkForm()
    {
            $errors = [];
            if(empty($_POST["nom"])){
                $errors["nom"] = 'Veuillez saisir le nom de la planète';
            }
            if(strlen($_POST["nom"])>250){
                $errors["nom"] = "Le nom est trop long (250 caractères maximum)";
            }
            if(!in_array($_POST["terrain"], self::$allowedTerrain)){
                $errors["terrain"] = "Ce type de terrain n'existe pas";
            }
            // On ne traite pas les photos ici, car les erreurs de création et d'édition ne sont pas les mêmes
            // L'image est stockée dans le serveur donc on ne peut pas mettre la "value" dans l'"input".
            // On va se placer après le "checkform" (= quand il n'y aura pas d'erreur dans le form)
            return $errors;
    }

    public function update($id){
        // vérifier qu'on a le droit de se connecter
        parent::isLoggedIn();
        $errors=[];
        $planet = $this->pm->getOne($id);

        if(is_null($planet)){
            header("Location:index.php?controller=default&action=not-found&scope=planete");
        } else {
            if($_SERVER["REQUEST_METHOD"] == 'POST'){
                // vérifier le formulaire via 3 conditions au sein de la methode privée appelée ici
                $errors = $this->checkform();
                // pour mettre à jour, il faut aller récupérer les données
                $planet->setNom($_POST["nom"]);
                $planet->setDescription($_POST["description"]);
                $planet->setTerrain($_POST["terrain"]);
                //cette ligne ne sert plus à rien, car désormais on upload
                // $planet->setPicture($_POST["picture"]);

                if (count($errors) ==0){
                    // vérifier la présence d'un fichier dans "picture"
                    if(array_key_exists("picture", $_FILES)){
                        // vérifier le formulaire (cf.plus haut) :
                        $uniqFileName=null;
                        if(!in_array($_FILES["picture"]["type"], self::$allowedPicture)){
                            $errors["picture"] = "Type de fichiers refusé (seulement png, jpg, jpeg)";
                        }
                        if($_FILES["picture"]["error"] !=0){
                            $errors["picture"] = "Erreur de l\'upload";
                        }
                        if($_FILES["picture"]["size"] >1000000){
                            $errors["picture"] = "Image trop lourde (max 1mo)";
                        }
                        if(count($errors)==0) {
                            //suppression de la précédente photo
                            unlink("public/img/".$planet->getPicture());
                            // upload
                            $extension = explode('/', $_FILES["picture"]["type"])[1];
                            $uniqFileName = uniqid() . '.' . $extension;
                            move_uploaded_file($_FILES["picture"]["tmp_name"], "public/img/" . $uniqFileName);
                            $planet->setPicture($uniqFileName);
                        }
                    }
                    // mise à jour de la bdd
                    $this->pm->update($planet);
                    // redirection de l'utilisateur
                    header("Location: index.php?controller=planetes&action=planetlist");
                }
            }
            require 'View/planets/formEdit.php';
        }

    }

    public function delete($id){
        // vérifier le droit de se connecter
        parent::isLoggedIn();
        $planet = $this->pm->getOne($id);
        if(is_null($planet)){
            header("Location:index.php?controller=default&action=not-found&scope=planete");
        } else{
            // suppression du fichier de la bdd
            unlink("public/img/".$planet->getPicture());
            // appel du manager pour lancer la méthode "delete"
            $this->pm->delete($planet->getId());
            // suppression de la planète
            // redirection vers la même page avec entretemps l'exécution de la requête de suppression
            header("Location: index.php?controller=planetes&action=planetlist");
        }


    }
}
