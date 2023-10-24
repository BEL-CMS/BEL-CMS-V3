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
				<div class="belcms_title">Liens Social</div>
				<form action="user/submitsocial" method="post" class="belcms_section_user_main_form">
					<div>
						<h3 class="belcms_h3_input_lf">(Meta) Facebook :</h3>
						<input class="bel_cms_input" name="facebook" type="text" placeholder="<?=constant('ENTER_YOUR');?> facebook" value="<?=$user->social->facebook?>" pattern="^[a-z\d\.]{5,}$">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf">X (Twitter) :</h3>
						<input class="bel_cms_input" name="x_twitter" type="text" placeholder="<?=constant('ENTER_YOUR');?> twitter" value="<?=$user->social->x_twitter?>" pattern="^[A-Za-z0-9_]{1,15}$">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf">Discord :</h3>
						<input class="bel_cms_input" name="discord" type="text" placeholder="<?=constant('ENTER_YOUR');?> Discord" value="<?=$user->social->discord?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf">Pinterest :</h3>
						<input class="bel_cms_input" name="pinterest" type="text" placeholder="<?=constant('ENTER_YOUR');?> pinterest" value="<?=$user->social->pinterest?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf">LinkedIn :</h3>
						<input class="bel_cms_input" name="linkedIn" type="text" placeholder="<?=constant('ENTER_YOUR');?> linkedIn" value="<?=$user->social->linkedIn?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf">Youtube :</h3>
						<input class="bel_cms_input" name="youtube" type="text" placeholder="<?=constant('ENTER_YOUR');?> youtube" value="<?=$user->social->youtube?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf">Whatsapp :</h3>
						<input class="bel_cms_input" name="whatsapp" type="text" placeholder="<?=constant('ENTER_YOUR');?> whatsapp" value="<?=$user->social->whatsapp?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf">Instagram :</h3>
						<input class="bel_cms_input" name="instagram" type="text" placeholder="<?=constant('ENTER_YOUR');?> instagram" value="<?=$user->social->instagram?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf">Messenger :</h3>
						<input class="bel_cms_input" name="messenger" type="text" placeholder="<?=constant('ENTER_YOUR');?> messenger" value="<?=$user->social->messenger?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf">TikTok :</h3>
						<input class="bel_cms_input" name="tiktok" type="text" placeholder="<?=constant('ENTER_YOUR');?> tiktok" value="<?=$user->social->tiktok?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf">SnapChat :</h3>
						<input class="bel_cms_input" name="snapchat" type="text" placeholder="<?=constant('ENTER_YOUR');?> snapchat" value="<?=$user->social->snapchat?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf">Telegram :</h3>
						<input class="bel_cms_input" name="telegram" type="text" placeholder="<?=constant('ENTER_YOUR');?> telegram" value="<?=$user->social->telegram?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf">Pinterest :</h3>
						<input class="bel_cms_input" name="pinterest" type="text" placeholder="<?=constant('ENTER_YOUR');?> Pinterest" value="<?=$user->social->pinterest?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf">Reddit :</h3>
						<input class="bel_cms_input" name="reddit" type="text" placeholder="<?=constant('ENTER_YOUR');?> reddit" value="<?=$user->social->reddit?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf">Skype :</h3>
						<input class="bel_cms_input" name="skype" type="text" placeholder="<?=constant('ENTER_YOUR');?> skype" value="<?=$user->social->skype?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf">Viber :</h3>
						<input class="bel_cms_input" name="viber" type="text" placeholder="<?=constant('ENTER_YOUR');?> viber" value="<?=$user->social->viber?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf">Team Microsoft :</h3>
						<input class="bel_cms_input" name="teams_ms" type="text" placeholder="<?=constant('ENTER_YOUR');?> Team Microsoft" value="<?=$user->social->teams_ms?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf">Twitch :</h3>
						<input class="bel_cms_input" name="twitch" type="text" placeholder="<?=constant('ENTER_YOUR');?> Twitch" value="<?=$user->social->twitch?>">
					</div>
					<button type="submit" class="belcms_btn"><?=constant('CONFIRM');?></button>
				</form>
			</div>
		</div>
	</div>
<?php
endif;