<?php
if(!isset($data['zamowienieId']))
	header('Location: ../../mvc/public');
?>
<html>
<head>
    <link rel="stylesheet" href="bootstrap.css">
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js" ></script>
    <script type="text/javascript" src="/magiste/mgr/mvc/app/views/przeglad_zamowien/orders.js"></script>
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
                        <h2 class="table-caption">Zamowienie dla: <?= $data['dane_o_kliencie'][0]['imie'] . ' ' . $data['dane_o_kliencie'][0]['nazwisko'] . ' Adres:' .$data['dane_o_kliencie'][0]['adres'] . ' Telefon: ' . $data['dane_o_kliencie'][0]['telefon']  ?></h2>
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
							<h2 class="table-caption">Calkowita cena: <?= $data['dane_o_kliencie'][0]['cena']?> zl</h2>
						</div>
						<div class="col-xs-5 col-xs-offset-3">
							<h2 class="table-caption">Data: <?= $data['dane_o_kliencie'][0]['data']?></h2>
						</div>
						<div class="col-xs-5 col-xs-offset-3">
							<h2 class="table-caption">Godzina: <?= $data['dane_o_kliencie'][0]['godzina']?></h2>
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