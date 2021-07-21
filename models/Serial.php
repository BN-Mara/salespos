<?php

class Serial{
    private $id_serial;
    private $id_pos;
    private $id_product;
    private $creation_date;
    private $addedBy;
    private $serial;

    /**
     * Get the value of id_serial
     */
    public function getIdSerial()
    {
        return $this->id_serial;
    }

    /**
     * Set the value of id_serial
     *
     * @return  self
     */
    public function setIdSerial($id_serial)
    {
        $this->id_serial = $id_serial;

        return $this;
    }

    /**
     * Get the value of id_pos
     */
    public function getIdPos()
    {
        return $this->id_pos;
    }

    /**
     * Set the value of id_pos
     *
     * @return  self
     */
    public function setIdPos($id_pos)
    {
        $this->id_pos = $id_pos;

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
     * Get the value of creation_date
     */
    public function getCreationDate()
    {
        return $this->creation_date;
    }

    /**
     * Set the value of creation_date
     *
     * @return  self
     */
    public function setCreationDate($creation_date)
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    /**
     * Get the value of addedBy
     */
    public function getAddedBy()
    {
        return $this->addedBy;
    }

    /**
     * Set the value of addedBy
     *
     * @return  self
     */
    public function setAddedBy($addedBy)
    {
        $this->addedBy = $addedBy;

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
}