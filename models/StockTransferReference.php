<?php

class StockTransferReference{
    private $id_trans_reference;
    private $id_pos_to;
    private $id_pos_from; 
    private $creation_date;
    private $addedBy;
    private $approvedBy;
    private $approvedTime;
    private $status;

    

    /**
     * Get the value of id_trans_reference
     */
    public function getIdTransReference()
    {
        return $this->id_trans_reference;
    }

    /**
     * Set the value of id_trans_reference
     *
     * @return  self
     */
    public function setIdTransReference($id_trans_reference)
    {
        $this->id_trans_reference = $id_trans_reference;

        return $this;
    }

    /**
     * Get the value of id_pos_from
     */
    public function getIdPosFrom()
    {
        return $this->id_pos_from;
    }

    /**
     * Set the value of id_pos_from
     *
     * @return  self
     */
    public function setIdPosFrom($id_pos_from)
    {
        $this->id_pos_from = $id_pos_from;

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
     * Get the value of approvedBy
     */
    public function getApprovedBy()
    {
        return $this->approvedBy;
    }

    /**
     * Set the value of approvedBy
     *
     * @return  self
     */
    public function setApprovedBy($approvedBy)
    {
        $this->approvedBy = $approvedBy;

        return $this;
    }

    /**
     * Get the value of approvedTime
     */
    public function getApprovedTime()
    {
        return $this->approvedTime;
    }

    /**
     * Set the value of approvedTime
     *
     * @return  self
     */
    public function setApprovedTime($approvedTime)
    {
        $this->approvedTime = $approvedTime;

        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of id_pos_to
     */
    public function getIdPosTo()
    {
        return $this->id_pos_to;
    }

    /**
     * Set the value of id_pos_to
     *
     * @return  self
     */
    public function setIdPosTo($id_pos_to)
    {
        $this->id_pos_to = $id_pos_to;

        return $this;
    }
}