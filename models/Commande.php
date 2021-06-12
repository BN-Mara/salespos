<?php

/**
 * Created by PhpStorm.
 * User: shelton
 * Date: 25/06/2020
 * Time: 11:49
 */
class Commande
{
    private $id;
    private $id_client;
    private  $id_product;
    private  $quantity;
    private $unit_price;
    private $total_price;
    private $creation_date;
    private $imeis;
    private $addedBy;
    private $id_ref;

    public function getIdRef()
    {
        return $this->id_ref;
    }

    public function setIdRef($id_ref)
    {
        $this->id_ref = $id_ref;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIdClient()
    {
        return $this->id_client;
    }

    public function setIdClient($id_client)
    {
        $this->id_client = $id_client;
    }

    public function getIdProduct()
    {
        return $this->id_product;
    }

    public function setIdProduct($id_product)
    {
        $this->id_product = $id_product;
    }

    public function getUnitPrice()
    {
        return $this->unit_price;
    }

    public function setUnitPrice($unit_price)
    {
        $this->unit_price = $unit_price;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getTotalPrice()
    {
        return $this->total_price;
    }

    public function setTotalPrice($total_price)
    {
        $this->total_price = $total_price;
    }

    public function getCreationDate()
    {
        return $this->creation_date;
    }

    public function setCreationDate($creation_date)
    {
        $this->creation_date = $creation_date;
    }

    public function getAddedBy()
    {
        return $this->addedBy;
    }

    public function setAddedBy($addedBy)
    {
        $this->addedBy = $addedBy;
    }

    public function getImeis()
    {
        return $this->imeis;
    }

    public function setImeis($imeis)
    {
        $this->imeis = $imeis;
    }

}