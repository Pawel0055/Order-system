<html>
<head>
    <link rel="stylesheet" href="/magiste/mgr/mvc/public/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script>
		function validateForm() {
			var x = document.forms["dane"]["login"].value;
			var y = document.forms["dane"]["pass"].value;
			var y = document.forms["dane"]["kind"].value;
			if (x == "" || y=="" || y=="") {
				alert("Wypelnij wszystkie pola!");
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
                    <h1>Catering logowanie</h1>
                </div>		
					<div class="container test">
						<form name="dane" action="/magiste/mgr/mvc/public/logowanie/login" onsubmit="return validateForm()" method="post">
							<div class="row form">
								<div class="form-group">
									<div class="col-xs-12 col-md-offset-3">
										<label class="label-inline">Login:
										<input id="login" type="text" class="form-inline" name="login"></label>									
									</div>									
								</div>
							</div>
							<div class="row form">
								<div class="form-group">
									<div class="col-xs-12 col-md-offset-3">
										<label class="label-inline">Haslo:
										<input id="pass" type="password" class="form-inline" name="pass"></label>									
									</div>									
								</div>
							</div>
							<div class="row form">
								<div class="form-group">
									<div class="col-xs-12 col-md-offset-3">
										<label class="label-inline">
										<input type="radio" name="kind" value="admin"> Administrator<br></label>	
										<label class="label-inline">
										<input type="radio" name="kind" value="dostawca"> Dostawca<br></label>							
									</div>									
								</div>
							</div>								
							<div class="row form">
								<div class="col-xs-3 col-xs-offset-4">
									<input type="submit" class="btn btn-primary" name="data" value="Zaloguj">
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