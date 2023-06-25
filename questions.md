Donner 5 méthodes magiques que vous avez étudié en PHP OO. Expliquez les éléments déclencheurs de l’exécution de la méthode magique (0.5 point par méthode)

Les méthodes magiques sont des méthodes qui sont déclenchées en fonction d’évènement :

__construct() s’exécute dès que l’on instancie une classe dans laquelle on a défini un constructeur.

__toString() va être appelée dès que l’on va traiter un objet comme une chaine de caractères (par exemple lorsqu’on tente d’echo un objet).

__get() va s’exécuter si on tente d’accéder à une propriété inaccessible (ou qui n’existe pas) dans une classe. Elle va prendre en argument le nom de la propriété à laquelle on souhaite accéder.

__set() s’exécute dès qu’on tente de créer ou de mettre à jour une propriété inaccessible (ou qui n’existe pas) dans une classe. Cette méthode va prendre comme arguments le nom et la valeur de la propriété qu’on tente de créer ou de mettre à jour.



__isset() va s’exécuter lorsque les fonctions isset() ou empty() sont appelées sur des propriétés inaccessibles. La fonction isset() va servir à déterminer si une variable est définie et si elle est différente de NULL tandis que la fonction empty() permet de déterminer si une variable est vide.

__unset() va s’exécuter lorsque la fonction unset() est appelée sur des propriétés inaccessibles. La fonction unset() sert donc à détruire une variable.

source :
cours POO Human Booster


https://www.pierre-giraud.com/php-mysql-apprendre-coder-cours/oriente-objet-methode-magique/


--------------------------------------------------

Pour chacune des méthodes ci-dessus proposez un exemple de script qui appellera la méthode de manière implicite (0.5 point par méthode)


__construct

#####

    public function __construct(){ 
        $this->userManager = new UserManager();
        $this->currentUser = null;
        if (array_key_exists("user", $_SESSION)){
            $this->currentUser = unserialize($_SESSION["user"]);
        }
    }


    $moto = new moto (null, $_POST["brand"], $_POST["model"], $_POST["type"], $uniqFileName);

#####

--------------------------------------------------
__toString

    public function __toString(){
    return 'Nom d\'utilisateur : ' .$this->user_name. '
    Prix de l\'abonnement : ' .$this->prix_abo. ';

--------------------------------------------------
__get() ; __set() ; __isset() ; __unset()


doc 1 : index.php

    <?php include("Session.php");
    $session =  new Session();

1. je rentre dans l'objet "session" et je donne à user la valeur "Arnaud"


    $session->user= "Arnaud";
    $session->__unset('user');


(une autre façon de faire aurait été: $session->__set('user', 'Arnaud'); pour inscrire la couple clé valeur dans le tableau associatif "choucroute")

doc 2 : Session.php

    <?php
    class Session {
    

1. 
on cherche alors un attribut "user" mais il n'y en a pas car on n'a pas fait $session->__set('user', 'Arnaud'); il y a juste un attribut "choucroute", une erreur est donc lancée et des fonctions sont lancées

    private array $choucroute = [];

    public function __get(string $name):mixed
    {
        return $this->choucroute[$name];
    }

2.


set sera tout de suite executée car on cherche une prise de valeur dans session.php (' "=" Arnaud') avec $name= "user" et $value="Arnaud". le couple clé/valeur user/Arnaud est créé dans "choucroute"

    public function __set(string $name, mixed $value):void
    {
        $this->choucroute[$name] = $value;
    }


    public function __isset(string $name):bool
    {
        return isset($this->choucroute[$name]);
    }


    public function __unset(string $name):void
    {
        unset($this->choucroute[$name]);
    }
    }
