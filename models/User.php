<?php

/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 02/03/2019
 * Time: 08:10
 */
class User
{
    private $noms;
    private $username;
    private $password;
    private $phone;
    private $role;
    private $status;
    private $datecreation;
	private $last_login;
    private $pages;
    private $addedBy;
    private $matricule;
    private $fonction;
    private $direction;
    private $id_pos;
    
	
	/**
     * @return mixed
     */
    public function getNoms()
    {
        return $this->noms;
    }

    /**
     * @param mixed $noms
     */
    public function setNoms($noms)
    {
        $this->noms = $noms;
    }
	/**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }
	/**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }
	/**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
	/**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
	/**
     * @return mixed
     */
    public function getDatecreation()
    {
        return $this->datecreation;
    }

    /**
     * @param mixed $datecreation
     */
    public function setDatecreation($datecreation)
    {
        $this->datecreation = $datecreation;
    }
	/**
     * @return mixed
     */
    public function getLastLogin()
    {
        return $this->last_login;
    }

    /**
     * @param mixed $last_login
     */
    public function setLastLogin($last_login)
    {
        $this->last_login = $last_login;
    }
	/**
     * @return mixed
     */
	public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
    /**
     * @return mixed
     */
    public function getAddedBy()
    {
        return $this->addedBy;
    }


    public function setAddedBy($addedBy)
    {
        $this->addedBy = $addedBy;
    }

    public function getPages()
    {
        return $this->pages;
    }

    public function setPages($pages)
    {
        $this->pages = $pages;
    }
    public function getMatricule()
    {
        return $this->matricule;
    }

    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;
    }
    public function getFonction()
    {
        return $this->fonction;
    }
    public function setFonction($fonction)
    {
        $this->fonction = $fonction;
    }
    public function getDirection()
    {
        return $this->direction;
    }
    public function setDirection($direction)
    {
        $this->direction = $direction;
    }

    public function getIdPos()
    {
        return $this->id_pos;
    }

    public function setIdPos($id_pos)
    {
        $this->id_pos = $id_pos;
    }

}