<?php
require_once 'Database.php';

class Zestaw extends Database
{
    // Get set of dishes Table
	public function getSetOfDishesTable() {
        $query = $this->conn->prepare('SELECT * FROM zestaw;');
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
	
	// Get meals in set of dishes
	public function getMealsInSetOfDishes() {
        $query = $this->conn->prepare('SELECT id_posilku, id_zestawu, p.nazwa FROM posilek_w_zestawie z JOIN posilek p ON p.id = z.id_posilku;');
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

	// Get table with details about one set of dish
    public function getTableFromId($id) {
        $query = $this->conn->prepare('SELECT * FROM zestaw WHERE id=? ;');
        $query->execute(array($id));
        $result = $query->fetchAll();
        return $result;
    }
	
	    public function getBusyDate() {
        $query = $this->conn->prepare('select data, COUNT(godzina) as ilosc from zamowienie where zestaw = 1 GROUP BY data HAVING COUNT(godzina) >= 3;');
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
}