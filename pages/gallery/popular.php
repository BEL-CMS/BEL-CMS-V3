<?php
use BelCMS\Core\Notification;
/**
 * Bel-CMS [Content management system]
 * @version 3.0.7 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
$countCat = count($data);
?>
<section id="section_gallery">
	<h2><?=constant('GALLERY');?></h2>
	<div id="section_opt">[ <a href="Gallery">Index</a> | <a href="Gallery/New">Nouveaux</a> | <a href="Gallery/Propose">Proposé</a> ]</div>
	<?php
	if ($countCat == 0):
		Notification::warning(constant('NO_IMAGES_IN_DATABASE'), constant('GALLERY'));
	else:
	?>
		<ul id="boutique">
			<?php
			foreach ($data as $v):
			?>
			<li>
				<a href="<?=$v->image;?>">
					<img src="<?=$v->image;?>" alt="<?=$v->name;?>" width="280" height="400">
					<span><?=$v->description;?></span>
				</a>
			</li>
			<?php
			endforeach;
			?>
		</ul>
	<?php
	endif;
	?>
</section>
</script>