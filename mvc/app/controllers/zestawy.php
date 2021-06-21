<?php

class zestawy extends Controller
{
    public function index()
    {
        $zestaw = $this->model('Zestaw');
        $posilek = $this->model('Posilek');
        $alergen = $this->model('Alergen');
        $formaPlatnosci = $this->model('FormaPlatnosci');
        $zestawTabela = $zestaw->getSetOfDishesTable();
        $posilkiZestaw = $zestaw->getMealsInSetOfDishes();
        $posilekTabela = $posilek->getTable();
        $skladnikiTabela = $posilek->getIngredientTable();
        $rodzajeDanTabela = $posilek->getDishsTable();
        $listaAlergenow = $alergen->getAllergenTable();
        $forma = $formaPlatnosci->getTable();
		$listaZajetychTerminow = $zestaw->getBusyDate();
        $this->view('zestawy/index', array(
            'zestawTabela' => $zestawTabela,
            'posilkiZestaw' => $posilkiZestaw,
            'posilekTabela' => $posilekTabela,
            'skladnikiTabela' => $skladnikiTabela,
            'rodzajeDanTabela' => $rodzajeDanTabela,
            'formaplatnosci' => $forma,
			'listaZajetychTerminow' => $listaZajetychTerminow,
            'listaAlergenow' => $listaAlergenow));
    }
}