<?php

class Xrate{
    private $id_rate;
    private $rate;
    private $addedby;

    public function getIdRate(){
        return $this->id_rate;

    }
    public function setIdRate($id_rate){
        $this->id_rate = $id_rate;
    }
    public function getRate(){
        return $this->rate;
    }
    public function setRate($rate){
        $this->rate = $rate;
    }
    public function getAddedBy(){
        return $this->addedBy;
    }
    public function setAddedBy($addedby){
        $this->addedBy = $addedby;
    }
}