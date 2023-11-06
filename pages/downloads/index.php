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

use BelCMS\User\User as User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<div id="belcms_section_downloads_main">
	<span class="bel-cms-pages_title"><?=constant('DOWNLOADS')?></span>
	<div id="belcms_section_downloads_cat">
		<ul id="belcms_section_downloads_nav">
			<?php
			foreach ($data as $b):
			?>
			<li><a href="downloads/category/<?=$b->id;?>"><?=$b->name;?></a></li>
			<?php
			endforeach;
			?>
		</ul>
	</div>
	<div id="belcms_section_downloads_links">
		<div id="belcms_section_downloads_nav_link">
		<ul id="belcms_section_downloads_nav_ul">
			<?php
			foreach ($data as $v) {
				foreach ($v->dl as $value):
					if (!is_file($value->screen)) {
						$value->screen = '/pages/downloads/no_image.png';
					}
					$infosUser = User::getInfosUserAll($value->uploader);
				?>
				<li class="belcms_section_downloads_nav_ul_li">
					<div class="belcms_section_downloads_nav_ul_left">
						<img src="<?=$value->screen;?>" title="logo_<?=$value->name;?>">
					</div>
					<div class="belcms_section_downloads_nav_ul_right">
						<a href="downloads/detail/<?=$value->id;?>"><?=$value->name;?></a>
						<span>Par : 
							<a href="Members/View/<?=$infosUser->user->username;?>">
								<i style="color: <?=$infosUser->user->color;?> "><?=$infosUser->user->username;?></i>
							</a>
						</span>
						<span>Cat : <i><?=$v->name;?></i></span>
					</div>
					<a class="belcms_section_downloads_nav_ul_right_dl belcms_btn belcms_bg_blue" href="downloads/detail/<?=$value->id;?>">Voir</a>
				</li>
				<?php
				endforeach;
			?>
			<?php
			}
			?>
		</ul>
	</div>
</div>