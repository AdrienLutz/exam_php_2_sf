<?php
class SecurityController
{
    private $userManager;
    // Injection du "userManager" qui permettra de requêter nos données utilisateur
    // (afin de vérifier que Username n'existe pas déjà par exemple)

    protected $currentUser;
    // C'est l'utilisateur connecté (partagé avec les classes enfant)

    public function __construct()
    {
        // Initialiser user manager
        $this->userManager = new UserManager();
        $this->currentUser = null;
        // Vérifier si un utilisateur est en session
        if (array_key_exists("user", $_SESSION)) {
            // Si je suis connecté, j'aurais forcément un attribut "currentuser"
            // Il est stocké sous forme de texte dans la session, on doit le transformer en objet
            $this->currentUser = unserialize($_SESSION["user"]);
        }

    }

    public function isLoggedIn()
    {
        // Vérifier l'attribut currentUser
        if (!$this->currentUser) {
            // Sinon, nous ne sommes pas connecté et redirigé vers login
            header('Location: index.php?controller=security&action=login');
            die();
        }
    }

    public function logout()
    {
        // Supprimer la session
        session_destroy();
        // Vider l'attribut utilisateur courant
        $this->currentUser = null;
        // Rediriger vers le login
        header('Location: index.php?controller=security&action=login');
    }

    public function login()
    {
        $errors = [];
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            // Est-ce que le champ "username" est vide ?
            if (empty($_POST["username"])) {
                $errors["username"] = "Veuillez saisir un username";
            }
            // Est-ce que le champ "password" est vide ?
            if (empty($_POST["password"])) {
                $errors["password"] = 'Veuillez saisir votre mot de passe';
            }
            // S'il n'y a pas d'erreur, alors l'enregistrement peut commencer
            if (count($errors) == 0) {
                // Récupérer l'utilisateur
                $user = $this->userManager->getByUsername($_POST["username"]);
                // Si l'utilisateur n'existe pas (vérification par le mot de passe), une erreur s'affiche
                // Vérifier, en même temps, si le mot de passe est correct
                if (is_null($user) || !password_verify($_POST["password"], $user->getPassword())) {
                    $errors["password"] = 'Identifiant ou mot de passe invalide';
                } else {
                    // Sinon cela signifie que tout est ok pour stocker l'utilisateur dans la session
                    // Mettre à jour l'attribut "currentUser" avec l'utilisateur connecté
                    $this->currentUser = $user;
                    // ATTENTION, on ne peut stocker un objet en session d'où l'intérêt d'une chaine de caractère
                    $_SESSION["user"] = serialize($user);
                    // Une fois connecté, renvoi vers la page d'accueil
                    header('Location: index.php?controller=default&action=home');
                }
            }
        }
        require 'View/security/login.php';
    }

    public static function connexion_status()
    {
        // But de cette fonction :
        // Permettre d'afficher un bouton "connexion" OU "déconnexion" dans la navbar
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
            // Est-ce que le champ "username" est vide ?
            if (empty($_POST["username"])) {
                $errors["username"] = "Veuillez saisir un username";
            }
            // Est-ce que le "username" a déjà été utilisé auparavant ?
            $user = $this->userManager->getByUsername($_POST["username"]);
            if ($user) {
                $errors['username'] = 'Impossible cet utilisateur existe déjà';
            }
            // Est-ce que le champ "nom" est vide ?
            if (empty($_POST["nom"])) {
                $errors["nom"] = 'Veuillez saisir votre nom';
            }
            // Est-ce que le champ "prenom" est vide ?
            if (empty($_POST["prenom"])) {
                $errors["prenom"] = 'Veuillez saisir votre prénom';
            }
            // Est-ce que le champ "password" est vide ?
            if (empty($_POST["password"])) {
                $errors["password"] = 'Veuillez saisir votre mot de passe';
            }
            // Vérifier la correspondance des mots de passe
            if ($_POST["password"] !== $_POST["confirm_password"]) {
                $errors["confirm_password"] = 'Les mots de passe ne correspondent pas';
            }
            // Si 0 erreur, enregistrement
            if (count($errors) == 0) {
                // Créer l'utilisateur et hacher son mot de passe
                $user = new User(null, $_POST["username"], $_POST["nom"],
                    $_POST["prenom"], password_hash($_POST["password"], PASSWORD_BCRYPT));
                // Appel du manager pour aller l'enregistrer ...
                $this->userManager->add($user);
                // ... et le dédiriger vers le login
                header('Location: index.php?controller=security&action=login');
            }
        }
        require 'View/security/register.php';
    }
}