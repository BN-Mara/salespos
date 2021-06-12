<?php

/**
 * Created by PhpStorm.
 * User: shelton
 * Date: 05/07/2020
 * Time: 21:42
 */
class SaleReference
{
    private $id_ref;
    private $id_client;
    private $nbre_article;
    private $reference;
    private $total;
    private $addedBy;

    public function setAddedBy($addedBy)
    {
        $this->addedBy = $addedBy;
    }

    public function getAddedBy()
    {
        return $this->addedBy;
    }

    public function getIdRef()
    {
        return $this->id_ref;
    }

    public function setIdRef($id_ref)
    {
        $this->id_ref = $id_ref;
    }

    public function getIdClient()
    {
        return $this->id_client;
    }

    public function setIdClient($id_client)
    {
        $this->id_client = $id_client;
    }

    public function getNbreArticle()
    {
        return $this->nbre_article;
    }

    public function setNbreArticle($nbre_article)
    {
        $this->nbre_article = $nbre_article;
    }

    public function getReference()
    {
        return $this->reference;
    }

    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }

}