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
if (!empty($data)):
?>
<div id="belcms_section_page_main">
	<div class="belcms_card">
		<div class="belcms_title">Page(s)</div>
	</div>
	<div class="belcms_section_page_detail_infos">
		<ul>
			<?php
			foreach ($data as $k => $v):
			?>
			<li><a href="page/read/<?=$v->id?>/<?=Common::MakeConstant($v->name)?>"><?=$v->name?></a><i><?=$v->publish?></i></a></li>
			<?php
			endforeach;
			?>
		</ul>
	</div>
</div>
<?php
endif;