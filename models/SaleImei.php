<?php

/**
 * Created by PhpStorm.
 * User: shelton
 * Date: 27/07/2020
 * Time: 08:55
 */
class SaleImei
{
    private $id_sale;
    private $id_product;
    private $imei;
    private $msisdn;
    private $iccid;
    private $serial;
    private $evcnumber;

    public function getEvcnumber()
    {
        return $this->evcnumber;
    }

    public function setEvcnumber($evcnumber)
    {
        $this->evcnumber = $evcnumber;
    }


    public function getIccid()
    {
        return $this->iccid;
    }

    public function setIccid($iccid)
    {
        $this->iccid = $iccid;
    }

    public function getMsisdn()
    {
        return $this->msisdn;
    }

    public function setMsisdn($msisdn)
    {
        $this->msisdn = $msisdn;
    }

    public function getSerial()
    {
        return $this->serial;
    }

    public function setSerial($serial)
    {
        $this->serial = $serial;
    }
    public function setIdProduct($id_product)
    {
        $this->id_product = $id_product;
    }

    public function getIdProduct()
    {
        return $this->id_product;
    }

    public function getIdSale()
    {
        return $this->id_sale;
    }

    public function setIdSale($id_sale)
    {
        $this->id_sale = $id_sale;
    }

    public function getImei()
    {
        return $this->imei;
    }

    public function setImei($imei)
    {
        $this->imei = $imei;
    }

}