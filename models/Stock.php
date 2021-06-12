<?php

/**
 * Created by PhpStorm.
 * User: shelton
 * Date: 05/07/2020
 * Time: 21:35
 */
class Stock
{
    private $id_stock;
    private $id_product;
    private $quantity;
    private $id_pos;

    public function setIdProduct($id_product)
    {
        $this->id_product = $id_product;
    }

    public function getIdProduct()
    {
        return $this->id_product;
    }

    public function setIdPos($id_pos)
    {
        $this->id_pos = $id_pos;
    }

    public function getIdPos()
    {
        return $this->id_pos;
    }

    public function getIdStock()
    {
        return $this->id_stock;
    }

    public function setIdStock($id_stock)
    {
        $this->id_stock = $id_stock;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }


}