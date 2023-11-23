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

use BelCMS\Requires\Common;
use BELCMS\User\User;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
if (User::isLogged() === true):
	$user = isset($_GET['user']) ? $_GET['user'] : null;
?>
	<section id="belcms_section">
		<form action="Mails/sendNew" method="post" enctype="multipart/form-data">
			<div id="belcms_mails_new">
				<div>
					<div class="belcms_grid_3">
						<label><?=constant('RECIPIENT');?></label>
					</div>
					<div class="belcms_grid_9">
						<input id="belcms_mails_new_author" autocomplete="off" type="search" name="author" required value="<?=$user;?>">
					</div>
				</div>
				<div>
					<div class="belcms_grid_3">
						<label><?=constant('MESSAGE_SUBJECT');?></label>
					</div>
					<div class="belcms_grid_9">
						<input name="subject" type="text" required>
					</div>
				</div>
				<div>
					<div class="belcms_grid_3">
						<label><?=constant('MESSAGE');?></label>
					</div>
					<div class="belcms_grid_9">
						<textarea class="bel_cms_textarea_simple" name="message"></textarea>
					</div>
				</div>
				<div>
					<div class="belcms_grid_3">
						<label><?=constant('UPLOAD');?> (<?=Common::ConvertSize(Common::GetMaximumFileUploadSize())?> max)</label>
					</div>
					<div class="belcms_grid_9">
						<input type="file" name="upload">
					</div>
				</div>
				<div>
					<div class="belcms_grid_3">&nbsp;</div>
					<div id="belcms_mails_new_submit" class="belcms_grid_9">
						<input type="submit" class="belcms_btn belcms_bg_grey " value="<?=constant('SUBMIT');?>">
					</div>
				</div>
			</div>
		</form>
	</section>
<?php
endif;
?>