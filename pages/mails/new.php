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
	$user = isset($_GET['user']) ? $_GET['user'] : null;
?>
	<section id="belcms_section">
		<form action="Mails/SendNew" method="post" enctype="multipart/form-data">
			<div id="belcms_mails_new">
				<div>
					<div class="belcms_grid_3">
						<label><?=constant('RECIPIENT');?></label>
					</div>
					<div class="belcms_grid_9">
						<input name="author" type="text" required value="<?=$user;?>">
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
						<textarea class="bel_cms_textarea_simple" name="content"></textarea>
					</div>
				</div>
			</div>
		</form>
	</section>
<?php
endif;
?>