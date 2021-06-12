<?php

/**
 * Created by PhpStorm.
 * User: shelton
 * Date: 25/06/2020
 * Time: 10:35
 */
class Client
{
    private  $id;
    private $nom;
    private $prenom;
    private $postom;
    private $adresse;
    private $tel;
    private  $idcard;
    private $addedBy;


    public function getPostom()
    {
        return $this->postom;
    }

    public function setPostom($postom)
    {
        $this->postom = $postom;
    }
    public function getIdcard()
    {
        return $this->idcard;
    }

    public function setIdcard($idcard)
    {
        $this->idcard = $idcard;
    }

    public function getAddedBy()
    {
        return $this->addedBy;
    }

    public function setAddedBy($addedBy)
    {
        $this->addedBy = $addedBy;
    }
    public function getReference()
    {
        return $this->reference;
    }

    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    public function getAdresse()
    {
        return $this->adresse;
    }

    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    public function getTel()
    {
        return $this->tel;
    }

    public function setTel($tel)
    {
        $this->tel = $tel;
    }

}