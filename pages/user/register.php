<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.9 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<!doctype html>
<html lang="fr">
	<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="/pages/user/css/login.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
	</head>
	<body id="LoginForm">
		
		<div class="container">
			<div class="login-form">
				<div class="main-div">
					<div class="panel">
						<h2><?=constant('REGISTRATION');?></h2>
						<p><?=constant('INFO_REGISTRATION');?></p>
					</div>
					<form id="Login" action="/User/SendRegister" method="post">
						<div class="form-group">
							<input name="email" type="email" class="form-control" id="inputEmail" placeholder="Email">
						</div>
						<div class="form-group">
							<input name="username" type="text" class="form-control" id="inputEmail" placeholder="Username">
						</div>				
						<div class="form-group">
							<input name="passwordhash" type="password" class="form-control" id="inputPassword" placeholder="Password">
						</div>
						<div class="form-group">
							<input name="passwordrepeat" type="password" class="form-control" id="inputPassword" placeholder="Repeat Password">
						</div>
						<div class="input-group form-group">
							<div class="input-group">
								<span class="input-group-text"><?=$captcha['NB_ONE']?> + <?=$captcha['NB_TWO']?></span>
								<input name="query_register" type="text" class="form-control" id="security-password" placeholder="Votre Réponse" autocomplete="off">
							</div>
						</div>
						<div class="form-group">
							<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalCharter">Nous vous demandons de lire le <i style="color: red;">règlement</i></button>
							<div class="modal fade" id="ModalCharter" tabindex="-1" aria-labelledby="charter" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h1 class="modal-title fs-5" id="charter">Règlement</h1>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
											<p><?=$_SESSION['CONFIG_CMS']['CMS_REGISTER_CHARTER'];?></p>
											<input id="myCheck" type="checkbox" name="charter" value="true" required>
										</div>
										<div class="modal-footer">
											<button onclick="myFunction()" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Accepter</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="forgot">
							<a href="/user/lostpassword&echo"><?=constant('FORGOT_PASSWORD');?></a>
						</div>
						<div class="nouser">
							<a href="/user/Login&echo"><?=constant('YOU_HAVE_ACCOUNT');?></a>
						</div>
						<input type="hidden" name="captcha" value="">
						<input type="hidden" name="send" value="register">
						<button type="submit" class="btn btn-primary"><?=constant('REGISTER');?></button>
						<p id="checkText"></p>
					</form>
				</div>
			</div>
		</div>
		<script>
			function myFunction() {
				document.getElementById("myCheck").required = true;
				document.getElementById("checkText").innerHTML = "Accepter le règlement pour pouvoir poursuivre l'enregistrement.";
			}
		</script>
	</body>
</html>
