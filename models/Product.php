<?php

/**
 * Created by PhpStorm.
 * User: shelton
 * Date: 05/07/2020
 * Time: 21:29
 */
class Product
{
    private $id_product;
    private $designation;
    private $code;
    private $price;
    private $id_category;
    private $addedBy;

    public function getAddedBy()
    {
        return $this->addedBy;
    }

    public function setAddedBy($addedBy)
    {
        $this->addedBy = $addedBy;
    }

    public function setIdProduct($id_product)
    {
        $this->id_product = $id_product;
    }

    public function getIdProduct()
    {
        return $this->id_product;
    }

    public function setDesignation($designation)
    {
        $this->designation = $designation;
    }

    public function getDesignation()
    {
        return $this->designation;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getIdCategory()
    {
        return $this->id_category;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setIdCategory($id_category)
    {
        $this->id_category = $id_category;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }


}