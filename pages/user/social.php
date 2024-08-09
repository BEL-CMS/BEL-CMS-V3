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

use BELCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

if (User::isLogged() === true):
?>
<section id="section_user">
	<?php require 'menu.php'; ?>
	<div id="section_user_profil" class="full">
		<h2>Modification des reseaux sociaux</h2>
		<form action="user/submitsocial" method="post" class="belcms_section_user_main_form">
			<div class="section_user_profil_form_row">
				<i class="fa-brands fa-facebook"></i>
				<input name="facebook" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('FACEBOOK');?>" value="<?=$user->social->facebook?>" pattern="^[a-z\d\.]{5,}$">
			</div>
			<div class="section_user_profil_form_row">
				<i class="fa-brands fa-x-twitter"></i>
				<input name="x_twitter" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('X_TWITTER');?>" value="<?=$user->social->x_twitter?>" pattern="^[A-Za-z0-9_]{1,15}$">
			</div>
			<div class="section_user_profil_form_row">
				<i class="fa-brands fa-discord"></i>
				<input name="discord" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('DISCORD');?>" value="<?=$user->social->discord?>"></p>
			</div>
			<div class="section_user_profil_form_row">
				<i class="fa-brands fa-pinterest"></i>
				<input name="pinterest" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('PINTEREST');?>" value="<?=$user->social->pinterest?>"></p>
			</div>
			<div class="section_user_profil_form_row">
				<i class="fa-brands fa-linkedin-in"></i>
				<input name="linkedIn" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('LINKEDIN');?>" value="<?=$user->social->linkedIn?>"></p>
			</div>
			<div class="section_user_profil_form_row">
				<i class="fa-brands fa-youtube"></i>
				<input name="youtube" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('YOUTUBE');?>" value="<?=$user->social->youtube?>"></p>
			</div>
			<div class="section_user_profil_form_row">
				<i class="fa-brands fa-whatsapp"></i>
				<input name="whatsapp" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('WHATSAPP');?>" value="<?=$user->social->whatsapp?>"></p>
			</div>
			<div class="section_user_profil_form_row">
				<i class="fa-brands fa-instagram"></i>
				<input name="instagram" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('INSTAGRAM');?>" value="<?=$user->social->instagram?>"></p>
			</div>
			<div class="section_user_profil_form_row">
				<i class="fa-brands fa-facebook-messenger"></i>
				<input name="messenger" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('MESSENGER');?>" value="<?=$user->social->messenger?>"></p>
			</div>
			<div class="section_user_profil_form_row">
				<i class="fa-brands fa-tiktok"></i>
				<input name="tiktok" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('TIKTOK');?>" value="<?=$user->social->tiktok?>"></p>
			</div>
			<div class="section_user_profil_form_row">
				<i class="fa-brands fa-snapchat"></i>
				<input name="snapchat" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('SNAPCHAT');?>" value="<?=$user->social->snapchat?>"></p>
			</div>
			<div class="section_user_profil_form_row">
				<i class="fa-brands fa-telegram"></i>
				<input name="telegram" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('TELEGRAM');?>" value="<?=$user->social->telegram?>"></p>
			</div>
			<div class="section_user_profil_form_row">
				<i class="fa-brands fa-reddit"></i>
				<input name="reddit" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('REDDIT');?>" value="<?=$user->social->reddit?>"></p>
			</div>
			<div class="section_user_profil_form_row">
				<i class="fa-brands fa-skype"></i>
				<input name="skype" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('SKYPE');?>" value="<?=$user->social->skype?>"></p>
			</div>
			<div class="section_user_profil_form_row">
				<i class="fa-brands fa-viber"></i>
				<input name="viber" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('VIBER');?>" value="<?=$user->social->viber?>"></p>
			</div>
			<div class="section_user_profil_form_row">
				<i class="fa-brands fa-windows"></i>
				<input name="teams_ms" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('TEAMS_MS');?>" value="<?=$user->social->teams_ms?>"></p>
			</div>
			<div class="section_user_profil_form_row">
				<i class="fa-brands fa-twitch"></i>
				<input name="twitch" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('TWITCH');?>" value="<?=$user->social->twitch?>"></p>
			</div>
			<br>
			<button type="submit" class="belcms_btn"><?=constant('CONFIRM');?></button>
		</form>
	</div>
</section>
<?php
endif;