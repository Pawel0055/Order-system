<?php
if (!isset($_SESSION['initiated']))
{
    session_regenerate_id();
    $_SESSION['initiated'] = true;
}
if($_SESSION['dostawca'] == false)
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
                    <div class="col-xs-5 col-xs-offset-4">
                        <h2 class="table-caption">Obecne zamowienia:</h2>
                    </div>
                </div>
                <div class="container edits">
				<h2>Zamowienia zwykle:</h2>
                    <div class="row table-head">
                        <div class="col-xs-2">ID</div>
                        <div class="col-xs-4">Imie</div>
                        <div class="col-xs-3">Nazwisko</div>
                        <div class="col-xs-3">Numer</div>
                    </div>
                    <div id="table"></div>					
                </div>
				<div class="container edits2">
				<h2>Zestawy:</h2>
                    <div class="row table-head">
                        <div class="col-xs-2">ID</div>
                        <div class="col-xs-4">Imie</div>
                        <div class="col-xs-3">Nazwisko</div>
                        <div class="col-xs-3">Numer</div>
                    </div>
                    <div id="table2"></div>
					<div class="row form">
						<div class="col-md-12">
							<form action="/magiste/mgr/mvc/public/przeglad_zamowien/fifoInsertForOrders" method="post">
								<input type="submit" class="btn btn-primary" value="Zobacz obecne zamowienie do wykonania">
							</form>
						</div>
					</div>
					<div class="row form">
						<div class="col-md-12">
							<form action="/magiste/mgr/mvc/public/przeglad_zamowien/fifoInsertForSetOfDish" method="post">
								<input type="submit" class="btn btn-primary" value="Zobacz obecny zestaw do wykonania w dniu dzisiejszym">
							</form>
						</div>
					</div>
                </div>						
                <div class="row form">
                    <div class="col-md-12">
                        <form action="/magiste/mgr/mvc/public/" method="post">
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