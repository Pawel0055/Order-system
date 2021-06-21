<?php
require_once 'Database.php';

class Klient extends Database
{
	// Adding new client
	public function addNewClient($name, $surname, $address, $phone) {
		$query = $this->conn->prepare('INSERT INTO klient (imie, nazwisko, adres, telefon)
			VALUES (?,?,?,?);');
		$query->execute(array($name, $surname, $address, $phone));
		$klientId = $this->conn->lastInsertId();		
		return $klientId;
    }
}