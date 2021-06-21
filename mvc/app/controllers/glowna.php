<?php

class glowna extends Controller
{
    public function index()
    {
        $posilek = $this->model('Posilek');
        $alergen = $this->model('Alergen');
        $formaPlatnosci = $this->model('FormaPlatnosci');
        $posilekTabela = $posilek->getTable();
        $skladnikiTabela = $posilek->getIngredientTable();
        $rodzajeDanTabela = $posilek->getDishsTable();
        $listaAlergenow = $alergen->getAllergenTable();
        $forma = $formaPlatnosci->getTable();
        $this->view('glowna/index', array(
            'posilekTabela' => $posilekTabela,
            'skladnikiTabela' => $skladnikiTabela,
            'rodzajeDanTabela' => $rodzajeDanTabela,
            'formaplatnosci' => $forma,
            'listaAlergenow' => $listaAlergenow));
    }

    public function addMeal()
    {
        $skladniki = $_POST['ingredientList'];
        $nazwa = $_POST['nazwa'];
        $rodzaj = $_POST['kind'];
        $cost = $_POST['cost'];
        $typ = $_POST['typ'];
        $zestaw = $_POST['zestaw'];
        if (isset($nazwa, $rodzaj, $cost, $typ, $skladniki, $zestaw)) {
            if (!empty($nazwa) && !empty($cost) && !empty($typ) && !empty($skladniki) && !empty($zestaw) && !empty($rodzaj)) {
                $nazwa = $nazwa;
                $rodzaj = $rodzaj;
                $cost = $cost;
                $typ = $typ;
                $skladniki = $skladniki;
                $zestaw = $zestaw;
                $posilek = $this->model('Posilek');
                $nowyPosilek = $posilek->addNewMeal($skladniki, $nazwa, $rodzaj, $cost, $typ);
                $posilek->addNewSetMeal($nowyPosilek, $zestaw);
                header('Location: ../../public/');
            } else
                return 0;
        } else
            return 0;
    }
}