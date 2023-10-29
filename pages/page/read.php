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
if (empty($data)):
	Notification::warning('Erreur dans la page, imposssible de l\'afficher');
else:
?>
<div id="belcms_subpage" class="card">
	<div class="card-header"><?=$data->name?></div>
	<div class="card-body">
		<?=$data->content?>
	</div>
	<div class="card-footer text-muted">
		<?=$data->publish?>
	</div>
</div>
<?php
endif;
