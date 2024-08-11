<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.9 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Core\Notification;
use BelCMS\Requires\Common;
use BELCMS\User\User;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
if (User::isLogged() === true):
	$user = isset($_GET['user']) ? $_GET['user'] : null;
?>
<section id="belcms_section_mails">
	<div id="belcms_section_mails_list">
		<?php include 'menu.php'; ?>
	</div>
	<form id="belcms_section_new_mails" action="Mails/sendNew" method="post" enctype="multipart/form-data">
		<div>
			<label><?=constant('RECIPIENT');?></label>
			<input id="belcms_mails_new_author" autocomplete="off" type="search" name="author" required value="<?=$user;?>">
		</div>
		<div>
			<label><?=constant('MESSAGE_SUBJECT');?></label>
			<input name="subject" type="text" required>
		</div>
		<div>
			<label><?=constant('MESSAGE');?></label>
			<textarea class="bel_cms_textarea_simple" name="message"></textarea>
		</div>
		<div>
			<label><?=constant('UPLOAD');?> (<?=Common::ConvertSize(Common::GetMaximumFileUploadSize())?> max)</label>
			<input id="uploads_new" type="file" name="upload">
		</div>
		<div>
			<input type="submit" class="belcms_btn belcms_bg_grey " value="<?=constant('SUBMIT');?>">
		</div>
	</form>
</section>
<?php
endif;