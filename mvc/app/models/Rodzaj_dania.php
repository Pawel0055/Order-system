<?php
require_once 'Database.php';

class Rodzaj_dania extends Database
{
    // Get table with details of types of dishs
    public function getDishsTable()
    {
        $query = $this->conn->prepare('SELECT * FROM rodzaj_dania;');
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
}