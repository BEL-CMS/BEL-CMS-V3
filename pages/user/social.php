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

use BELCMS\User\User as UserInfos;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
if (UserInfos::isLogged() === true):
	require_once 'nav.php';
?>
	<div id="belcms_section_user_safety">
		<div id="belcms_section_user_safety_card">
			<div class="belcms_card">
				<form action="user/submitsocial" method="post" class="belcms_section_user_main_form">
					<div>
						<h3 class="belcms_h3_input_lf"><?=constant('FACEBOOK');?> :</h3>
						<input class="bel_cms_input" name="facebook" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('FACEBOOK');?>" value="<?=$user->social->facebook?>" pattern="^[a-z\d\.]{5,}$">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf"><?=constant('X_TWITTER');?> :</h3>
						<input class="bel_cms_input" name="x_twitter" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('X_TWITTER');?>" value="<?=$user->social->x_twitter?>" pattern="^[A-Za-z0-9_]{1,15}$">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf"><?=constant('DISCORD');?> :</h3>
						<input class="bel_cms_input" name="discord" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('DISCORD');?>" value="<?=$user->social->discord?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf"><?=constant('PINTEREST');?> :</h3>
						<input class="bel_cms_input" name="pinterest" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('PINTEREST');?>" value="<?=$user->social->pinterest?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf"><?=constant('LINKEDIN');?> :</h3>
						<input class="bel_cms_input" name="linkedIn" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('LINKEDIN');?>" value="<?=$user->social->linkedIn?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf"><?=constant('YOUTUBE');?> :</h3>
						<input class="bel_cms_input" name="youtube" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('YOUTUBE');?>" value="<?=$user->social->youtube?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf"><?=constant('WHATSAPP');?> :</h3>
						<input class="bel_cms_input" name="whatsapp" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('WHATSAPP');?>" value="<?=$user->social->whatsapp?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf"><?=constant('INSTAGRAM');?> :</h3>
						<input class="bel_cms_input" name="instagram" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('INSTAGRAM');?>" value="<?=$user->social->instagram?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf"><?=constant('MESSENGER');?> :</h3>
						<input class="bel_cms_input" name="messenger" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('MESSENGER');?>" value="<?=$user->social->messenger?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf"><?=constant('TIKTOK');?> :</h3>
						<input class="bel_cms_input" name="tiktok" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('TIKTOK');?>" value="<?=$user->social->tiktok?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf"><?=constant('SNAPCHAT');?> :</h3>
						<input class="bel_cms_input" name="snapchat" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('SNAPCHAT');?>" value="<?=$user->social->snapchat?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf"><?=constant('TELEGRAM');?> :</h3>
						<input class="bel_cms_input" name="telegram" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('TELEGRAM');?>" value="<?=$user->social->telegram?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf"><?=constant('PINTEREST');?> :</h3>
						<input class="bel_cms_input" name="pinterest" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('PINTEREST');?>" value="<?=$user->social->pinterest?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf"><?=constant('REDDIT');?> :</h3>
						<input class="bel_cms_input" name="reddit" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('REDDIT');?>" value="<?=$user->social->reddit?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf"><?=constant('SKYPE');?> :</h3>
						<input class="bel_cms_input" name="skype" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('SKYPE');?>" value="<?=$user->social->skype?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf"><?=constant('VIBER');?> :</h3>
						<input class="bel_cms_input" name="viber" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('VIBER');?>" value="<?=$user->social->viber?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf"><?=constant('TEAMS_MS');?> :</h3>
						<input class="bel_cms_input" name="teams_ms" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('TEAMS_MS');?>" value="<?=$user->social->teams_ms?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf"><?=constant('TWITCH');?> :</h3>
						<input class="bel_cms_input" name="twitch" type="text" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('TWITCH');?>" value="<?=$user->social->twitch?>">
					</div>
					<button type="submit" class="belcms_btn"><?=constant('CONFIRM');?></button>
				</form>
			</div>
		</div>
	</div>
<?php
endif;