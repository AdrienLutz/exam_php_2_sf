<?php

class StarshipController extends SecurityController
{

    private $sm;

    public static $allowedFonction = [
        "Transport",
        "Assaut",
    ];

    public function __construct()
    {
        parent::__construct();
        parent::isLoggedIn();
        $this->sm = new StarshipManager();
    }
    public function displayAll()
    {
        $sm = new StarshipManager();
        $starships = $sm->getAll();

        require 'View/starships/starshiplist.php';
    }

    public function displayOne($id)
    {
        $starship = $this->sm->getOne($id);
        if (is_null($starship)) {
            header("Location:index.php?controller=default&action=not-found&scope=vaisseau");
        }
        require 'View/starships/starshipdetail.php';
    }
    public function ajout(){
        $errors = [];

        if($_SERVER["REQUEST_METHOD"] == 'POST'){
            if(strlen($_POST["nom"]) > 250){
                $errors["nom"] = "Le nom est saisi est trop grand (250 caractères)";
            }
            if(strlen($_POST["picture"])> 250){
                $errors["picture"] = "Le lien de la photo est trop grand (250 caractères)";
            }
            if(!is_numeric($_POST["taille"])){
                $errors["taille"] = 'Veuillez saisir un nombre';
            }
            if(!in_array($_POST['fonction'], self::$allowedFonction)) {
                $errors["fonction"] = "Cette fonction n'existe pas";
            }

            if(count($errors) == 0){
                $starship =
                    new Starship(null, $_POST["nom"], $_POST["picture"], $_POST["taille"], $_POST["fonction"]);

                $this->starshipManager->add($starship);

                header("Location: index.php?controller=vaisseaux&action=starshiplist");
            }
        }

        require 'View/starships/formAdd.php';
    }


}
