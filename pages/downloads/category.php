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

use BelCMS\Core\Notification as Notification;
use BelCMS\Requires\Common as Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

?>
<div id="belcms_section_downloads_main">
	<span class="bel-cms-pages_title"><?=constant('DOWNLOADS');?> - <?=$name?></span>
	<div id="belcms_section_downloads_category">
		<?php
		if (count($data) != 0) {
		?>
		<ul id="belcms_section_downloads_nav_ul">
			<?php
			foreach ($data as $a => $b):
				if (empty($b->screen) or !is_file($b->screen)):
					$b->screen = '/pages/downloads/no_image.png';
				endif;
				?>
				<li class="belcms_section_downloads_nav_ul_li">
					<div class="belcms_section_downloads_nav_ul_left">
						<img src="<?=$b->screen;?>" title="logo_<?=$b->name;?>">
					</div>
					<div class="belcms_section_downloads_nav_ul_right">
						<a href="downloads/detail/<?=$b->id?>/<?=$b->name?>"><?=$b->name;?></a>
				
						<span>Taille : <?=Common::ConvertSize($b->size)?></span>
						<span class="belcms_section_downloads_desc"><?=$b->description?></span>
						<a class="belcms_section_downloads_nav_ul_right_dl belcms_btn belcms_bg_blue" href="downloads/detail/<?=$b->id;?>/<?=Common::MakeConstant($b->name)?>">Voir</a>
					</div>
				</li>
			<?php
			endforeach;
		?>
		</ul>
		<?php
		echo $pagination;
		} else {
			Notification::infos('Aucun téléchargement dans la catégorie.');
		}
		?>
	</div>
</div>
