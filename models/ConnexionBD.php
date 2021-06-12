<?php

abstract class  Connexion
{
    private $host='localhost'; //nom du serveur
    private $dataBase = 'sales_pos'; // nom de la base
    private $User1 = 'sa'; //nom d\'utilisateur
    private $Password1 = 'Benjamin1'; // mot de passe
    // private $port = '5432'; // port
    private $url;

    public function getConnexion()
    {

        try{

            $this->url=('sqlsrv:Server='.$this->host.';Database='.$this->dataBase);
           $conn =  new PDO($this->url,$this->User1,$this->Password1);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;

        }
        catch(PDOException $ex){
            die('<h1> impossible de se connecter à la base de données</h1>'.$ex->getMessage());
        }

    }

}

?>