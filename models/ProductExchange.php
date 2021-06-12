<?php

/**
 * Created by PhpStorm.
 * User: shelton
 * Date: 26/07/2020
 * Time: 14:00
 */
class ProductExchange
{
    private $id_reference;
    private $id_product;
    private $oldimei;
    private $newimei;
    private $addedBy;
    private $newproduct;
    private $id_plainte;

    public function getIdPlainte()
    {
        return $this->id_plainte;
    }

    public function setIdPlainte($id_plainte)
    {
        $this->id_plainte = $id_plainte;
    }

    public function getNewproduct()
    {
        return $this->newproduct;
    }

    public function setNewproduct($newproduct)
    {
        $this->newproduct = $newproduct;
    }

    public function setIdProduct($id_product)
    {
        $this->id_product = $id_product;
    }

    public function getIdProduct()
    {
        return $this->id_product;
    }

    public function getIdReference()
    {
        return $this->id_reference;
    }

    public function setIdReference($id_reference)
    {
        $this->id_reference = $id_reference;
    }

    public function getOldimei()
    {
        return $this->oldimei;
    }

    public function setOldimei($oldimei)
    {
        $this->oldimei = $oldimei;
    }

    public function getAddedBy()
    {
        return $this->addedBy;
    }

    public function setAddedBy($addedBy)
    {
        $this->addedBy = $addedBy;
    }

    public function getNewimei()
    {
        return $this->newimei;
    }

    public function setNewimei($newimei)
    {
        $this->newimei = $newimei;
    }

}