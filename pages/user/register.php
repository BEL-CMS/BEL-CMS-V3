<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.2]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2023 Bel-CMS
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
		<link href="/pages/user/css/login.css" rel="stylesheet">
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	</head>
	<body id="LoginForm">
		<div class="container">
			<div class="login-form">
				<div class="main-div">
					<div class="panel">
						<h2><?=REGISTRATION;?></h2>
						<p><?=INFO_REGISTRATION;?></p>
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
							<div class="input-group-prepend">
								<div class="input-group-text">
									<?=$_SESSION['TMP_QUERY_REGISTER']['NUMBER_1']?> + 
									<?=$_SESSION['TMP_QUERY_REGISTER']['NUMBER_2']?>
								</div>
							</div>
							<input name="query_register" type="number" min="1" max="18" class="form-control" id="security-password" placeholder="Your Answer" autocomplete="off">
						</div>
						<div class="forgot">
							<a href="/user/lostpassword&echo"><?=FORGOT_PASSWORD;?></a>
						</div>
						<div class="nouser">
							<a href="/user/Login&echo"><?=YOU_HAVE_ACCOUNT;?></a>
						</div>
						<input type="hidden" name="send" value="register">
						<button type="submit" class="btn btn-primary"><?=REGISTER;?></button>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
