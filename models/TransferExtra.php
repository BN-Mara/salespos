<?php

class TransferExtra{
    private $id_transfer_extra;
    private $id_product;
    private $id_tranfer;
    private $imei;
    private $iccid;
    private $serial;
    private $msisdn;
    private $evcnumber;
    


    /**
     * Get the value of id_transfer_extra
     */
    public function getIdTransferExtra()
    {
        return $this->id_transfer_extra;
    }

    /**
     * Set the value of id_transfer_extra
     *
     * @return  self
     */
    public function setIdTransferExtra($id_transfer_extra)
    {
        $this->id_transfer_extra = $id_transfer_extra;

        return $this;
    }

    /**
     * Get the value of id_product
     */
    public function getIdProduct()
    {
        return $this->id_product;
    }

    /**
     * Set the value of id_product
     *
     * @return  self
     */
    public function setIdProduct($id_product)
    {
        $this->id_product = $id_product;

        return $this;
    }

    /**
     * Get the value of id_tranfer
     */
    public function getIdTranfer()
    {
        return $this->id_tranfer;
    }

    /**
     * Set the value of id_tranfer
     *
     * @return  self
     */
    public function setIdTranfer($id_tranfer)
    {
        $this->id_tranfer = $id_tranfer;

        return $this;
    }

    /**
     * Get the value of imei
     */
    public function getImei()
    {
        return $this->imei;
    }

    /**
     * Set the value of imei
     *
     * @return  self
     */
    public function setImei($imei)
    {
        $this->imei = $imei;

        return $this;
    }

    /**
     * Get the value of iccid
     */
    public function getIccid()
    {
        return $this->iccid;
    }

    /**
     * Set the value of iccid
     *
     * @return  self
     */
    public function setIccid($iccid)
    {
        $this->iccid = $iccid;

        return $this;
    }

    /**
     * Get the value of serial
     */
    public function getSerial()
    {
        return $this->serial;
    }

    /**
     * Set the value of serial
     *
     * @return  self
     */
    public function setSerial($serial)
    {
        $this->serial = $serial;

        return $this;
    }

    /**
     * Get the value of msisdn
     */
    public function getMsisdn()
    {
        return $this->msisdn;
    }

    /**
     * Set the value of msisdn
     *
     * @return  self
     */
    public function setMsisdn($msisdn)
    {
        $this->msisdn = $msisdn;

        return $this;
    }
      /**
     * Get the value of evcnumber
     */
    public function getEvcnumber()
    {
        return $this->evcnumber;
    }

    /**
     * Set the value of evcnumber
     *
     * @return  self
     */
    public function setEvcnumber($evcnumber)
    {
        $this->evcnumber = $evcnumber;

        return $this;
    }
}