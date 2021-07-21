<?php

class StockTransfer{
    private $id_transfer;
    private $quantity;
    private $creation_date;
    private $id_trens_reference;
    private $id_product;
    

   

    /**
     * Get the value of quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

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
     * Get the value of id_trens_reference
     */
    public function getIdTrensReference()
    {
        return $this->id_trens_reference;
    }

    /**
     * Set the value of id_trens_reference
     *
     * @return  self
     */
    public function setIdTrensReference($id_trens_reference)
    {
        $this->id_trens_reference = $id_trens_reference;

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
     * Get the value of id_transfer
     */
    public function getIdTransfer()
    {
        return $this->id_transfer;
    }

    /**
     * Set the value of id_transfer
     *
     * @return  self
     */
    public function setIdTransfer($id_transfer)
    {
        $this->id_transfer = $id_transfer;

        return $this;
    }
}