<?php
namespace Blog\Model; 

class Manager
{
    protected function dbConnect()
    {
        $db = new \PDO('mysql:host=db5001233689.hosting-data.io;dbname=dbs1055516;charset=utf8', 'dbu384171', 'pQ:6yKS88n(|4n', array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
        return $db;
    }
}