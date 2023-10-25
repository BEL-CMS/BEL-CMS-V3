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

 use BelCMS\User\User as User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
if (User::isLogged()):
?>
<section id="bel_cms_widget_users">
	<div class="bel_cms_widget_users">
		<img src="<?=$user->avatar;?>" alt="avatar_<?=$user->username;?>">
	</div>
	<nav>
		<ul>
			<li>
				<a class="simple-tooltip" title="<?=constant('PROFIL');?>" href="User/Profil"><i class="fas fa-chalkboard-teacher"></i></a>
			</li>
			<li>
				<a class="simple-tooltip" title="<?=constant('MESSAGING_PRIVATE');?>" href="Inbox"><i class="fas fa-envelope"></i></a>
			</li>
			<li>
				<a class="simple-tooltip" title="<?=constant('ADMIN');?>" href="?admin"><i class="fas fa-user-cog"></i></a>
			</li>
		</ul>
	</nav>
</section>
<?php
else:
?>
<section id="bel_cms_widget_users">
	<form id="Login" action="user/sendLogin" method="post">
		<div>
			<i class="fas fa-lock-open"></i> <?=constant('LOGIN_ID');?>
		</div>
		<div class="login-form">
			<div class="main-div">
				<div class="panel">
					<p><?=constant('WELCOME_BACK');?></p>
				</div>
				<form id="Login" action="/user/sendLogin" method="post">
					<div class="form-group">
						<input name="username" required="required" autofocus="" type="text" class="form-control" id="inputEmail" placeholder="Email or username">
					</div>
					<div class="form-group">
						<input name="password" required="required" type="password" class="form-control" id="inputPassword" placeholder="Password">
					</div>
					<div class="form-check">
						<label class="form-check-label">
							<input type="checkbox" class="form-check-input" name="remember" value="true" checked="checked">
								<?=constant('REMEMBER_ME_ON_THIS_COMPUTER');?>
						</label>
					</div>
					<div class="forgot">
						<a href="user/lostpassword&echo"><?=constant('FORGOT_PASSWORD');?></a>
					</div>
					<div class="nouser">
						<a href="User/register&echo"><?=constant('DON_T_HAVE_ACCOUNT');?></a>
					</div>
					<input type="hidden" name="send" value="login">
					<button type="submit" class="btn btn-primary">Login</button>
				</form>
			</div>
		</div>
	</form>
</section>
<?php
endif;