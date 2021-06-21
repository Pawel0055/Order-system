<?php
require_once 'Database.php';

class Users extends Database
{
    public function checkData($login)
    {	
		$query = $this->conn->prepare('SELECT * FROM users where login=?');
        $query->execute(array($login));
        $result = $query->fetchAll();
        return $result;
    }
	
	public function checkSuppliersData($login)
    {	
		$query = $this->conn->prepare('SELECT * FROM dostawca where login=?');
        $query->execute(array($login));
        $result = $query->fetchAll();
        return $result;
    }
}