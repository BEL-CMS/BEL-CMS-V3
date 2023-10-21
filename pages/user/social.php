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
if (Users::isLogged() === true):
	require_once 'nav.php';
?>
	<div id="belcms_section_user_safety">
		<div id="belcms_section_user_safety_card">
			<div class="belcms_card">
				<div class="belcms_title">Liens Social</div>
				<form action="user/submitsocial" method="post" class="belcms_section_user_main_form">
					<div>
						<h3 class="belcms_h3_input_lf">(Meta) Facebook :</h3>
						<input class="bel_cms_input" name="facebook" type="text" placeholder="<?=constant('ENTER_YOUR');?> facebook" value="<?=$user->facebook?>" pattern="^[a-z\d\.]{5,}$">
					</div>

					<div>
						<h3 class="belcms_h3_input_lf">X (Twitter) :</h3>
						<input class="bel_cms_input" name="twitter" type="text" placeholder="<?=constant('ENTER_YOUR');?> twitter" value="<?=$user->twitter?>" pattern="^[A-Za-z0-9_]{1,15}$">
					</div>

					<div>
						<h3 class="belcms_h3_input_lf">Discord :</h3>
						<input class="bel_cms_input" name="discord" type="text" placeholder="<?=constant('ENTER_YOUR');?> Discord" value="<?=$user->discord?>">
					</div>

					<div>
						<h3 class="belcms_h3_input_lf">Pinterest :</h3>
						<input class="bel_cms_input" name="pinterest" type="text" placeholder="<?=constant('ENTER_YOUR');?> pinterest" value="<?=$user->pinterest?>">
					</div>

					<div>
						<h3 class="belcms_h3_input_lf">Linkedin :</h3>
						<input class="bel_cms_input" name="linkedin" type="text" placeholder="<?=constant('ENTER_YOUR');?> linkedin" value="<?=$user->linkedin?>">
					</div>
					<button type="submit" class="belcms_btn"><?=CONFIRM?></button>
				</form>
			</div>
		</div>
	</div>
<?php
endif;