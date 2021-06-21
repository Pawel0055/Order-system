<?php

class przeglad_zamowienia extends Controller
{
    private $zamowienieId;

    public function __construct()
    {
        session_start();
		if (!isset($_SESSION['initiated'])) {
			session_regenerate_id();
			$_SESSION['initiated'] = true;
		}
        $this->zamowienieId = $_SESSION['zamowienieId'];
    }

    public function index()
    {
        $zamowienie = $this->model('Zamowienie');
        $wynik = $zamowienie->getDetailedTable($this->zamowienieId);
        $dane_o_kliencie = $zamowienie->getClientData($this->zamowienieId);
        $this->view('przeglad_zamowienia/index', array(
            'zamowienieId' => $this->zamowienieId,
            'wynik' => $wynik,
            'dane_o_kliencie' => $dane_o_kliencie));
    }
}