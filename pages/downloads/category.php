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

use BelCMS\Core\Notification as Notification;
use BelCMS\Requires\Common as Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
if (empty($data)) {
	Notification::alert(constant('NO_DL_CAT'),constant('DOWNLOAD'));
}
?>
<div id="belcms_section_downloads_main">
	<div class="belcms_section_downloads_main_row"> 
		<ul>
			<?php
			foreach ($data as $value):
			?>
			<li>
				<div class="belcms_downloads_avatar">
					<img src="<?=$value->screen;?>" alt="avatar_<?=$value->name;?>">
				</div>
				<div class="belcms_downloads_infos">
					<ul>
						<li class="belcms_downloads_infos_title"><?=$value->name;?><span>
							<i class="fa-solid fa-eye"></i>&ensp;<?=$value->view;?>&ensp;|&ensp;<i class="fa-solid fa-floppy-disk"></i>&ensp;<?=$value->dls;?></li>
						<li>
						<?=$value->description;?>
						</li>
					</ul>
				</div>
				<div class="clear"></div>
				<div class="belcms_downloads_footer">
					<i class="fa fa-bars"></i>&ensp;<span><?=constant('DATE');?></span> : <?=Common::TransformDate($value->date, 'FULL', 'MEDIUM');?>
					<a href="downloads/detail/<?=$value->id;?>/<?=Common::MakeConstant($value->name);?>">Voir</a>
				</div>
			</li>
			<?php
			endforeach;
			?>
		</ul>
	</div>
</div>


