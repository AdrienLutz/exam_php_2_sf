<?php

class UserManager extends DbManager {
    public function getByUsername($username){
        $query = $this->bdd->prepare("SELECT * FROM User WHERE username =:username");
        $query->bindParam("username", $username);
        $query->execute();
        //ici je retourne un résultat pdo (une chaine de caractère)
        $res= $query->fetch();
        // je veux retourner un objet
        $user = null;
        if($res != false){
            $user = new User ($res["id"], $res["username"], $res["nom"], $res["prenom"], $res["password"]);
        }
        return $user;
    }

    public function add(User $user){
        $username=$user->getUsername();
        $nom=$user->getNom();
        $prenom=$user->getPrenom();
        $password=$user->getPassword();

        $query = $this->bdd->prepare(
            "INSERT INTO user (username, nom, prenom, password)
            VALUES (:username, :nom, :prenom, :password)");
        $query->bindParam("username", $username);
        $query->bindParam("nom", $nom);
        $query->bindParam("prenom", $prenom);
        $query->bindParam("password", $password);

        $query->execute();
    }
}
