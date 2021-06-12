<?php

/**
 * Created by PhpStorm.
 * User: shelton
 * Date: 05/07/2020
 * Time: 21:38
 */
class Transaction
{
    private  $id_trans;
    private $id_stock;
    private $quantity;
    private $id_pos;
    private $addedBy;

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setIdStock($id_stock)
    {
        $this->id_stock = $id_stock;
    }

    public function getIdStock()
    {
        return $this->id_stock;
    }

    public function getAddedBy()
    {
        return $this->addedBy;
    }

    public function setAddedBy($addedBy)
    {
        $this->addedBy = $addedBy;
    }

    public function getIdPos()
    {
        return $this->id_pos;
    }

    public function getIdTrans()
    {
        return $this->id_trans;
    }

    public function setIdPos($id_pos)
    {
        $this->id_pos = $id_pos;
    }

    public function setIdTrans($id_trans)
    {
        $this->id_trans = $id_trans;
    }

}