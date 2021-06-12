<?php

/**
 * Created by PhpStorm.
 * User: shelton
 * Date: 09/07/2020
 * Time: 13:17
 */
class Imei
{
    private $id_imei;
    private $id_product;
    private $addedBy;
    private $imei;
    private $id_pos;



    public function setIdProduct($id_product)
    {
        $this->id_product = $id_product;
    }

    public function getIdProduct()
    {
        return $this->id_product;
    }

    public function getIdImei()
    {
        return $this->id_imei;
    }

    public function getImei()
    {
        return $this->imei;
    }

    public function setIdImei($id_imei)
    {
        $this->id_imei = $id_imei;
    }

    public function getIdPos()
    {
        return $this->id_pos;
    }

    public function setIdPos($id_pos)
    {
        $this->id_pos = $id_pos;
    }

    public function setImei($imei)
    {
        $this->imei = $imei;
    }

    public function getAddedBy()
    {
        return $this->addedBy;
    }

    public function setAddedBy($addedBy)
    {
        $this->addedBy = $addedBy;
    }

}