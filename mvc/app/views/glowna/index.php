<?php
session_start();
if (!isset($_SESSION['initiated']))
{
    session_regenerate_id();
    $_SESSION['initiated'] = true;
}
if(isset($_SESSION['admin']) || isset($_SESSION['dostawca'])) {
	echo '<form action="/magiste/mgr/mvc/public/logowanie/logout" method="post">';
		echo '<input type="submit" class="btn btn-primary" name="send" value="Wyloguj">';
	echo '</form>';
}
?>
<html>
<head>
	<script>
		function validateForm() {
			var x = document.forms["orderForm"]["name"].value;
			var y = document.forms["orderForm"]["surname"].value;
			var z = document.forms["orderForm"]["adress"].value;
			var a = document.forms["orderForm"]["phone"].value;
			var digits = a.replace(/\D/g, "");
			var phoneRe = /^[2-9]\d{2}[2-9]\d{2}\d{3}$/;
			if (x == "" || y=="" || z=="" || a=="" || !phoneRe.test(digits)) {
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
                    <h1>Catering</h1>
					<?php
					if(isset($_SESSION['admin']) || isset($_SESSION['dostawca'])) {
						echo '<form action="/magiste/mgr/mvc/public/dodanie_posilku" method="post">';
							echo '<input type="submit" class="btn btn-primary" name="new_p" value="Dodaj posilek">';
						echo '</form>';
						echo '<form action="/magiste/mgr/mvc/public/przeglad_zamowien" method="post">';
							echo '<input type="submit" class="btn btn-primary" name="order" value="Zobacz obecne zamowienia">';
						echo '</form>';
						echo '<form action="/magiste/mgr/mvc/public/zamowienia_dostawcy" method="post">';
							echo '<input type="submit" class="btn btn-primary" name="order" value="Zamowienia dostawcy">';
						echo '</form>';
						echo '<form action="/magiste/mgr/mvc/public/zestawy_dostawcy" method="post">';
							echo '<input type="submit" class="btn btn-primary" name="order" value="Zestawy dostawcy">';
						echo '</form>';
					}
					?>
                </div>
				<?php foreach ($data['rodzajeDanTabela'] as $kind): ?>
					<div class="container kind">
						<h2><?= $kind['nazwa'] ?></h2>
					</div>
					<div class="container test">
						<div class="row table-head">
							<div class="col-xs-2">Nazwa</div>
							<div class="col-xs-2">Cena</div>
							<div class="col-xs-2">Sk??adniki</div>
							<div class="col-xs-2">Alergeny</div>
							<div class="col-xs-1">Ilosc</div>
						</div>
						<div id="table-items">
							<?php foreach ($data['posilekTabela'] as $row):
								if ($row['rodzaj_dania_id'] != $kind['id']) {
									continue;
								}?>
								<div class="row hover click">
									<div class="col-xs-2"><?= $row['nazwa'] ?></div>
									<div class="col-xs-2"><?= $row['cena'] .' z??' ?></div>
									<div class="col-xs-2">
									    <?php foreach ($data['skladnikiTabela'] as $item) {
											if ($item['id_posilku'] == $row['id']) {
												echo $item['nazwa'] . ', ';
											}
										}?>
									</div>

									<div class="col-xs-2">
										<?php foreach ($data['listaAlergenow'] as $item) {
											foreach ($data['skladnikiTabela'] as $item2) {
												if($item2['id_posilku'] == $row['id'] and $item['id_skladnika'] == $item2['id_skladniku'])
													echo $item['nazwa'] . ', ';
											}
										}?>
									</div>

									<div class="col-xs-1">
										<form action="/magiste/mgr/mvc/public/dodanie_zamowienia/index" method="post">
											<input type="number" name="numb" class="form-inline" placeholder="1" min="1" max="5" style="width: 5em;"></input>
									</div>
									<div class="col-xs-1 col-xs-offset-1">
										<button name="subject" class="btn btn-primary" type="submit" value="<?= $row['id'] ?>">+</button>
									</div>
										</form>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endforeach; ?>

				<?php
				if (isset($_SESSION['koszyk']) and count($_SESSION['koszyk'])>0){

					echo '<div class="container kind summ" id="navig">';
						echo '<h2>';
							echo 'Podsumowanie zam??wienia:';
						echo '</h2>';
					echo '</div>';
					echo '<div class="row table-head summary-head">';
						echo '<div class="col-xs-2">Nazwa:</div>';
						echo '<div class="col-xs-2">Ilosc: ';
							echo $_SESSION['ilosc_produktow'];
						echo '</div>';
						echo '<div class="col-xs-3">Calkowity koszt: ';
						echo $_SESSION['cenap'] . ' z??';
						echo '</div>';
						echo '<div class="col-xs-1 col-xs-offset-3">Usu?? z koszyka: ';
						echo '</div>';
					echo '</div>';
					for($i=0; $i <= count($_SESSION['koszyk']); $i++){
						if (empty($_SESSION['koszyk'][$i]['posilki']))
							continue;
						echo '<div class="row hover pizza-head">';
							echo '<div class="col-xs-2">';
							echo $_SESSION['koszyk'][$i]['posilki']['nazwa'];
							echo '</div>';
							echo '<div class="col-xs-2">';
							echo $_SESSION['koszyk'][$i]['posilki']['ilosc'];
							echo '</div>';
							echo '<div class="col-xs-3">';
							echo $_SESSION['koszyk'][$i]['posilki']['cena'] . ' z??';
							echo '</div>';
							echo '<div class="col-xs-1 col-xs-offset-3">';
								echo '<form action="/magiste/mgr/mvc/public/dodanie_zamowienia/deleteItem" method="post">';
									echo '<button name="subject2" class="btn btn-primary" type="submit" value="';
									echo $_SESSION['koszyk'][$i]['posilki']['id'];
									echo '">x';
									echo '</button>';
									echo '<input type="hidden" name="cena_posilku" value="'.$_SESSION['koszyk'][$i]['posilki']['cena'].'">';
								echo '</form>';
							echo '</div>';
						echo '</div>';
					}
					echo '<form name="orderForm" action="/magiste/mgr/mvc/public/dodanie_zamowienia/addOrder" onsubmit="return validateForm()" method="post">';
						echo '<div class="row form">';
							echo '<div class="form-group2">';
								echo '<div class="col-xs-8 col-md-offset-4">';
									echo '<label class="label-inline">Imie: ';
									echo '<input type="text" class="form-inline2" name="name" required></label>';
								echo '</div>';
								echo '<div class="col-xs-8 col-md-offset-4">';
									echo '<label class="label-inline">Nazwisko: ';
									echo '<input type="text" class="form-inline2" name="surname" required></label>';
								echo '</div>';
								echo '<div class="col-xs-8 col-md-offset-4">';
									echo '<label class="label-inline">Adres: ';
									echo '<input type="text" class="form-inline2" name="adress" required></label>';
								echo '</div>';
								echo '<div class="col-xs-8 col-md-offset-4">';
									echo '<label class="label-inline">Telefon: ';
									echo '<input type="tel" class="form-inline2" id="phone" name="phone" required>';
								echo '</div>';
								echo '<div class="col-xs-8 col-md-offset-4">';
									echo '<label class="label-inline">Forma platnosci:</label>	';
										echo '<select name="forma" style="width:100px;">';
											foreach ($data['formaplatnosci'] as $forma):
												echo '<option value="'.$forma["id"].'">'.$forma["nazwa"].'</option>';
											endforeach;
										echo '</select>';
								echo '</div>';
								echo '<div class="col-xs-8 col-md-offset-5">';
									echo '<input type="submit" class="btn btn-primary" name="send" value="Zloz zamowienie">';
								echo '</div>';
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