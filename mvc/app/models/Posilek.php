<?php
require_once 'Database.php';

class Posilek extends Database
{
    // Get table with details of dishs
    public function getTable() {
        $query = $this->conn->prepare('SELECT * FROM posilek;');
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
	
	// Get table with details of ingredietns
    public function getIngredientTable() {
        $query = $this->conn->prepare('SELECT s.id, id_posilku, id_skladniku, `nazwa` 
			FROM skladnik_do_posilku s JOIN skladnik sk ON id_skladniku = sk.id ORDER BY id;');
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
	
	// Get table with details of types of dishs
    public function getDishsTable() {
        $query = $this->conn->prepare('SELECT * FROM rodzaj_dania;');
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
	
	// Adding new meal
    public function addNewMeal($skladniki, $nazwa, $rodzaj, $cena, $typ) {
		$query = $this->conn->prepare('INSERT INTO posilek (nazwa, rodzaj_dania_id, cena, id_typu_posilku)
			VALUES (?,?,?,?);');
		$query->execute(array($nazwa, $rodzaj, $cena, $typ));
		$lastId = $this->conn->lastInsertId();
		
		$query2 = $this->conn->prepare('SELECT id FROM posilek 
			WHERE nazwa=? ;');
		$query2->execute(array($nazwa));
		$result = $query2->fetch(PDO::FETCH_ASSOC);
		
		foreach ($skladniki as $skladnik_do_posilku) {
			$query3 = $this->conn->prepare('INSERT INTO skladnik_do_posilku (id_posilku, id_skladniku)
			VALUES (?,?);');
			$query3->execute(array($result['id'], $skladnik_do_posilku));
		}		
		
		return $lastId;
    }
	
	public function addNewSetMeal($posilek, $zestaw) {
		$query = $this->conn->prepare('INSERT INTO posilek_w_zestawie (id_posilku, id_zestawu)
			VALUES (?,?);');
		$query->execute(array($posilek, $zestaw));
    }
	
	// Get table with details about one dish
    public function getTableFromId($id) {
        $query = $this->conn->prepare('SELECT * FROM posilek WHERE id=? ;');
        $query->execute(array($id));
        $result = $query->fetchAll();
        return $result;
    }
}