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

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
$answer = count($var->answer);
foreach ($var->answer as $key => $value) {
	$countTotal =+ $value->nb_vote;
}
?>
<div id="belcms_widgets_survey">
	<div id="belcms_widgets_quest">
		<div id="belcms_widgets_text"><?=$var->question;?></div>
		<div id="belcms_widgets_nb_vote"><?=$var->vote;?></div>
	</div>
	<ul id="belcms_widgets_survey_list_vote">
		<?php
		foreach ($var->answer as $key => $value):
			$nb_vote = $value->nb_vote == '0' ? 0 : $value->nb_vote;
			$prc     = ($nb_vote / $countTotal) * 100;
			$line    = $nb_vote == 0 ? '' : 'class="belcms_reply_line" style="width:'.$prc.'%;"' ;

		?>
		<li>
			<div class="belcms_reply belcms_tooltip_bottom jquery_vote" data="Cliqué pour Voté" data-id="<?=$value->id_question;?>">
				<div class="belcms_reply_answer"><?=$value->answer;?></div>
				<div <?=$line;?> ></div>
				<div class="belcms_reply_text"><?=$prc;?>%</div>
			</div>
		</li>
		<?php
		endforeach;
		?>
	</ul>
	<?php
	if ($var->answer_nb > $answer):
	?>
	<form action="" method="post" id="belcms_widgets_survey_form">
		<input type="text" name="text" value="" required placeholder="Nouvelle réponse">
		<button type="submit" form="belcms_widgets_survey_form" value="Submit"><i class="fa-solid fa-square-check fa-xl"></i></button> 
	</form>
	<?php
	endif;
	?>
</div>