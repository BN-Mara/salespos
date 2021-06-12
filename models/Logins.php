<?php

class Logins
{
    private $user;
	private $last_login;
	private $granted;
	private $logout;
	private $ip;
	private $usercheck; 
    
	
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
    public function setNoms($last_login)
    {
        $this->last_login = $last_login;
    }
	/**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $id_user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
		/**
     * @return mixed
     */
    public function getGranted()
    {
        return $this->granted;
    }

    /**
     * @param mixed $granted
     */
    public function setIdUser($granted)
    {
        $this->granted = $granted;
    }
	/**
     * @return mixed
     */
    public function getLogout()
    {
        return $this->logout;
    }

    /**
     * @param mixed $logout
     */
    public function setLogout($logout)
    {
        $this->logout = $logout;
    }
	/**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }
		/**
     * @return mixed
     */
    public function getUsercheck()
    {
        return $this->usercheck;
    }

    /**
     * @param mixed $usercheck
     */
    public function setUsercheck($usercheck)
    {
        $this->usercheck = $usercheck;
    }
}