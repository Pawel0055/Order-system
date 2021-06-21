<?php

class dodanie_zamowienia extends Controller
{

    public function __construct()
    {
        session_start();
        if (!isset($_SESSION['initiated'])) {
            session_regenerate_id();
            $_SESSION['initiated'] = true;
        }
        if (!isset($_SESSION['koszyk'])) {
            $_SESSION['koszyk'] = array();
        }
    }

    public function addOrder()
    {
        $klient = $this->model('Klient');
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $address = $_POST['adress'];
        $phone = (string)$_POST['phone'];
        $cena = (int)$_SESSION['cenap'];
        $forma = (int)$_POST['forma'];
        $zestaw = FALSE;
        $data = date("Y-m-d");
        $godzina = (string)0;
        $nowy_klient = $klient->addNewClient($name, $surname, $address, $phone);
        $zamowienie = $this->model('Zamowienie');
        $nowe_zamowienie = $zamowienie->addNewOrder($nowy_klient, $cena, $zestaw, $data, $godzina, $forma);
        $kosz_klienta = $_SESSION['koszyk'];
        $posilki_w_zamowieniu = $zamowienie->addDishesToOrder($kosz_klienta, $nowe_zamowienie);
        $_SESSION['koszyk'] = array();
        header('Location: ../../public/potwierdzenie_zamowienia');
    }

    public function deleteItem()
    {
        $delete = $_POST['subject2'];
		$prize = $_POST['cena_posilku'];
        $cena = 0;
        if (!empty($_SESSION['koszyk'])) {
            for ($i = 0; $i <= count($_SESSION['koszyk']); $i++) {
                if ($_SESSION['koszyk'][$i]['posilki']['id'] == $delete && $_SESSION['koszyk'][$i]['posilki']['cena'] == $prize) {
                    unset($_SESSION['koszyk'][$i]);
                    $_SESSION['koszyk'] = array_merge(array_filter($_SESSION['koszyk']));
                    break;
                }
            }
            for ($i = 0; $i < count($_SESSION['koszyk']); $i++) {
                $cena = $cena + (int)$_SESSION['koszyk'][$i]['posilki']['cena'];
                $ilosc = $ilosc + $_SESSION['koszyk'][$i]['posilki']['ilosc'];
            }
            $_SESSION['cenap'] = $cena;
            $_SESSION['ilosc_produktow'] = $ilosc;
            header('Location: ../../public/glowna?#navig');
        } else
            return 0;

    }

    public function index()
    {
        $numb = (int)$_POST['numb'];
        if ($numb == 0)
            $numb = 1;
        $cena = 0;
        $ilosc = 0;
        $towar = (int)$_POST['subject'];
        $posilek = $this->model('Posilek');
        $posilekTabela = $posilek->getTableFromId($towar);
        if (!empty($posilekTabela) || $ilosc > 5 || $ilosc < 1) {
            $numer = count($_SESSION['koszyk']);
            $_SESSION['koszyk'][$numer]['posilki']['id'] = $posilekTabela[0]['id'];
            $_SESSION['koszyk'][$numer]['posilki']['nazwa'] = $posilekTabela[0]['nazwa'];
            $_SESSION['koszyk'][$numer]['posilki']['cena'] = $numb * $posilekTabela[0]['cena'];
            $_SESSION['koszyk'][$numer]['posilki']['ilosc'] = $numb;

            for ($i = 0; $i < count($_SESSION['koszyk']); $i++) {
                $cena = $cena + (int)$_SESSION['koszyk'][$i]['posilki']['cena'];
                $ilosc = $ilosc + $_SESSION['koszyk'][$i]['posilki']['ilosc'];
            }
            $_SESSION['cenap'] = $cena;
            $_SESSION['ilosc_produktow'] = $ilosc;
            header('Location: ../../public/glowna?#navig');
        } else
            return 0;
    }
}