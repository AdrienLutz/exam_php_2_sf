<?php

class Planet{
    protected $id;
    protected $nom;
    protected $description;
    protected $terrain;
    protected $picture;

    public function __construct($id, $nom, $description, $terrain, $picture)
    {
        $this->id = $id ;
        $this->nom = $nom ;
        $this->description = $description ;
        $this->terrain = $terrain ;
        $this->picture = $picture ;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getTerrain()
    {
        return $this->terrain;
    }

    /**
     * @param mixed $terrain
     */
    public function setTerrain($terrain)
    {
        $this->terrain = $terrain;
    }

    /**
     * @return mixed
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param mixed $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }


}