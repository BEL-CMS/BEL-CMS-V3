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

use BelCMS\Core\Notification;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
if (!empty($data)):
?>
<div id="belcms_section_articles_main">
	<ul>
		<li class="articles_title">
			<div><?=constant('NAME');?></div>
			<div>Nombre d'article</div>
		</li>
		<?php
		foreach ($data as $k => $v):
		?>
		<li>
			<div>
				<a href="Articles/subpage/<?=$v->id?>/<?=Common::MakeConstant($v->name)?>">
					<?=$v->name?>
				</a>
			</div>
			<div>
				<?=$v->count?>
			</div>
		</li>
		<?php
		endforeach;
		if (!empty($sub)):
		foreach ($sub as $k => $v):
		?>
		<li>
			<div>
				<a href="Articles/intern/<?=$v?>">
					<?=$v?>
				</a>
			</div>
		</li>
		<?php
		endforeach;
		endif;
		?>
	</ul>
</div>
<?php
endif;
if (empty($data) and empty($sub)):
	Notification::warning('Aucune page de disponible', 'Articles');
endif;