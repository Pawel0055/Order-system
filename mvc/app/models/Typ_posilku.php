<?php
require_once 'Database.php';

class Typ_posilku extends Database
{
    public function getTable()
    {
        $query = $this->conn->prepare('SELECT * FROM typ_posilku;');
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }	
}