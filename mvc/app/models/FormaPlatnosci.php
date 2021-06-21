<?php
require_once 'Database.php';

class FormaPlatnosci extends Database
{
	public function getTable() {
		$query = $this->conn->prepare('SELECT *FROM forma_platnosci');
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
}