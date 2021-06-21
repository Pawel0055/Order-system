<?php
session_start();
if (!isset($_SESSION['initiated']))
{
    session_regenerate_id();
    $_SESSION['initiated'] = true;
}
if($_SESSION['dostawca'] == false)
	header('Location: ../../mvc/public');

if (empty($data['dane_o_kliencie']) or empty($data['wynik']))
    header('Location: ../public');
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
                            dla: <?= $data['dane_o_kliencie'][0]['adres'] . ' ' . $data['dane_o_kliencie'][0]['nazwisko'] . ' Telefon: ' . $data['dane_o_kliencie'][0]['telefon'] ?></h2>
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
                        foreach ($data['wynik'] as $row): ?>
                            <div class="row hover">
                                <div class="col-xs-2 col-xs-offset-3"><?= $row['nazwa'] ?></div>
                                <div class="col-xs-2"><?= $row['ilosc'] ?></div>
                                <div class="col-xs-2"><?= $row['cena'] ?></div>
                            </div>
                        <?php endforeach; ?>
                        <div class="col-xs-5 col-xs-offset-3">
                            <h2 class="table-caption">Calkowita cena: <?= $data['dane_o_kliencie'][0]['cena'] ?> zl</h2>
                        </div>
                    </div>
                    <div class="row form">
                        <div class="col-xs-4 col-xs-offset-4">
                            <form action="/magiste/mgr/mvc/public/zestawy_dostawcy/del" method="post">
                                <input type="submit" class="btn btn-primary" value="Zrealizowane">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row form">
                    <div class="col-md-12">
                        <form action="/magiste/mgr/mvc/public" method="post">
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