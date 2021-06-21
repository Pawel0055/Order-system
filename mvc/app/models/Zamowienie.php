<?php
require_once 'Database.php';

class Zamowienie extends Database
{
	// Adding new order
	public function addNewOrder($nowy_klient, $cena, $zestaw, $data, $godzina, $forma) {
		$query = $this->conn->prepare('INSERT INTO zamowienie (id_klienta, cena, zestaw, data, godzina, id_formy_platnosci)
			VALUES (?,?,?,?,?,?);');
		$query->execute(array($nowy_klient, $cena, $zestaw, $data, $godzina, $forma));
		$zamowienieId = $this->conn->lastInsertId();	
		return $zamowienieId;
    }
	
	// Adding dishes
	public function addDishesToOrder($kosz_klienta, $nowe_zamowienie) {
		for($i=0; $i < count($kosz_klienta); $i++){
			$id = (int)$kosz_klienta[$i]['posilki']['id'];
			$ilosc = $kosz_klienta[$i]['posilki']['ilosc'];
				$query = $this->conn->prepare('INSERT INTO posilek_w_zamowieniu (id_posilku, id_zamowienia, ilosc)
				VALUES (?,?,?);');
				$query->execute(array($id, $nowe_zamowienie, $ilosc));			
		}
	}
	
	// Adding set of dishes
	public function addSetOfDishesToOrder($kosz_klienta, $nowe_zamowienie) {
		for($i=0; $i < count($kosz_klienta); $i++){
			$id = (int)$kosz_klienta[$i]['posilki']['id'];
			$ilosc = $kosz_klienta[$i]['posilki']['ilosc'];
				$query = $this->conn->prepare('INSERT INTO zestaw_w_zamowieniu (id_zestawu, id_zamowienia, ilosc)
				VALUES (?,?,?);');
				$query->execute(array($id, $nowe_zamowienie, $ilosc));			
		}
	}
	
	// Getting orders table
	public function getOrdersTable() {
		$query = $this->conn->prepare('SELECT z.id, k.imie, k.nazwisko, k.adres, k.telefon FROM zamowienie z 
		JOIN klient k ON k.id=z.id_klienta where zestaw=0 ');
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
	
	// Getting orders table
	public function getOrdersWithoutSoupTable() {
		$query = $this->conn->prepare('SELECT z.id, z.id_klienta, z.cena, z.zestaw, pz.id_posilku, p.id_typu_posilku, pz.id_zamowienia FROM zamowienie z 
		JOIN posilek_w_zamowieniu pz ON z.id=pz.id_zamowienia 
		JOIN posilek p ON p.id=pz.id_posilku where zestaw=0 and id_dostawcy = 0 and p.id_typu_posilku!=1 GROUP BY z.id ');
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
	
	// Getting soup orders
	public function getSoupOrdersTable() {
		$query = $this->conn->prepare('SELECT z.id, z.id_klienta, z.cena, z.zestaw, pz.id_posilku, p.id_typu_posilku, pz.id_zamowienia FROM zamowienie z 
		JOIN posilek_w_zamowieniu pz ON z.id=pz.id_zamowienia 
		JOIN posilek p ON p.id=pz.id_posilku where zestaw=0 and id_dostawcy = 0 GROUP BY z.id HAVING COUNT(pz.id_zamowienia)=1 and p.id_typu_posilku=1');
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
	
	// Getting set of dishes table
	public function getSetOfDishesTable() {
		$query = $this->conn->prepare('SELECT z.id, k.imie, k.nazwisko, k.adres, k.telefon FROM zamowienie z 
		JOIN klient k ON k.id=z.id_klienta where zestaw=1');
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
	
	// Getting current set of dish table 
	public function getCurrentSetOfDishTable() {
		$query = $this->conn->prepare('SELECT *FROM zamowienie where zestaw=1 and id_dostawcy = 0 and data=CURDATE()');
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
	
	// Check if other set of dish exist
	public function checkSetOfDish($date) {
		$query = $this->conn->prepare('SELECT *FROM zamowienie where zestaw=1 and data=?');
        $query->execute(array($date));
        $result = $query->fetchAll();
        return $result;
    }
	
	// Getting table with details about order
	public function getDetailedTable($zamowienieId) {
		$query = $this->conn->prepare('SELECT id_posilku, id_zamowienia, ilosc, ps.nazwa, cena, p.id_zamowienia FROM posilek_w_zamowieniu p JOIN posilek ps ON p.id_posilku=ps.id WHERE id_zamowienia=?;');
        $query->execute(array($zamowienieId));
        $result = $query->fetchAll();
        return $result;
    }
	
		// Getting table with details about set of dish
	public function getSetOfDishDetailedTable($zamowienieId) {
		$query = $this->conn->prepare('SELECT id_zestawu, id_zamowienia, ilosc, z.nazwa, z.cena FROM zestaw_w_zamowieniu zwz JOIN zestaw z ON zwz.id_zestawu=z.id WHERE id_zamowienia=?;');
        $query->execute(array($zamowienieId));
        $result = $query->fetchAll();
        return $result;
    }
	
	// Getting table with details about client and order
	public function getClientData($zamowienieId) {
		$query = $this->conn->prepare('SELECT imie, nazwisko, adres, telefon, cena, k.id FROM klient k JOIN zamowienie z ON z.id_klienta = k.id JOIN posilek_w_zamowieniu ps ON ps.id_zamowienia = z.id WHERE id_zamowienia=?;');
        $query->execute(array($zamowienieId));
        $result = $query->fetchAll();
        return $result;
    }
	// Getting table with details about client and order
	public function getClientSetOfDishData($zamowienieId) {
		$query = $this->conn->prepare('SELECT imie, nazwisko, adres, telefon, cena, z.godzina, z.data FROM klient k JOIN zamowienie z ON z.id_klienta = k.id JOIN zestaw_w_zamowieniu ps ON ps.id_zamowienia = z.id WHERE id_zamowienia=?;');
        $query->execute(array($zamowienieId));
        $result = $query->fetchAll();
        return $result;
    }
	
	// Order update
	public function orderUpdate($zamowienieId) {
		$query = $this->conn->prepare('UPDATE zamowienie SET id_dostawcy=? WHERE id=?;');
        $query->execute(array(1, $zamowienieId));
		return 1;
    }
	
	public function getSoupOrdersForSuppliers() {
		$query = $this->conn->prepare('SELECT z.id, z.id_klienta, z.cena, z.zestaw, pz.id_posilku, p.id_typu_posilku, pz.id_zamowienia FROM zamowienie z 
		JOIN posilek_w_zamowieniu pz ON z.id=pz.id_zamowienia 
		JOIN posilek p ON p.id=pz.id_posilku where zestaw=0 and z.id_dostawcy = 1 
		GROUP BY z.id HAVING COUNT(pz.id_zamowienia)=1 and p.id_typu_posilku=1 ');
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
	
	// Getting orders table
	public function getOrdersForSuppliers() {
		$query = $this->conn->prepare('SELECT z.id, z.id_klienta, z.cena, z.zestaw, pz.id_posilku, p.id_typu_posilku, pz.id_zamowienia FROM zamowienie z 
		JOIN posilek_w_zamowieniu pz ON z.id=pz.id_zamowienia 
		JOIN posilek p ON p.id=pz.id_posilku where zestaw=0 and z.id_dostawcy = 1 and p.id_typu_posilku!=1 GROUP BY z.id ');
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
	
	public function getSetOfDishesForSuppliers() {
		$query = $this->conn->prepare('SELECT *FROM zamowienie where zestaw=1 and id_dostawcy = 1 and data=CURDATE()');
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
	
	public function getClientInfForDel($zamowienie_id) {
		$query = $this->conn->prepare('SELECT id_klienta FROM zamowienie where id=?');
        $query->execute(array($zamowienie_id));
        $result = $query->fetchAll();
        return $result;
    }
	
	public function delInfAboutSetOfDishOrder($zamowienie_id, $klient_id)
	{
		$query = $this->conn->prepare('DELETE FROM zestaw_w_zamowieniu WHERE id_zamowienia=?');
        $query->execute(array($zamowienie_id));
		$query2 = $this->conn->prepare('DELETE FROM zamowienie WHERE id_klienta=?');
        $query2->execute(array($klient_id));
		$query3 = $this->conn->prepare('DELETE FROM klient WHERE id=?');
        $query3->execute(array($klient_id));
        return 1;
	}
	
	public function delInfAboutOrder($zamowienie_id, $klient_id)
	{
		$query = $this->conn->prepare('DELETE FROM posilek_w_zamowieniu WHERE id_zamowienia=?');
        $query->execute(array($zamowienie_id));
		$query2 = $this->conn->prepare('DELETE FROM zamowienie WHERE id_klienta=?');
        $query2->execute(array($klient_id));
		$query3 = $this->conn->prepare('DELETE FROM klient WHERE id=?');
        $query3->execute(array($klient_id));
        return 1;
	}
}