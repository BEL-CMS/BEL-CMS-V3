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
?>
<section class="section_bg" id="bel_cms_team">
	<?php
	foreach ($data as $k => $v):
	?>
	<div class="card mb-4">
		<?php
		if (!empty($v->img)):
		?>
			<img src="<?=$v->img?>" class="card-img-top" alt="<?=$v->name?>">
		<?php
		endif;
		?>
		<div class="card-body">
			<h5 class="card-title"><?=$v->name?></h5>
			<p class="card-text"><?=$v->description?></p>
		</div>
		<div class="card-footer">
			<ul>
				<?php
				foreach ($v->user as $key => $value):
				?>
				<li>
					<a class="simple-tooltip" title="<?=Users::hashkeyToUsernameAvatar($value->author)?>" href="Members/View/<?=Users::hashkeyToUsernameAvatar($value->author)?>">
						<img src="<?=Users::hashkeyToUsernameAvatar($value->author,'avatar')?>">
					</a>
				</li>
				<?php
				endforeach;
				?>
			</ul>
		</div>
	</div>
	<?php
	endforeach;
	?>
</section>