<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Requires\Common as Common;
use BelCMS\User\User;
use BelCMS\Core\Comment;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

$author = User::getInfosUserAll($data->uploader);
if ($author === false) {
	$author = constant('MEMBER_DELETE');
} else {
	$author = $author->user->username;
}
$screen = !is_file($data->screen)   ? 'pages/downloads/no_image.png' : $data->screen;
$md5    = is_file($data->download) ? md5_file($data->download) : null;
$mime   = is_file($data->download) ? mime_content_type($data->download) : null;
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
			<li><span><?=constant('HASH_MD5');?> : </span><i><?=$md5?></i></li>
			<li><span><?=Constant('SIZE')?> : </span><i><?=Common::ConvertSize($data->size)?></i></li>
			<li><span><?=constant('DOWNLOAD_COUNTER');?> : </span><i><?=$data->dls?></i></li>
			<li><span><?=constant('COUNTER_SEEN');?> : </span><i><?=(int)$data->view?></i></li>
			<li><span><?=constant('MIME_TYPE');?> : </span><i><?=$mime?></i></li>
			<li><span><?=constant('RELEASE_DATE');?> : </span><i><?=Common::TransformDate($data->date, 'FULL', 'SHORT')?></i></li>
			<li><span><?=constant('UPLOADER');?> : </span><i><?=$author;?></i></li>
			<li><a class="belcms_btn belcms_bg_blue" href="Downloads/getDl/<?=$data->id?>">Télécharger</a></li>
		</ul>
	</div>
</div>
<?php
$comments = new Comment;
$comments->html();
?>