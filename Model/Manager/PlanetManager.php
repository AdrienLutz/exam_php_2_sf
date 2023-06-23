<?php

//on extend à DbManager pour passer
// dans le constructeur et se connecter à la bdd
// quoique l'on fasse ici, nous serons connecté
class PlanetManager extends DbManager
{
    public function getAll()
    {
        $query = $this->bdd->prepare("SELECT * FROM planet");
        $query->execute();

        $results = $query->fetchAll();

        $planets = [];
        foreach ($results as $res) {
            //bien respecter l'ordre du constructeur ici !

//            on ajoute ces objets dans notre tableau
            $planets[] = new Planet(
                $res['id'], $res['nom'], $res['description'], $res['terrain'], $res['picture']
            );
        }
//        on retourne notre tableau contenant nos objets
        return $planets;

    }

    public function getOne($id)
    {
        $query =
            $this->bdd->prepare("SELECT * FROM planet WHERE id = :id");
        $query->bindParam(':id', $id);
        $query->execute();
        $res = $query->fetch();

        $planet = null;

//        il fau transformer ce tableau pdo en objet mais d'abord
//        il faut metre une condition au cas où la planete n'existe pas
        if ($res) {
            $planet = new Planet($res['id'], $res['nom'], $res['description'], $res['terrain'], $res['picture']);

        }
        return $planet;

    }


    public function update(Planet $planet){
        $nom = $planet->getNom();
        $description = $planet->getDescription();
        $terrain = $planet->getTerrain();
        $picture = $planet->getPicture();
        $id = $planet->getId();

        $query = $this->bdd->prepare("UPDATE planet SET
        nom = :nom, 
        description = :description,
        terrain = :terrain,
        picture = :picture
        WHERE id = :id");

        $query->bindParam("nom", $nom);
        $query->bindParam('description', $description);
        $query->bindParam("terrain", $terrain);
        $query->bindParam("picture", $picture);
        $query->bindParam("id", $id);

        $query->execute();
    }

    public function add(Planet $planet):Planet
    {
        $nom = $planet->getNom();
        $description = $planet->getDescription();
        $terrain = $planet->getTerrain();
        $picture = $planet->getPicture();

        $query = $this->bdd->prepare(
            'INSERT INTO planet (nom, description, terrain, picture) VALUES (:nom, :description, :terrain, :picture) '
        );
        // les paramètres à afficher sont privés, il faut utiliser les getters
        $query->bindParam(':nom', $nom);
        $query->bindParam(':description', $description);
        $query->bindParam(':terrain', $terrain);
        $query->bindParam(':picture', $picture);

        $query->execute();

        $planet->setId($this->bdd->lastInsertId());

        return $planet;
    }

    public function delete($id){
        $query = $this->bdd->prepare("DELETE FROM planet WHERE id=:id");
        $query->bindParam("id", $id);
        $query->execute();
    }

}