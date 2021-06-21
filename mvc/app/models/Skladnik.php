<?php
require_once 'Database.php';

class Skladnik extends Database
{
    // Get table with details of ingredients
    public function getTable()
    {
        $query = $this->conn->prepare('SELECT * FROM skladnik;');
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }	
}