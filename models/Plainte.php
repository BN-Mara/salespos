<?php

/**
 * Created by PhpStorm.
 * User: shelton
 * Date: 30/06/2020
 * Time: 00:41
 */
class Plainte
{

    private $id_plainte;
    private $id_type;
    private $id_client;
    private $description;
    private $addedBy;
    private $status;
    private $solution;
    private $id_subtype;
  

    public function getIdSubtype()
    {
        return $this->id_subtype;
    }

    public function getSolution()
    {
        return $this->solution;
    }

    public function setIdSubtype($id_subtype)
    {
        $this->id_subtype = $id_subtype;
    }

    public function setSolution($solution)
    {
        $this->solution = $solution;
    }

    public function getIdClient()
    {
        return $this->id_client;
    }

    public function setIdClient($id_client)
    {
        $this->id_client = $id_client;
    }
    public function getIdPlainte()
    {
        return $this->id_plainte;
    }

    public function setIdPlainte($id_plainte)
    {
        $this->id_plainte = $id_plainte;
    }

    public function getIdType()
    {
        return $this->id_type;
    }

    public function setIdType($id_type)
    {
        $this->id_type = $id_type;
    }
    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setAddedBy($addedBy)
    {
        $this->addedBy = $addedBy;
    }
    public function getAddedBy()
    {
        return $this->addedBy;
    }



    public function setConsern($consern)
    {
        $this->consern = $consern;
    }


    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }



    
}