<?php
require_once 'Database.php';

class Alergen extends Database
{
    // Get Allergen Table
	public function getAllergenTable() {
        $query = $this->conn->prepare('SELECT a.id, id_skladnika, id_alergenu, `nazwa`
			FROM alergen_w_skladniku a JOIN alergen al ON id_alergenu = al.id ORDER BY id;');
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
}