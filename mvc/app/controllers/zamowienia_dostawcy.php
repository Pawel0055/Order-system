<?php

class zamowienia_dostawcy extends Controller
{
    public function index()
    {
        $zamowienie = $this->model('Zamowienie');
        $zamowienieLista = $zamowienie->getSoupOrdersForSuppliers();
        $zamowienieLista2 = $zamowienie->getOrdersForSuppliers();
        if (!empty($zamowienieLista))
            $pierwszy = current($zamowienieLista);
        else
            $pierwszy = current($zamowienieLista2);
        $id_zamowienia = (int)$pierwszy['id'];
        $dane_klienta_zamowienia = $zamowienie->getClientData($id_zamowienia);
        $dane_o_zamowieniu = $zamowienie->getDetailedTable($id_zamowienia);
        $this->view('zamowienia_dostawcy/index', array(
            'dane_o_kliencie' => $dane_klienta_zamowienia,
            'wynik' => $dane_o_zamowieniu));
    }

    public function del()
    {
        $zamowienie_id = (int)$_POST['zamowienie'];
        $zamowienie = $this->model('Zamowienie');
        $id_klienta = $zamowienie->getClientInfForDel($zamowienie_id);
        $id_k = (int)$id_klienta[0]['id_klienta'];
        $zamowienie->delInfAboutOrder($zamowienie_id, $id_k);
        header('Location: ../../public/glowna');
    }
}