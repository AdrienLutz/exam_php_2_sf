<?php
// pour securiser des pages il "suffit" de rajouter l'extnesion ainsi que la méthode publique du constructeur et du loggedin
class DefaultController extends SecurityController
{
    public function __construct()
    {
        parent::__construct();
//        desactivé pour pouvoir acceder au moins à la page d'accueil sans etre loggé'
//        parent::isLoggedIn();
    }

    public function home(){
    // on a seulement de l'affichage
    // on require donc la vue correspondante à notre
        // page d'accueil (home.php)
        require 'View/home.php';
    }
    public function notFound(){
//        pour la gestion de l'erreur:
        http_response_code(404);
        require 'View/errors/404.php';
    }
}

?>