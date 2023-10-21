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

$screen = !is_file($data->screen)   ? 'pages/downloads/no_image.png' : $data->screen;
$md5    = is_file($data->download) ? md5_file(($data->download)) : null;
$mime   = is_file($data->download) ? mime_content_type(($data->download)) : null;
$size   = is_file($data->download) ? Common::ConvertSize(filesize($data->download)) : null;
?>
<div id="belcms_section_downloads_main">
	<span class="bel-cms-pages_title"><?=$data->name?></span>
	<div id="belcms_section_downloads_detail">
		<div id="belcms_section_downloads_detail_left">
			<img src="<?=$screen;?>">
		</div>
		<div id="belcms_section_downloads_detail_right">
			<?=$data->description?>
		</div>
	</div>
	<span class="bel-cms-pages_title">Informations</span>
	<div id="belcms_section_downloads_detail_infos">
		<ul>
			<li><span>hash MD5 : </span><i><?=$md5?></i></li>
			<li><span><?=SIZE?> : </span><i><?=Common::ConvertSize($data->size)?></i></li>
			<li><span>Compteur DL : </span><i><?=$data->dls?></i></li>
			<li><span>Compteur vu : </span><i><?=(int)$data->view?></i></li>
			<li><span>Type mime : </span><i><?=$mime?></i></li>
			<li><span>Date upload : </span><i><?=Common::TransformDate($data->date, 'FULL', 'SHORT')?></i></li>
			<li><span>Uploader : </span><i><?=Users::hashkeyToUsernameAvatar($data->uploader)?></i></li>
			<li><a class="belcms_btn belcms_bg_blue" href="Downloads/getDl/<?=$data->id?>">Télécharger</a></li>
		</ul>
	</div>
</div>