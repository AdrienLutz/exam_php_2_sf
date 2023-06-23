<?php
session_start();
require "autoload.php";
//include 'vendor/autoload.php';
//
//require 'Model/Manager/DbManager.php';
//require 'Model/Class/User.php';
//require 'Model/Manager/UserManager.php';
//require 'Controller/SecurityController.php';
//
//require 'Model/Class/Planet.php';
//require 'Model/Manager/PlanetManager.php';
//require 'Controller/DefaultController.php';
//require 'Controller/PlanetController.php';
//
//require 'Model/Class/Starship.php';
//require 'Model/Manager/StarshipManager.php';
//require 'Controller/StarshipController.php';


// require lance une erreur si ne trouve pas le fichier
// include lance un warning


//on redirige l'utilisateur avec des paramètres
// permettant d'aficher la page d'accueil
// d'abord via le controller (MVC) puis via l'action=home
if (!isset($_GET["controller"]) && !isset($_GET["action"]))

    //autre façon d'écrire la condition :
    //if(!array_key_exists("controller",$_GET) && !array_key_exists("action",$_GET))
{
    header('Location:index.php?controller=default&action=home');
}

//si le parametre get de notre URL est égal à "default", alors
//on crée un nouvel objet DefaultController
if ($_GET["controller"] == "default") {
    $controller = new DefaultController();
    //si le paramètre get est égal à "home",
    if ($_GET["action"] == "home") {
        // alors on renvoie vers la méthode "home" de
        // notre controller "DefaultController"
        $controller->home();
    }
    if($_GET["action"]== 'not-found'){
        $controller->notFound();
    }
}

if ($_GET["controller"] == "security") {
    $controller = new SecurityController();
    if($_GET["action"] == 'register'){
        $controller->register();
    }
    if($_GET["action"] == 'login'){
        $controller->login();
    }

    if($_GET["action"] == 'logout'){
        $controller->logout();
    }
}


// si, dans home.php, j'ai cliqué sur le lien pour voir les planetes,
//alors je viens ici car le controller = planetes
if ($_GET["controller"] == 'planetes') {
    // cela crée un nouvel objet PlanetController
    $controller = new PlanetController();
    // si l'action = planetlist, je lance mon displayAll soit l'affichage
    // de toutes mes planetes en bdd
    if ($_GET["action"] == "planetlist") {
        $controller->displayAll();
    }
    // on crée ici une nouvelle condition pour afficher le détail
    // et on aura besoin de l'id de la planete
    if ($_GET['action'] == 'detail' && array_key_exists('id', $_GET)){
        $controller->displayOne($_GET['id']);
    }
    // ajout d'une nouvelle route
    if ($_GET['action'] == 'ajout'){
        $controller->ajout();
    }
    if ($_GET['action'] == 'update' && array_key_exists('id', $_GET)){
        $controller->update($_GET['id']);
    }
    if ($_GET['action'] == 'delete' && array_key_exists('id', $_GET)){
        $controller->delete($_GET['id']);
    }
}


if ($_GET["controller"] == 'vaisseaux') {
    $controller = new StarshipController();
    if ($_GET["action"] == "starshiplist") {
        $controller->displayAll();
    }
    if($_GET['action'] == 'detail' && array_key_exists( 'id', $_GET)) {
        $controller->displayOne($_GET["id"]);
    }

    if($_GET["action"] == 'ajout'){
        $controller->ajout();
    }

}


