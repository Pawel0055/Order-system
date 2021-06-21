<?php

class dodanie_posilku extends Controller
{
    public function index()
    {
        $posilek = $this->model('Posilek');
        $skladnik = $this->model('Skladnik');
        $typ = $this->model('Typ_posilku');
        $zestaw = $this->model('Zestaw');
        $zestaw = $zestaw->getSetOfDishesTable();
        $typPosilku = $typ->getTable();
        $skladnikiTabela = $skladnik->getTable();
        $rodzaj_dania = $this->model('rodzaj_dania');
        $rodzajdaniaTabela = $rodzaj_dania->getDishsTable();
        $this->view('dodanie_posilku/index', array(
            'typ' => $typPosilku,
            'zestaw' => $zestaw,
            'skladnikiTabela' => $skladnikiTabela,
            'rodzajdaniaTabela' => $rodzajdaniaTabela));
    }
}