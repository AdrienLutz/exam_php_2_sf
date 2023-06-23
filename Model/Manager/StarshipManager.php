<?php

//on extend à DbManager pour passer
// dans le constructeur et se connecter à la bdd
// quoique l'on fasse ici, nous serons connecté
class StarshipManager extends DbManager{
    public function getAll(){
        $query = $this->bdd->prepare("SELECT * FROM starship");
        $query->execute();

        $results = $query->fetchAll();

        $starships = [];
        foreach ($results as $res) {
            //bien respecter l'ordre du constructeur ici !

            $starships[] = new Starship(
                $res['id'], $res['nom'], $res['taille'], $res['fonction'], $res['picture']
            );
        }
        return $starships;
    }
    public function getOne($id)
    {
        $query =
            $this->bdd->prepare("SELECT * FROM starship WHERE id = :id");
        $query->bindParam(':id', $id);
        $query->execute();
        $res = $query->fetch();

        $starship = null;

//        il fau transformer ce tableau pdo en objet mais d'abord
//        il faut metre une condition au cas où la starshipe n'existe pas
        if ($res) {
            $starship = new Starship($res['id'], $res['nom'], $res['taille'], $res['fonction'], $res['picture']);

        }
        return $starship;

    }
    public function add(Starship $starship){
        $nom = $starship->getNom();
        $taille = $starship->getTaille();
        $fonction = $starship->getFonction();
        $picture = $starship->getPicture();

        $query = $this->bdd->prepare(
            'INSERT INTO starship (nom, taille, fonction, picture) VALUES (:nom, :taille, :fonction, :picture) '
        );
//        les paramètres à afficher sont privés, il faut utiliser les getters
        $query->bindParam(':nom', $nom);
        $query->bindParam(':taille', $taille);
        $query->bindParam(':fonction', $fonction);
        $query->bindParam(':picture', $picture);

        $query->execute();

        $starship->setId($this->bdd->lastInsertId());


        return $starship;
    }

}