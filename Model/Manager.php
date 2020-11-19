<?php
namespace Blog\Model; 

class Manager
{
    protected function dbConnect()
    {
        $db = new \PDO('mysql:host=localhost;dbname=blogjeanforteroche;charset=utf8', 'root', 'root', array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
        return $db;
    }
}