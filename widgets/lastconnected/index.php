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
if ($last !== null):
?>
<div id="bel_cms_widgets_lastconnected" class="widget">
	<ul>
	<?php
	foreach ($last as $k => $v):
		?>
		<li>
			<img data-toggle="tooltip" title="<?=$v->username?>" src="<?=$v->avatar?>" alt="avatar_<?=$v->username?>" style="max-width: 50px; max-height: 50px;">
			<span>
				<p style="color: <?=Users::colorUsername(null,$v->username)?>"><?=$v->username;?></p>
				<p><?=Common::transformDate($v->last_visit, 'MEDIUM', 'SHORT') ?></p>
			</span>
		</li>
	<?php
	endforeach;
	?>
	</ul>
</div>
<?php
endif;
