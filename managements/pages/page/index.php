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
?>
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Télécharments</h3>
	</div>
	<div class="card-body">
		<?php
		foreach ($data as $key => $value):
		?>
		<tr>
			<a href="/page/getpage/<?=$value->id?>?management&pages" class="btn btn-app">
				<span class="badge bg-red"><?=$value->count?></span>
				<i class="fa far fa-file-alt"></i> <?=$value->name?>
			</a>
		<?php
		endforeach;
		?>
	</div>
</div>