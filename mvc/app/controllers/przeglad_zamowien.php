<?php

class przeglad_zamowien extends Controller
{
    public function __construct()
    {
        session_start();
		if (!isset($_SESSION['initiated'])) {
			session_regenerate_id();
			$_SESSION['initiated'] = true;
		}
        if (!isset($_SESSION['que'])) {
            $_SESSION['que'] = array();
        }
        if (!isset($_SESSION['quesoup'])) {
            $_SESSION['quesoup'] = array();
        }
        if (!isset($_SESSION['setofdish'])) {
            $_SESSION['setofdish'] = array();
        }
    }

    public function index()
    {
        $skladnik = $this->model('Skladnik');
        $skladnikiTabela = $skladnik->getTable();
        $this->view('przeglad_zamowien/index', array(
            'skladnikiTabela' => $skladnikiTabela));
    }

    public function refreshOrdersAjax()
    {
        $zamowienie = $this->model('Zamowienie');
        $zamowienieLista = $zamowienie->getOrdersTable();
        echo json_encode($zamowienieLista);
    }

    public function refreshSetOfDishesOrdersAjax()
    {
        $zamowienie = $this->model('Zamowienie');
        $zamowienieLista = $zamowienie->getSetOfDishesTable();
        echo json_encode($zamowienieLista);
    }

    public function orders($id)
    {
        $zamowienie = $this->model('Zamowienie');
        //session_start();
        $_SESSION['zamowienieId'] = $id;
        header('Location: ../../przeglad_zamowienia');
    }

    public function setOfDishes($id)
    {
        $zamowienie = $this->model('Zamowienie');
        //session_start();
        $_SESSION['zamowienieId'] = $id;
        header('Location: ../../przeglad_zamowienia_zestaw');
    }

    public function fifoInsertForSetOfDish()
    {
        $zamowienie = $this->model('Zamowienie');
        $zamowienieLista = $zamowienie->getCurrentSetOfDishTable();
        if (!empty($zamowienieLista)) {
            for ($i = 0; $i < count($zamowienieLista); $i++) {
                if (empty($_SESSION['setofdish'][$i]) OR !isset($_SESSION['setofdish'][$i]))
                    array_push($_SESSION['setofdish'], $zamowienieLista[$i]);
                else
                    continue;
            }
        }
        // getting first object in queue
        $pierwszy = current($_SESSION['setofdish']);
        $id_zamowienia = (int)$pierwszy['id'];
        $dane_klienta_zamowienia = $zamowienie->getClientSetOfDishData($id_zamowienia);
        $dane_o_zamowieniu = $zamowienie->getSetOfDishDetailedTable($id_zamowienia);
        $_SESSION['klientzestaw'] = $dane_klienta_zamowienia;
        $_SESSION['danezamowieniazestaw'] = $dane_o_zamowieniu;
        if (!empty($zamowienieLista))
            header('Location: ../../public/przeglad_zestawu_do_wykonania');
        else
            header('Location: ../../public/przeglad_zamowien');
    }

    public function fifoInsertForOrders()
    {
        $zamowienie = $this->model('Zamowienie');
        $zamowienieLista = $zamowienie->getOrdersWithoutSoupTable();
        $zamowienieListaZup = $zamowienie->getSoupOrdersTable();
        for ($i = 0; $i < count($zamowienieLista); $i++) {
            if (empty($_SESSION['que'][$i]) OR !isset($_SESSION['que'][$i]))
                array_push($_SESSION['que'], $zamowienieLista[$i]);
            else
                continue;

        }
        for ($i = 0; $i < count($zamowienieListaZup); $i++) {
            if (empty($_SESSION['quesoup'][$i]) OR !isset($_SESSION['quesoup'][$i])) {
                array_push($_SESSION['quesoup'], $zamowienieListaZup[$i]);
            } else {
                continue;
            }
        }

        // getting first object in queue
        $pierwszy = current($_SESSION['que']);
        $pierwszaZupa = current($_SESSION['quesoup']);
        $id_zamowienia = (int)$pierwszy['id'];
        $id_zamowienia_zupy = (int)$pierwszaZupa['id'];
        $dane_klienta_zamowienia = $zamowienie->getClientData($id_zamowienia);
        $dane_klienta_zamowienia_zupa = $zamowienie->getClientData($id_zamowienia_zupy);
        $dane_o_zamowieniu = $zamowienie->getDetailedTable($id_zamowienia);
        $dane_o_zamowieniu_zupy = $zamowienie->getDetailedTable($id_zamowienia_zupy);
        $_SESSION['klientbz'] = $dane_klienta_zamowienia;
        $_SESSION['klientzupa'] = $dane_klienta_zamowienia_zupa;
        $_SESSION['danezamowieniabz'] = $dane_o_zamowieniu;
        $_SESSION['danezamowieniazupa'] = $dane_o_zamowieniu_zupy;
        if (!empty($zamowienieLista) or !empty($zamowienieListaZup))
            header('Location: ../../public/przeglad_zamowienia_do_wykonania');
        else
            header('Location: ../../public/przeglad_zamowien');

    }

    public function assignOrderSupplier()
    {
        $id_zamowienia = $_SESSION['danezamowienia'][0]['id_zamowienia'];
        $zamowienie = $this->model('Zamowienie');
        $zamowienieLista = $zamowienie->orderUpdate($id_zamowienia);
        if (!empty($_SESSION['quesoup'])) {
            array_shift($_SESSION['quesoup']);
            header('Location: ../../public/przeglad_zamowien');
        } else {
            array_shift($_SESSION['que']);
            header('Location: ../../public/przeglad_zamowien');
        }
    }

    public function assignSetOfDishSupplier()
    {
        $id_zamowienia = $_SESSION['danezamowieniazestaw'][0]['id_zamowienia'];
        $zamowienie = $this->model('Zamowienie');
        $zamowienieLista = $zamowienie->orderUpdate($id_zamowienia);
        array_shift($_SESSION['setofdish']);
        header('Location: ../../public/przeglad_zamowien');
    }
}