<?php

class Iccid{
    private $id;
    private $id_product;
    private $iccid;
    private $msisdn;
    private $type;
    private $profile;
    private $addedBy;
    private $creation_date;
    private $id_pos;

    public function setIdProduct($id_product)
    {
        $this->id_product = $id_product;
    }

    public function getIdProduct()
    {
        return $this->id_product;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setIccid($iccid)
    {
        $this->iccid = $iccid;
    }

    public function getIccid()
    {
        return $this->iccid;
    }

    public function setMsisdn($msisdn)
    {
        $this->msisdn = $msisdn;
    }

    public function getMsisdn()
    {
        return $this->msisdn;
    }
    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }
    public function setProfile($profile)
    {
        $this->profile = $profile;
    }

    public function getProfile()
    {
        return $this->profile;
    }

    public function setAddedBy($addedBy)
    {
        $this->addedBy = $addedBy;
    }

    public function getAddedBy()
    {
        return $this->addedBy;
    }

    public function setCreationDate($creation_date)
    {
        $this->creation_date = $creation_date;
    }

    public function getCreationDate()
    {
        return $this->creation_date;
    }
    
    public function setIdPos($id_pos)
    {
        $this->id_pos = $id_pos;
    }

    public function getIdPos()
    {
        return $this->id_pos;
    }

    
}