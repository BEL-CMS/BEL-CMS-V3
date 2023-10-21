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

if (Users::isLogged() === false):
	$email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
	$token = isset($_REQUEST['token']) ? $_REQUEST['token'] : '';
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
						<h2><?=RECOVERING_MY_PASS;?></h2>
						<p><?=NAME_MAIL_TOKEN;?></p>
					</div>
					<form id="Login" action="/User/sendLostPassword" method="post">
						<div class="form-group">
							<input type="text" class="form-control" name="value" value="<?=$email?>" placeholder="Your name or private mail" required="required" autocomplete="off">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="token" placeholder="Enter your token" autocomplete="off" value="<?=$token?>">
						</div>
						<div class="forgot">
							<a href="/user/login&echo"><?=YOU_HAVE_ACCOUNT;?></a>
						</div>
						<div class="nouser">
							<a href="/user/register&echo"><?=DON_T_HAVE_ACCOUNT;?></a>
						</div>
						<input type="hidden" name="send" value="lostpassword">
						<button type="submit" class="btn btn-primary"><?=RECOVERY;?></button>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
<?php
endif;
?>