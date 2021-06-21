<?php

class zestawy_dostawcy extends Controller
{
    public function index()
    {
        $zamowienie = $this->model('Zamowienie');
        $zamowienieLista = $zamowienie->getSetOfDishesForSuppliers();
        $pierwszy = current($zamowienieLista);
        $id_zamowienia = (int)$pierwszy['id'];
        $dane_klienta_zamowienia = $zamowienie->getClientSetOfDishData($id_zamowienia);
        $dane_o_zamowieniu = $zamowienie->getSetOfDishDetailedTable($id_zamowienia);
        $this->view('zestawy_dostawcy/index', array(
            'dane_o_kliencie' => $dane_klienta_zamowienia,
            'wynik' => $dane_o_zamowieniu));
    }

    public function del()
    {
        $zamowienie = $this->model('Zamowienie');
        $zamowienieLista = $zamowienie->getSetOfDishesForSuppliers();
        $pierwszy = current($zamowienieLista);
        $id_zamowienia = (int)$pierwszy['id'];
        $id_klienta = (int)$pierwszy['id_klienta'];
        $zamowienie->delInfAboutSetOfDishOrder($id_zamowienia, $id_klienta);
        header('Location: ../../public/glowna');
    }
}