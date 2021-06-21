<?php

class dodanie_zamowienia_zestawu extends Controller
{

    public function __construct()
    {
        session_start();
		if (!isset($_SESSION['initiated'])) {
			session_regenerate_id();
			$_SESSION['initiated'] = true;
		}
        if (!isset($_SESSION['koszykz'])) {
            $_SESSION['koszykz'] = array();
        }
    }

    public function addOrder()
    {
        $klient = $this->model('Klient');
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $address = $_POST['adress'];
        $phone = (string)$_POST['phone'];
        $data = $_POST['data'];
        $godzina = $_POST['godzina'];
        $forma = (int)$_POST['forma'];
        $cena = (int)$_SESSION['cenapz'];
        $zestaw = TRUE;
        $zamowienie = $this->model('Zamowienie');
        $zamowienieLista = $zamowienie->checkSetOfDish($data);
        if (!empty($zamowienieLista)) {
            foreach ($zamowienieLista as $row) {
                $czas = (int)$row['godzina'];
                if ($czas >= (int)$godzina)
                    $godzina = (int)$row['godzina'] + 3;				
            }
        }
		if ((int)$godzina < 21) {
			if (isset($_SESSION['wrongDate']))
				unset($_SESSION['wrongDate']);
			$nowy_klient = $klient->addNewClient($name, $surname, $address, $phone);
			$nowe_zamowienie = $zamowienie->addNewOrder($nowy_klient, $cena, $zestaw, $data, $godzina, $forma);
			$kosz_klienta = $_SESSION['koszykz'];
			$zestaw_w_zamowieniu = $zamowienie->addSetOfDishesToOrder($kosz_klienta, $nowe_zamowienie);
			$_SESSION['koszykz'] = array();
			header('Location: ../../public/potwierdzenie_zamowienia');
		}
		else {
			$_SESSION['wrongDate'] = 'Brak wolnych terminow w wybranym dniu';
			header('Location: ../../public/zestawy');
		}
    }

    public function deleteItem()
    {
        $delete = $_POST['subject2'];
		$prize = $_POST['cena_posilku'];
        $cena = 0;
        for ($i = 0; $i <= count($_SESSION['koszykz']); $i++) {
            if ($_SESSION['koszykz'][$i]['posilki']['id'] == $delete && $_SESSION['koszykz'][$i]['posilki']['cena'] == $prize) {
                unset($_SESSION['koszykz'][$i]);
                $_SESSION['koszykz'] = array_merge(array_filter($_SESSION['koszykz']));
                break;
            }
        }
        for ($i = 0; $i < count($_SESSION['koszykz']); $i++) {
            $cena = $cena + (int)$_SESSION['koszykz'][$i]['posilki']['cena'];
            $ilosc = $ilosc + $_SESSION['koszykz'][$i]['posilki']['ilosc'];
        }
        $_SESSION['cenapz'] = $cena;
        $_SESSION['ilosc_produktowz'] = $ilosc;
        header('Location: ../../public/zestawy/?#navig');
    }

    public function index()
    {
        if (isset($_POST['subject'])) {
            $numb = (int)$_POST['numb'];
            if ($numb == 0)
                $numb = 1;
            $cena = 0;
            $ilosc = 0;
            $towar = (int)$_POST['subject'];
            $posilek = $this->model('Zestaw');
            $posilekTabela = $posilek->getTableFromId($towar);
            $numer = count($_SESSION['koszykz']);
            $_SESSION['koszykz'][$numer]['posilki']['id'] = $posilekTabela[0]['id'];
            $_SESSION['koszykz'][$numer]['posilki']['nazwa'] = $posilekTabela[0]['nazwa'];
            $_SESSION['koszykz'][$numer]['posilki']['cena'] = $numb * $posilekTabela[0]['cena'];
            $_SESSION['koszykz'][$numer]['posilki']['ilosc'] = $numb;

            for ($i = 0; $i < count($_SESSION['koszykz']); $i++) {
                $cena = $cena + (int)$_SESSION['koszykz'][$i]['posilki']['cena'];
                $ilosc = $ilosc + $_SESSION['koszykz'][$i]['posilki']['ilosc'];
            }
            $_SESSION['cenapz'] = $cena;
            $_SESSION['ilosc_produktowz'] = $ilosc;
            header('Location: ../../public/zestawy/?#navig');
        } else {
            header('Location: ../../public/zestawy/');
        }
    }
}