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
use BelCMS\User\User as User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
if (!empty($data)) {
?>
<section id="bel_cms_widgets_survey" class="widget">
	<div id="bel_cms_widgets_survey_name"><?=$data->name?></div>
	<form action="Survey/send" method="post">
	<?php
	if ($count == true):
	foreach ($vote as $k => $v):
		?>
		<div class="input-group">
			<div class="input-group-prepend">
				<div class="input-group-text">
					<?php if(User::isLogged()): ?>
					<input type="radio" aria-label="Radio button for following text input" name="vote" id="<?=$v->id?>" value="<?=$v->number?>">
					<?php endif; ?>
				</div>
			</div>
			<input type="text" class="form-control" disabled="disabled" aria-label="Text input with radio button" value="<?=$v->content?>">
		</div>
		<?php
	endforeach;
	?>
	<br>
	<?php if(User::isLogged()): ?>
	<input type="hidden" name="id" value="<?=$data->id?>">
	<button class="btn btn-primary">Envoyer</button>
	<?php endif; ?>
	<?php
	else:
	?>
	<ul>
	<?php
	foreach ($vote as $k => $v):
		?>
		<li><?=$v->content?><span><?=$v->vote?></span></li>
		<?php
	endforeach;
	?>
	</ul>
	<?php
	endif;
	?>
	<a href="Survey"><?=constant('SEE_THE_LIST_OF_SURVEYS');?></a>
	</form>
</section>
<?php
} else {
	Notification::infos(constant('NO_SURVEY_IN_PROGRESS'), constant('SURVEY'));
	?>
	<a style="display: block;text-align: center;" href="Survey"><?=constant('SEE_THE_LIST_OF_SURVEYS');?></a>
	<?php
}
?>