<?php

//classe en charge de la sécurité
class SecurityController
{

    //on injecte ici le "userManager" pour requeter les données utilisateurs (on en a besoin pour vérifier que Username n'existe pas déjà par exemple)
    private $userManager;
    //partagé avec les classes enfant, c'eest l'utilisateur connecté
    protected $currentUser;


    public function __construct()
    {
        //on initialise notre user manager
        $this->userManager = new UserManager();
        $this->currentUser = null;
        //on vérifie que l'on a un utilisateur en session
        if (array_key_exists("user", $_SESSION)) {
            //si je suis connecté, j'aurais forcément un attribut "currentuser"
            // il est stocké sous forme de texte dans la session, on doit le transformer en objet
            $this->currentUser = unserialize($_SESSION["user"]);
        }

    }

    //cette fonction vérifie que l'on a un attribut "currentuser", si c'est pas le cas, cela signifie qu'on n'est pas connecté (cf. constructeur)
    //donc on redirige vers la page de login
    public function isLoggedIn()
    {
        //2cas possibles:
        //j'ai un curretn user et donc je le retourne sinon je renvoie l'utilisateur vers la page de login
        if (!$this->currentUser) {
            header('Location: index.php?controller=security&action=login');
            die();
        }
    }
    //suppression de la session, vide l'attribut utilisateur courant et redirige vers le login
    public function logout(){
        session_destroy();
        $this->currentUser = null;

        header('Location: index.php?controller=security&action=login');
    }
    //affiche le form de login
    //lors de la soumission, elle le vérifie
    //elle connecte l'utilisateur si les identifiants sont ok et stocke en session notre utilisateur qu'elle a transformé en texte puisqu'en session on peut pas stocker un objet
    //elle met à jour notre attribut currentuser avec l'utilisateur connecté
    public function login()
    {
        $errors = [];

        if ($_SERVER["REQUEST_METHOD"] == 'POST') {

            // champ "username" vide
            if (empty($_POST["username"])) {
                $errors["username"] = "Veuillez saisir un username";
            }

            // champ "password" vide
            if (empty($_POST["password"])) {
                $errors["password"] = 'Veuillez saisir votre mot de passe';
            }

            // Si 0 erreur, enregistrement
            if (count($errors) == 0) {
                // on récupère notre utilisateur
                $user = $this->userManager->getByUsername($_POST["username"]);
                // si l'utilisateur n'existe pas (vérification par le mot de passe), on affiche une erreur
                // on vérifie en même temps si le mot de passe est OK
                if (is_null($user) || !password_verify($_POST["password"], $user->getPassword())) {
                    $errors["password"] = 'Identifiant ou mot de passe invalide';
                } else {
                    // sinon ça veut dire que tout est ok et on va stocker l'utilisateur dans la session (sauf qu'on ne peut stocker un objet en session, il faut faire une chaine de caractère

                    $this->currentUser = $user;
                    $_SESSION["user"] = serialize($user);
                    //il est connecté, je le renvoie donc vers la page d'accueil
                    header('Location: index.php?controller=default&action=home');
                }


            }

        }


        require 'View/security/login.php';
    }

    //affiche le formulaire pour s'enregistrer
    //vérifie les saisies du form
    //enregistre l'utilisateur (bien penser au hachage)
    //redirige notre utilisateur vers le login
    public static function connexion_status()
    {
        if (array_key_exists("user", $_SESSION)) {
            return true;
        } else {
            return false;
        }
    }
    public function register()
    {

        $errors = [];

        if ($_SERVER["REQUEST_METHOD"] == 'POST') {

            // champ "username" vide
            if (empty($_POST["username"])) {
                $errors["username"] = "Veuillez saisir un username";
            }

            // Username déjà utilisé
            $user = $this->userManager->getByUsername($_POST["username"]);

            if ($user) {
                $errors['username'] = 'Impossible cet utilisateur existe déjà';
            }

            // champ "nom" vide
            if (empty($_POST["nom"])) {
                $errors["nom"] = 'Veuillez saisir votre nom';
            }

            // champ "prenom" vide
            if (empty($_POST["prenom"])) {
                $errors["prenom"] = 'Veuillez saisir votre prénom';
            }

            // champ "password" vide
            if (empty($_POST["password"])) {
                $errors["password"] = 'Veuillez saisir votre mot de passe';
            }

            // vérification du mot de passe
            if ($_POST["password"] !== $_POST["confirm_password"]) {
                $errors["confirm_password"] = 'Les mots de passe ne correspondent pas';
            }

            // Si 0 erreur, enregistrement
            if (count($errors) == 0) {
                $user = new User(null, $_POST["username"], $_POST["nom"],
                    $_POST["prenom"], password_hash($_POST["password"], PASSWORD_DEFAULT));
                //mon utilisateur est créé
                //j'appelle mon manager pour aller l'enregister et le rediriger vers le login
                $this->userManager->add($user);
                // on renvoie vers le login
                header('Location: index.php?controller=security&action=login');
            }

        }

        require 'View/security/register.php';
    }

}