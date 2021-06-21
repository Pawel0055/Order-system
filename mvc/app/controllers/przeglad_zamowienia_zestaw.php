<?php

class przeglad_zamowienia_zestaw extends Controller
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
        $wynik = $zamowienie->getSetOfDishDetailedTable($this->zamowienieId);
        $dane_o_kliencie = $zamowienie->getClientSetOfDishData($this->zamowienieId);
        $this->view('przeglad_zamowienia_zestaw/index', array(
            'zamowienieId' => $this->zamowienieId,
            'wynik' => $wynik,
            'dane_o_kliencie' => $dane_o_kliencie));
    }
}