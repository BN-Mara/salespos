<?php

/**
 * Created by PhpStorm.
 * User: shelton
 * Date: 05/07/2020
 * Time: 21:26
 */
class Pos
{
    private $id_pos;
    private $designation;
    private $city;
    private $province;

    public function setIdPos($id_pos)
    {
        $this->id_pos = $id_pos;
    }

    public function getIdPos()
    {
        return $this->id_pos;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getDesignation()
    {
        return $this->designation;
    }

    public function setDesignation($designation)
    {
        $this->designation = $designation;
    }

    public function getProvince()
    {
        return $this->province;
    }

    public function setProvince($province)
    {
        $this->province = $province;
    }

}