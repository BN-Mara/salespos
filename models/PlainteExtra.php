<?php

/**
 * Created by PhpStorm.
 * User: shelton
 * Date: 10/08/2020
 * Time: 13:41
 */
class PlainteExtra
{
    private $id_extra;
    private $id_plainte;
    private $facture;
    private $serial;
    private $msisdn;
    private $imei;
    private $evc;

    public function setIdExtra($id_extra)
    {
        $this->id_extra = $id_extra;
    }

    public function getIdExtra()
    {
        return $this->id_extra;
    }

    public function getIdPlainte()
    {
        return $this->id_plainte;
    }

    public function setIdPlainte($id_plainte)
    {
        $this->id_plainte = $id_plainte;
    }

    public function getFacture()
    {
        return $this->facture;
    }

    public function setFacture($facture)
    {
        $this->facture = $facture;
    }

    public function getImei()
    {
        return $this->imei;
    }

    public function setImei($imei)
    {
        $this->imei = $imei;
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


    /**
     * Get the value of evc
     */
    public function getEvc()
    {
        return $this->evc;
    }

    /**
     * Set the value of evc
     *
     * @return  self
     */
    public function setEvc($evc)
    {
        $this->evc = $evc;

        return $this;
    }
}