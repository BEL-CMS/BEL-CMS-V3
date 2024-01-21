<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BELCMS\User\User as UserInfos;
use BelCMS\Requires\Common as Common;
require ROOT.DS.'pages'.DS.'user'.DS.'country.php';

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

if (UserInfos::isLogged() === true):
?>
<section id="section_user">
	<div class="flex-wrapper">
		<div class="flex-grid">
			<div class="d-col-4 t-col-4 m-col-12">
				<?php include 'nav.php'; ?>
			</div>
			<div class="d-col-8 t-col-8 m-col-12">
				<form action="user/submitsocial" method="post" class="belcms_section_user_main_form">
					<div class="form_input_social">
						<p class="form_input_social_label"><span class="fb"><i class="fa-brands fa-facebook"></i></span>
						<input name="facebook" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('FACEBOOK');?>" value="<?=$user->social->facebook?>" pattern="^[a-z\d\.]{5,}$"></p>
					</div>
					<div class="form_input_social">
						<p class="form_input_social_label"><span class="twitter"><i class="fa-brands fa-x-twitter"></i></span>
						<input name="x_twitter" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('X_TWITTER');?>" value="<?=$user->social->x_twitter?>" pattern="^[A-Za-z0-9_]{1,15}$"></p>
					</div>
					<div class="form_input_social">
						<p class="form_input_social_label"><span class="discord"><i class="fa-brands fa-discord"></i></span>
						<input name="discord" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('DISCORD');?>" value="<?=$user->social->discord?>"></p>
					</div>
					<div class="form_input_social">
						<p class="form_input_social_label"><span class="pinterest"><i class="fa-brands fa-pinterest"></i></span>
						<input name="pinterest" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('PINTEREST');?>" value="<?=$user->social->pinterest?>"></p>
					</div>
					<div class="form_input_social">
						<p class="form_input_social_label"><span class="linkedin"><i class="fa-brands fa-linkedin-in"></i></span>
						<input name="linkedIn" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('LINKEDIN');?>" value="<?=$user->social->linkedIn?>"></p>
					</div>
					<div class="form_input_social">
						<p class="form_input_social_label"><span class="youtube"><i class="fa-brands fa-youtube"></i></span>
						<input name="youtube" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('YOUTUBE');?>" value="<?=$user->social->youtube?>"></p>
					</div>
					<div class="form_input_social">
						<p class="form_input_social_label"><span class="whatsapp"><i class="fa-brands fa-whatsapp"></i></span>
						<input name="whatsapp" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('WHATSAPP');?>" value="<?=$user->social->whatsapp?>"></p>
					</div>
					<div class="form_input_social">
						<p class="form_input_social_label"><span class="instagram"><i class="fa-brands fa-instagram"></i></span>
						<input name="instagram" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('INSTAGRAM');?>" value="<?=$user->social->instagram?>"></p>
					</div>
					<div class="form_input_social">
						<p class="form_input_social_label"><span class="messenger"><i class="fa-brands fa-facebook-messenger"></i></span>
						<input name="messenger" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('MESSENGER');?>" value="<?=$user->social->messenger?>"></p>
					</div>
					<div class="form_input_social">
						<p class="form_input_social_label"><span class="tiktok"><i class="fa-brands fa-tiktok"></i></span>
						<input name="tiktok" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('TIKTOK');?>" value="<?=$user->social->tiktok?>"></p>
					</div>
					<div class="form_input_social">
						<p class="form_input_social_label"><span class="snapchat"><i class="fa-brands fa-snapchat"></i></span>
						<input name="snapchat" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('SNAPCHAT');?>" value="<?=$user->social->snapchat?>"></p>
					</div>
					<div class="form_input_social">
						<p class="form_input_social_label"><span class="telegram"><i class="fa-brands fa-telegram"></i></span>
						<input name="telegram" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('TELEGRAM');?>" value="<?=$user->social->telegram?>"></p>
					</div>
					<div class="form_input_social">
						<p class="form_input_social_label"><span class="reddit"><i class="fa-brands fa-reddit"></i></span>
						<input name="reddit" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('REDDIT');?>" value="<?=$user->social->reddit?>"></p>
					</div>
					<div class="form_input_social">
						<p class="form_input_social_label"><span class="skype"><i class="fa-brands fa-skype"></i></span>
						<input name="skype" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('SKYPE');?>" value="<?=$user->social->skype?>"></p>
					</div>
					<div class="form_input_social">
						<p class="form_input_social_label"><span class="viber"><i class="fa-brands fa-viber"></i></span>
						<input name="viber" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('VIBER');?>" value="<?=$user->social->viber?>"></p>
					</div>
					<div class="form_input_social">
						<p class="form_input_social_label"><span class="windows"><i class="fa-brands fa-windows"></i></span>
						<input name="teams_ms" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('TEAMS_MS');?>" value="<?=$user->social->teams_ms?>"></p>
					</div>
					<div class="form_input_social">
						<p class="form_input_social_label"><span class="twich"><i class="fa-brands fa-twitch"></i></span>
						<input name="twitch" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('TWITCH');?>" value="<?=$user->social->twitch?>"></p>
					</div>
					<br>
					<button type="submit" class="belcms_btn"><?=constant('CONFIRM');?></button>
				</form>
			</div>
		</div>
	</div>
<?php
endif;