<?php

/**
 * Created by PhpStorm.
 * User: shelton
 * Date: 14/07/2020
 * Time: 08:42
 */
class SalesCredit
{
    private $id_sales_credit;
    private $id_product;
    private $amount;
    private $phone;
    private $quatity;
    private $addedBy;
    private  $creation_date;
    private $total;

    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function getTotal()
    {
        return $this->total;
    }


    public function setIdProduct($id_product)
    {
        $this->id_product = $id_product;
    }

    public function getIdProduct()
    {
        return $this->id_product;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function getAddedBy()
    {
        return $this->addedBy;
    }

    public function getQuantity()
    {
        return $this->quatity;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setAddedBy($addedBy)
    {
        $this->addedBy = $addedBy;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getCreationDate()
    {
        return $this->creation_date;
    }

    public function setQuantity($quatity)
    {
        $this->quatity = $quatity;
    }

    public function getIdSalesCredit()
    {
        return $this->id_sales_credit;
    }

    public function setCreationDate($creation_date)
    {
        $this->creation_date = $creation_date;
    }

    public function setIdSalesCredit($id_sales_credit)
    {
        $this->id_sales_credit = $id_sales_credit;
    }



}