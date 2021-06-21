<?php
session_start();
if (!isset($_SESSION['initiated']))
{
    session_regenerate_id();
    $_SESSION['initiated'] = true;
}
if ($_SESSION['admin'] == false)
	header('Location: ../../mvc/public');
?>

<html>
<head>
    <link rel="stylesheet" href="/magiste/mgr/mvc/public/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script>
		function validateForm() {
			var x = document.forms["dodaj"]["nazwa"].value;
			var y = document.forms["dodaj"]["kind"].value;
			var z = document.forms["dodaj"]["typ"].value;
			var a = document.forms["dodaj"]["zestaw"].value;
			var b = document.forms["dodaj"]["cost"].value;
			var c = document.forms["dodaj"]["ingredientList[]"];
			var d = "";
			for (var i = 0; i < c.length; i++) {
				if (c[i].checked) {
					d = "niepuste";
					break;
				}
			}			
			if (x == "" || y=="" || z=="" || a=="" || b=="" || d=="") {
				alert("Wypelnij poprawnie wszystkie pola!");
				return false;
			}
		}
    </script>
</head>
<body>
<div class="container background">
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <div class="container content">
                <div class="page-header">
                    <h1>Catering</h1>
                </div>		
					<div class="container test">
						<form name="dodaj" action="/magiste/mgr/mvc/public/glowna/addMeal" onsubmit="return validateForm()" method="post">
							<div class="row form">
								<div class="form-group">
									<div class="col-xs-12 col-xs-offset-3">
										<label class="label-inline">Nazwa posiłku:
										<input id="name" type="text" class="form-inline" name="nazwa"></label>									
									</div>									
								</div>
							</div>
							<div class="row form">						
								<div class="form-group">
									<div class="col-xs-12 col-xs-offset-3">	
									<label class="label-inline">Rodzaj dania:</label>	
										<select name="kind" style="width:100px;">											
											<?php foreach ($data['rodzajdaniaTabela'] as $kind):?>
												<option value="<?php echo strtolower($kind['id']); ?>"><?php echo $kind['nazwa']; ?></option>											
											<?php endforeach; ?>
										</select>
									</div>
								</div>								
							</div>
							<div class="row form">						
								<div class="form-group">
									<div class="col-xs-12 col-xs-offset-3">	
									<label class="label-inline">Typ posilku:</label>	
										<select name="typ" style="width:100px;">											
											<?php foreach ($data['typ'] as $typ):?>
												<option value="<?php echo strtolower($typ['id']); ?>"><?php echo $typ['nazwa']; ?></option>											
											<?php endforeach; ?>
										</select>
									</div>
								</div>								
							</div>
							<div class="row form">						
								<div class="form-group">
									<div class="col-xs-12 col-xs-offset-3">	
									<label class="label-inline">Zestaw:</label>	
										<select name="zestaw" style="width:100px;">											
											<?php foreach ($data['zestaw'] as $zestaw):?>
												<option value="<?php echo strtolower($zestaw['id']); ?>"><?php echo $zestaw['nazwa']; ?></option>											
											<?php endforeach; ?>
										</select>
									</div>
								</div>								
							</div>	
							<div class="row form">						
								<div class="form-group">
									<div class="col-xs-12 col-xs-offset-3">	
										<label class="label-inline">Cena:
										<input id="name" type="number" class="form-inline" name="cost"></label>	
									</div>
								</div>								
							</div>							
							<div class="row form">								
								<div class="col-xs-3 col-xs-offset-4">
								<?php foreach($data['skladnikiTabela'] as $row):?>	
									<div class="form-group checkbox">
										<label>											
											<input class="checkbox-click" type="checkbox" name="ingredientList[]"
												value="<?= $row['id'] ?>">
												<?= $row['nazwa'] ?>
										</label><br>
										<?php endforeach; ?>
									</div>
								</div>								
							</div>
							<div class="row form">
								<div class="col-xs-3 col-xs-offset-4">
									<input type="submit" class="btn btn-primary" name="add" value="Dodaj posilek">
								</div>
							</div>
						</form>		
					</div>			
            </div>
        </div>
    </div>
</div>
</body>
</html>