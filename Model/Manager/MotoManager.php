<?php

//on extend à DbManager pour passer
// dans le constructeur et se connecter à la bdd
// quoique l'on fasse ici, nous serons connecté
class MotoManager extends DbManager
{
    public function getAll()
    {
        $query = $this->bdd->prepare("SELECT * FROM moto");
        $query->execute();

        $results = $query->fetchAll();

        $motos = [];
        foreach ($results as $res) {
            //bien respecter l'ordre du constructeur ici !

//            on ajoute ces objets dans notre tableau
            $motos[] = new moto(
                $res['id'], $res['brand'], $res['model'], $res['type'], $res['picture']
            );
        }
//        on retourne notre tableau contenant nos objets
        return $motos;

    }

    public function getOne($id)
    {
        $query =
            $this->bdd->prepare("SELECT * FROM moto WHERE id = :id");
        $query->bindParam(':id', $id);
        $query->execute();
        $res = $query->fetch();

        $moto = null;

//        il faut transformer ce tableau pdo en objet mais d'abord
//        il faut metre une condition au cas où la moto n'existe pas
        if ($res) {
            $moto = new moto($res['id'], $res['brand'], $res['model'], $res['type'], $res['picture']);

        }
        return $moto;

    }


    public function update(moto $moto)
    {
        $brand = $moto->getBrand();
        $model = $moto->getModel();
        $type = $moto->getType();
        $picture = $moto->getPicture();
        $id = $moto->getId();

        $query = $this->bdd->prepare("UPDATE moto SET
        brand = :brand, 
        model = :model,
        type = :type,
        picture = :picture
        WHERE id = :id");

        $query->bindParam("brand", $brand);
        $query->bindParam('model', $model);
        $query->bindParam("type", $type);
        $query->bindParam("picture", $picture);
        $query->bindParam("id", $id);

        $query->execute();
    }

    public function add(moto $moto): moto
    {
        $brand = $moto->getBrand();
        $model = $moto->getModel();
        $type = $moto->getType();
        $picture = $moto->getPicture();

        $query = $this->bdd->prepare(
            'INSERT INTO moto (brand, model, type, picture) VALUES (:brand, :model, :type, :picture) '
        );
        // les paramètres à afficher sont privés, il faut utiliser les getters
        $query->bindParam(':brand', $brand);
        $query->bindParam(':model', $model);
        $query->bindParam(':type', $type);
        $query->bindParam(':picture', $picture);

        $query->execute();

        $moto->setId($this->bdd->lastInsertId());

        return $moto;
    }

    public function delete($id)
    {
        $query = $this->bdd->prepare("DELETE FROM moto WHERE id=:id");
        $query->bindParam("id", $id);
        $query->execute();
    }


//    public function getAllTypes()
//    {
//        {
//            $query = $this->pdo->prepare('SELECT * FROM type');
//            $query->execute();
//            $results = $query->fetchAll(PDO::FETCH_ASSOC);
//            return $results;
//        }
//    }



    public function getByType($type) {
        $query = $this->bdd->prepare("SELECT * FROM moto WHERE type=:type");
        $query->bindParam(':type', $type);
        $query->execute();
        $results = $query->fetchAll(2);
        $motos = [];

        foreach ($results as $res){
            $motos[] = new Moto($res['id'], $res['brand'], $res['model'],
                $res['type'],
                $res['picture']);
        }
        return $motos;
    }

//    public function getOneMoto($id)
//    {
//        $query = $this->pdo->prepare('SELECT * FROM moto WHERE moto_id = :id');
//        $query->execute([
//            'id' => $id
//        ]);
//        $res = $query->fetch(PDO::FETCH_ASSOC);
//        $moto = null;
//        if ($res) {
//            $moto = new Moto($res['id'], $res['brand'], $res['model'], $res['type'], $res['picture']);
//        }
//        return $moto;
//    }

}

