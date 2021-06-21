<?php
session_start();
if (!isset($_SESSION['initiated']))
{
    session_regenerate_id();
    $_SESSION['initiated'] = true;
}
if (empty($_SESSION['quesoup'])) {
    $_SESSION['klient'] = $_SESSION['klientbz'];
    $_SESSION['danezamowienia'] = $_SESSION['danezamowieniabz'];
} else {
    $_SESSION['klient'] = $_SESSION['klientzupa'];
    $_SESSION['danezamowienia'] = $_SESSION['danezamowieniazupa'];
}

if (empty($_SESSION['quesoup']) and empty($_SESSION['que']))
    header('Location: ../../public/przeglad_zamowien');

if($_SESSION['admin'] == false)
	header('Location: ../../mvc/public');
?>
<html>
<head>
    <link rel="stylesheet" href="bootstrap.css">
</head>
<body>
<div class="container background">
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <div class="container content">
                <div class="page-header">
                    <h1>Catering</h1>
                </div>
                <div class="row">
                    <div class="col-xs-5 col-xs-offset-3">
                        <h2 class="table-caption">Zamowienie
                            dla: <?= $_SESSION['klient'][0]['imie'] . ' ' . $_SESSION['klient'][0]['nazwisko'] . ' Telefon: ' . $_SESSION['klient'][0]['telefon'] . 'Adres: ' . $_SESSION['klient'][0]['adres'] ?></h2>
                    </div>
                </div>
                <div class="container edits">
                    <div class="row table-head">
                        <div class="col-xs-2 col-xs-offset-3">Nazwa</div>
                        <div class="col-xs-2">Ilosc</div>
                        <div class="col-xs-2">Cena</div>
                    </div>
                    <div id="table-items">
                        <?php
                        foreach ($_SESSION['danezamowienia'] as $row): ?>
                            <div class="row hover">
                                <div class="col-xs-2 col-xs-offset-3"><?= $row['nazwa'] ?></div>
                                <div class="col-xs-2"><?= $row['ilosc'] ?></div>
                                <div class="col-xs-2"><?= $row['cena'] ?></div>
                            </div>
                        <?php endforeach; ?>
                        <div class="col-xs-5 col-xs-offset-3">
                            <h2 class="table-caption">Calkowita cena: <?= $_SESSION['klient'][0]['cena'] ?> zl</h2>
                        </div>
                    </div>
                    <div class="row form">
                        <div class="col-xs-3 col-xs-offset-4">
                            <form action="/magiste/mgr/mvc/public/przeglad_zamowien/assignOrderSupplier" method="post">
                                <input type="submit" class="btn btn-primary" value="Przypisz dostawce">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row form">
                    <div class="col-md-12">
                        <form action="/magiste/mgr/mvc/public/przeglad_zamowien" method="post">
                            <input type="submit" class="btn btn-primary" value="Menu powrot">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>