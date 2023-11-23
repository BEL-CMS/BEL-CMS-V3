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

use BELCMS\User\User;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
if (User::isLogged() === true):
?>
	<section id="belcms_section">
		<form action="Mails/sendReply" method="post" enctype="multipart/form-data">
			<div id="belcms_mails_new">
				<div>
					<div class="belcms_grid_12">
						<textarea class="bel_cms_textarea_simple" name="message"></textarea>
					</div>
				</div>
				<div>
					<div id="belcms_mails_new_submit">
						<input type="hidden" value="<?=$mail_id;?>" name="mail_id">
						<input type="submit" class="belcms_btn belcms_bg_grey " value="<?=constant('SUBMIT');?>">
					</div>
				</div>
			</div>
		</form>
	</section>
<?php
endif;
?>