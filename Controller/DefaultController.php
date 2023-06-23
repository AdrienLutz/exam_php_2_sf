<?php
class DefaultController extends SecurityController{
    // pour sécuriser des pages, il "suffit" de rajouter l'extension
    // ainsi que la méthode publique du constructeur et du loggedin
    public function __construct()
    {
        parent::__construct();
        // désactivé pour pouvoir accéder au moins à la page d'accueil sans être online
        // parent::isLoggedIn();
    }
    public function home(){
    // on a seulement de l'affichage
    // on "require" donc la vue correspondante à notre page d'accueil (home.php)
        require 'View/home.php';
    }
    public function notFound(){
        // gestion des erreurs de type 404
        http_response_code(404);
        require 'View/errors/404.php';
    }
}
?>