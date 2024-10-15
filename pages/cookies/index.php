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


if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<div id="belcms_cookies">
	<?php
	foreach ($options as $v):
	?>
		<div class="belcms_cookies_row">
			<h3><?=$v->title_cookies;?></h3>
			<?=$v->action;?>
		</div>
	<?php
	endforeach;
	?>
	<div id="belcms_cookies_valid">
		<form action="cookies/accept" method="post">
			<input type="submit" value="J'accepte">
		</form>
	</div>
</div>
