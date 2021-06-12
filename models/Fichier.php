<?php

/**
 * Created by PhpStorm.
 * User: shelton
 * Date: 05/03/2020
 * Time: 16:27
 */
class Fichier
{
    private $id_produit;
    private $nom;
    private $price;
    private $code;
    private $description;
    private $quantity;
    private $date_creation;
    private $modification_date;
    private $ajoutPar;
    private $modifierPar;
    private $produit_type;

    public function getProduitType()
    {
        return $this->produit_type;
    }

    public function setProduitType($produit_type)
    {
        $this->produit_type = $produit_type;
    }



    public function getNom()
    {
        return $this->nom;
    }
    public function setNom($nom)
    {
        $this->nom = $nom;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getPrice()
    {
        return $this->price;

    }
    public function setPrice($price)
    {
       $this->price = $price;
    }
    public function getAjoutPar()
    {
        return $this->ajoutPar;
    }
    public function setAjoutPar($ajoutPar)
    {
        $this->ajoutPar = $ajoutPar;
    }
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }
    public function getDateCreation()
    {
        return $this->date_creation;
    }
    public function setDateCreation($date_creation)
    {
        $this->date_creation = $date_creation;
    }
    public function getModificationDate()
    {
        return $this->modification_date;
    }
    public function setModificationDate($modification_date)
    {
        $this->modification_date = $modification_date;
    }
    public function getModifierPar()
    {
        return $this->modifierPar;
    }
    public function setModifierPar($modifierPar)
    {
        $this->modifierPar = $modifierPar;
    }
    public function getId()
    {
        return $this->id_produit;
    }
    public function setId($id_produit)
    {
        $this->id_produit = $id_produit;
    }
    public function getCode()
    {
        return $this->code;
    }
    public function setCode($code)
    {
        $this->code = $code;
    }







}