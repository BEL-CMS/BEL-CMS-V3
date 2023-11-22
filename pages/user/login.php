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

$langs =  constant('DIR_LANGS').'langs.fr.php';
require $langs;
use BELCMS\User\User as UserInfos;

if (UserInfos::isLogged() === false):
?>
<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
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
						<h2><?=constant('LOGIN');?></h2>
						<p><?=constant('NAME_MAIL_PASS');?></p>
					</div>
					<form id="Login" action="/user/sendLogin" method="post">
						<div class="form-group">
							<input name="username" required="required" autofocus="" type="text" class="form-control" id="inputEmail" placeholder="<?=constant('MAIL_OR_USERNAME');?>">
						</div>
						<div class="form-group">
							<input name="password" autocomplete="off" required="required" type="password" class="form-control" id="inputPassword" placeholder="<?=constant('PASSWORD');?>">
						</div>
						<div class="form-check">
							<label class="form-check-label">
								<input type="checkbox" class="form-check-input" name="remember" value="true" checked="checked">
									<?=constant('REMEMBER_ME_ON_THIS_COMPUTER');?>
							</label>
						</div>
						<div class="forgot">
							<a href="User/lostpassword&echo"><?=constant('FORGOT_PASSWORD');?></a>
						</div>
						<div class="nouser">
							<a href="User/register&echo"><?=constant('DON_T_HAVE_ACCOUNT');?></a>
						</div>
						<input type="hidden" name="send" value="login">
						<button type="submit" class="btn btn-primary"><?=constant('LOGIN');?><i>==></i></button>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
<?php
endif;
?>
