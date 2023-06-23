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
        //pour éviter que le constructeur de sécurité écrase celui-ci
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
        //on vérifie qu'on a le droit de se connecter
        parent::isLoggedIn();
        $errors = [];

        //vérifier quel type de requête a été envoyé
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {

            //vérifier mon formulaire via 3 conditions
            // au sein de la methode privée appelée ici
            $errors = $this->checkform();
            //s'il est valide, j'enregistre les données

            if(count($errors)==0){
                $uniqFileName=null;
                //ici, on gère l'upload de fichier (jamais par le nom de base, il faudra le renommer !)
                if(!in_array($_FILES["picture"]["type"], self::$allowedPicture)){
                    $errors["picture"] = "Type de fichiers refusé (seulement png, jpg, jpeg)";
                }
                if($_FILES["picture"]["error"] != 0){
                    $errors["picture"] = "Erreur de l\'upload";
                }

                if($_FILES["picture"]["size"] >1000000){
                    $errors["picture"] = "Image trop lourde (max 1mo)";
                }

                //on génère un nom unique pour pas se faire écraser
                if(count($errors)==0) {
                    //je gère les extensions ([0] c'est img, [1] c'est le format)
                    $extension = explode('/', $_FILES["picture"]["type"])[1];
                    // je change le nom de mon fichier
                    $uniqFileName = uniqid().'.'.$extension;
//                    j'uplod mon fichier
                    move_uploaded_file($_FILES["picture"]["tmp_name"],"public/img/".$uniqFileName);
                    }

                $planet = new Planet (null, $_POST["nom"], $_POST["description"], $_POST["terrain"], $uniqFileName);
                $this->pm-> add($planet);
                //puis je redirige l'utilisateur
                header ("Location:index.php?controller=planetes&action=planetlist");

            }
        }
        require 'View/planets/formAdd.php';
    }
    //afin de ne pas dupliquer du code (on vérifie le formulaire C et U)
    //on crée une methode privée pour retourner le tableau d'erreurs
    private function checkForm(){

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
            //on ne traite pas les photos ici car les erreurs de création et d'édition ne sont pas les mêmes. L'image est stockée dans le serveur donc on ne peux pas mettre la value dans l'input. On va se placer après le checkform (quand il n'y aura donc pas d'erreur dans le form)

            return $errors;
        }


    public function update($id){
        //on vérifie qu'on a le droit de se connecter
        parent::isLoggedIn();
        $errors=[];
        $planet = $this->pm->getOne($id);

        if(is_null($planet)){
            header("Location:index.php?controller=default&action=not-found&scope=planete");
        } else {
            if($_SERVER["REQUEST_METHOD"] == 'POST'){
                $errors = $this->checkform();
                // pour metre à jour, il faut aller récupérer les données
                $planet->setNom($_POST["nom"]);
                $planet->setDescription($_POST["description"]);
                $planet->setTerrain($_POST["terrain"]);
                //cette ligne ne sert plus à rien, car mtnt on upload
                // $planet->setPicture($_POST["picture"]);

                if (count($errors) ==0){
                    // je vais vérifier que j'ai un fichier dans picture
                    if(array_key_exists("picture", $_FILES)){
                        //je fais les mêmes vérifications que celles du formulaire plus haut :
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
                            //on supprime la précédente photo
                            unlink("public/img/".$planet->getPicture());
                            $extension = explode('/', $_FILES["picture"]["type"])[1];
                            $uniqFileName = uniqid() . '.' . $extension;
                            move_uploaded_file($_FILES["picture"]["tmp_name"], "public/img/" . $uniqFileName);
                            //une fois uploadé on instancie (?) :
                            $planet->setPicture($uniqFileName);
                        }
                    }
//                    mettre à jour la bdd
                    $this->pm->update($planet);
//                    rediriger l'utilisateur
                    header("Location: index.php?controller=planetes&action=planetlist");
                }
            }
            require 'View/planets/formEdit.php';
        }

    }

    public function delete($id){
        //on vérifie qu'on a le droit de se connecter
        parent::isLoggedIn();
        $planet = $this->pm->getOne($id);
        if(is_null($planet)){
            header("Location:index.php?controller=default&action=not-found&scope=planete");
        } else{
            // je supprime le fichier image de la bdd
            unlink("public/img/".$planet->getPicture());
            // j'appelle mon manager pour lancer la méthode "delete"
            $this->pm->delete($planet->getId());
            // supprimer ma planète
            // on redirige sur la même page sauf qu'entretemps on aura fait notre requete de suppression
            header("Location: index.php?controller=planetes&action=planetlist");
        }


    }
}
