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
<section id="section_downloads">
	<ul id="section_download_jquery">
		<?php
		foreach ($data as $value):
		?>
		<li>
			<div class="section_downloads_cat">
				<?php
				if (!empty($value->banner)):
				?>
				<div><img src="<?=$value->banner;?>"></div>
				<?php
				endif;
				?>
				<h1><?=$value->name;?></h1>
				<div class="section_downloads_cat_desc">
					<?=$value->description;?>
				</div>
				<div class="section_downloads_cat_infos">
					<ul>
						<li><a class="section_downloads_cat_button" href="downloads/category/<?=$value->id;?>">Entrer dans cette catégorie</a></li>
					</ul>
				</div>
			</div>
		</li>
		<?php
		endforeach;
		?>
	</ul>
</section>