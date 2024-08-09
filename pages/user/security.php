<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.8 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

if (User::isLogged() === true):
?>
<section id="section_user">
	<?php require 'menu.php'; ?>
	<div id="section_user_profil" class="full">
		<h2>Modification du mot de passe</h2>
		<form action="user/sendsecurity" method="post">
			<div class="section_user_profil_form_row">
				<i class="fa-solid fa-lock-open"></i>
				<input name="password_old" placeholder="* Entrer votre ancien mot de passe." type="password" value="" autocomplete="off" required="required">
			</div>
			<div class="section_user_profil_form_row">
				<i class="fa-solid fa-key"></i>
				<input type="text" name="password_new" rel="gp" data-size="8" data-character-set="a-z,A-Z,0-9,#">
			</div>
			<div class="section_user_profil_form_row">
				<button class="belcms_btn belcms_bg_grey" type="submit">Enregistrer</button>
			</div>
		</form>
	</div>
</section>
<?php
endif;
