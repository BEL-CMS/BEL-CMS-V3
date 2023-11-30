<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
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
<section id="belcms_section_games">
	<?php
	foreach ($data as $value):
		if (isset($value->banner) and is_file($value->banner)) {
			$banner = $value->banner;
		} else {
			$banner = '/assets/img/no_img_available_728.90.png';
		}
		$gamers = $value->count > 0 ? constant('GAMERS') : constant('GAMER')
	?>
	<div class="belcms_section_games_row">
		<div class="belcms_section_games_img">
			<img class="belcms_section_games_img" src="<?=$banner;?>" alt="Banner_<?=$value->name;?>">
		</div>
		<h2><a href="" data-tooltip="Information <?=$value->name;?>" data-position="top"><?=$value->name;?></h2>
		<div class="belcms_section_games_infos">
			<ul>
				<li>
					<i class="fa-solid fa-gamepad fa-beat-fade"></i> <?=$value->name;?>
				</li>
				<li>
					<i class="fa-solid fa-users-viewfinder fa-fade"></i> <?=$value->count;?> <?=$gamers;?>
				</li>
			</ul>
		</div>
	</div>
	<?php
	endforeach;
	?>
</section>