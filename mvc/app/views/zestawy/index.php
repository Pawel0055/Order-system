<?php
session_start();
if (!isset($_SESSION['initiated']))
{
    session_regenerate_id();
    $_SESSION['initiated'] = true;
}
?>
<html>
<head>
	<script>
		function validateForm() {
			var data = document.forms["orderForm"]["data"].value;
			var x = document.forms["orderForm"]["name"].value;
			var y = document.forms["orderForm"]["surname"].value;
			var z = document.forms["orderForm"]["adress"].value;
			var a = document.forms["orderForm"]["phone"].value;
			var b = document.forms["orderForm"]["godzina"].value;
			var digits = a.replace(/\D/g, "");
			var phoneRe = /^[2-9]\d{2}[2-9]\d{2}\d{3}$/;
			if (data == "" || x == "" || y=="" || z=="" || a=="" || b=="" || !phoneRe.test(digits)) {
				alert("Wypelnij poprawnie wszystkie pola!");
				return false;
			}
		}
	</script>
    <link rel="stylesheet" href="/magiste/mgr/mvc/public/bootstrap.css">
</head>
<body>
<div class="container background">
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <div class="container content">
                <div class="page-header">
                    <h1>Catering - zestawy</h1>
                </div>
				<?php foreach ($data['zestawTabela'] as $kind): ?>
					<div class="container kind">
						<h2>Zestaw <?= $kind['nazwa'] ?></h2>
					</div>
					<div class="container test">
						<div class="row table-head">
							<div class="col-xs-4">Nazwa</div>
							<div class="col-xs-4">Sk�adniki</div>
							<div class="col-xs-4">Alergeny</div>
						</div>
						<div id="table-items">
							<?php foreach ($data['posilkiZestaw'] as $row):
								if ($row['id_zestawu'] != $kind['id']) {
									continue;
								}?>
								<div class="row hover click">
									<div class="col-xs-4"><?= $row['nazwa'] ?></div>
									<div class="col-xs-4">
									<?php foreach ($data['skladnikiTabela'] as $item) {
											if ($item['id_posilku'] == $row['id_posilku']) {
												echo $item['nazwa'] . ', ';
											}
										}?>
									</div>
									<div class="col-xs-4">
										<?php foreach ($data['listaAlergenow'] as $item) {
											foreach ($data['skladnikiTabela'] as $item2) {
												if($item2['id_posilku'] == $row['id_posilku'] and $item['id_skladnika'] == $item2['id_skladniku'])
													echo $item['nazwa'] . ', ';
											}
										}?>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="col-xs-8 col-xs-offset-4">
						<h3>Cena za zestaw: <?= $kind['cena'] ?> zl</h3>
					</div>
					<div class="col-xs-8 col-xs-offset-4">
						<form action="/magiste/mgr/mvc/public/dodanie_zamowienia_zestawu/index" method="post">
							Ilosc:<input type="number" name="numb" class="form-inline" placeholder="1" min="1" max="5" style="width: 5em;"></input>
							<button name="subject" class="btn btn-primary" type="submit" value="<?= $kind['id'] ?>">Dodaj zestaw do koszyka</button>
						</form>
					</div>
				<?php endforeach; ?>
				<?php
				if (isset($_SESSION['koszykz']) and count($_SESSION['koszykz'])>0) {

					echo '<div class="container kind summ" id="navig">';
						echo '<h2>';
							echo 'Podsumowanie zam�wienia:';
						echo '</h2>';
					echo '</div>';
					echo '<div class="row table-head summary-head">';
						echo '<div class="col-xs-2">Nazwa:</div>';
						echo '<div class="col-xs-2">Ilosc: ';
							echo $_SESSION['ilosc_produktowz'];
						echo '</div>';
						echo '<div class="col-xs-3">Calkowity koszt: ';
							echo $_SESSION['cenapz'] . ' z�';
						echo '</div>';
						echo '<div class="col-xs-1 col-xs-offset-3">Usu� z koszyka: ';
						echo '</div>';
					echo '</div>';
					for($i=0; $i <= count($_SESSION['koszykz']); $i++){
						if (empty($_SESSION['koszykz'][$i]['posilki']))
							continue;
						echo '<div class="row hover pizza-head">';
							echo '<div class="col-xs-2">';
							echo $_SESSION['koszykz'][$i]['posilki']['nazwa'];
							echo '</div>';
							echo '<div class="col-xs-2">';
								echo $_SESSION['koszykz'][$i]['posilki']['ilosc'];
							echo '</div>';
							echo '<div class="col-xs-3">';
								echo $_SESSION['koszykz'][$i]['posilki']['cena'] . ' z�';
							echo '</div>';
							echo '<div class="col-xs-1 col-xs-offset-3">';
								echo '<form action="/magiste/mgr/mvc/public/dodanie_zamowienia_zestawu/deleteItem" method="post">';
									echo '<button name="subject2" class="btn btn-primary" type="submit" value="';
									echo $_SESSION['koszykz'][$i]['posilki']['id'];
									echo '">x';
									echo '</button>';
									echo '<input type="hidden" name="cena_posilku" value="'.$_SESSION['koszykz'][$i]['posilki']['cena'].'">';
								echo '</form>';
							echo '</div>';
						echo '</div>';
					}
					echo '<form name="orderForm" action="/magiste/mgr/mvc/public/dodanie_zamowienia_zestawu/addOrder" onsubmit="return validateForm()" method="post">';
						echo '<div class="row form">';
							echo '<div class="col-xs-8 col-md-offset-4">';
								echo '<label class="label-inline">Imie: ';
								echo '<input type="text" class="form-inline2" name="name" required></label>';
							echo '</div>';
						echo '</div>';
						echo '<div class="row form">';
							echo '<div class="col-xs-8 col-md-offset-4">';
								echo '<label class="label-inline">Nazwisko: ';
								echo '<input type="text" class="form-inline2" name="surname" required></label>';
							echo '</div>';
						echo '</div>';
						echo '<div class="row form">';
							echo '<div class="col-xs-8 col-md-offset-4">';
								echo '<label class="label-inline">Adres: ';
								echo '<input type="text" class="form-inline2" name="adress" required></label>';
							echo '</div>';
						echo '</div>';
						echo '<div class="row form">';
							echo '<div class="col-xs-8 col-md-offset-4">';
								echo '<label class="label-inline">Telefon: ';
								echo '<input type="tel" class="form-inline2" id="phone" name="phone" required>';
							echo '</div>';
						echo '</div>';
						echo '<div class="row form">';
							echo '<div class="col-xs-8 col-md-offset-4">';
								echo '<label class="label-inline">Wybierz date: ';
								echo '<input type="date" class="form-inline2" name="data" required></label>';
							echo '</div>';
						echo '</div>';
						echo '<div class="row form">';
							echo '<div class="col-xs-8 col-md-offset-4">';
								echo '<label class="label-inline">Wybierz godzine*:</label> ';
								echo '<select name="godzina">';
									echo '<option value = "12">12</option>';
									echo '<option value = "14">14</option>';
									echo '<option value = "15">15</option>';
								echo '</select>';
							echo '</div>';
						echo '</div>';
						echo '<div class="row form">';
							echo '<div class="col-xs-8 col-xs-offset-4">';
								echo '<label class="label-inline">Forma platnosci:</label>	';
									echo '<select name="forma" style="width:100px;">';
										foreach ($data['formaplatnosci'] as $forma):
											echo '<option value="'.$forma["id"].'">'.$forma["nazwa"].'</option>';
										endforeach;
									echo '</select>';
							echo '</div>';
						echo '</div>';
						echo '<div class="row form">';
							echo '<div class="col-xs-12 col-md-4 col-md-offset-4">';
								echo '<label class="label-inline">* - uwaga, godzina moze byc przesunieta z powodu mozliwosci wczesniejszej rezerwacji tej godziny, o mozliwych zmianach zostaniesz poinformowany ';
							echo '</div>';
						echo '</div>';
						echo '<div class="row form">';
							echo '<div class="col-xs-6 col-md-offset-4">';
								echo '<label class="label-inline" style=color:red;">';
								echo 'Lista zajetych terminow:';
									foreach ($data['listaZajetychTerminow'] as $lista):
										echo ''.$lista["data"].',  ';
									endforeach;
								echo '</label>';
							echo '</div>';
						echo '</div>';
						echo '<div class="row form">';
							if (isset($_SESSION['wrongDate'])) {
								echo '<div class="col-xs-8 col-md-offset-4">';
									echo '<label class="label-inline" style="color:red;">Brak wolnych terminow w wybranym dniu</label>';
								echo '</div>';
							}
						echo '</div>';
							echo '<div class="col-xs-2 col-md-offset-5">';
								echo '<input type="submit" class="btn btn-primary" name="send" value="Zloz zamowienie">';
							echo '</div>';
						echo '</div>';
					echo '</form>';
				}
				?>
				<div class="row form">
                    <div class="col-md-12">
                        <form action="/magiste/mgr/mvc/public/" method="post">
                            <input type="submit" class="btn btn-primary" value="Wroc do strony glownej">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>