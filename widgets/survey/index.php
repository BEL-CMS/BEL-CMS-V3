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
if ($var !== false):
?>
<div id="belcms_widgets_survey">
	<div id="belcms_widgets_quest">
		<div id="belcms_widgets_text"><?=$var->question;?></div>
		<div id="belcms_widgets_nb_vote"><?=$var->vote;?></div>
	</div>
	<ul id="belcms_widgets_survey_list_vote">
		<?php
		foreach ($var->answer as $key => $value):
			$userVote = $value->count_vote == '0' ? 0 : $value->count_vote;
			if ($var->vote != 0) {
				$prc = ($userVote / $var->vote) * 100;
			} else {
				$prc = 0;
			}
			$line    = $userVote == 0 ? '' : 'class="belcms_reply_line" style="width:'.$prc.'%;"' ;
			$voting  = $value->userVote === true ? '<div class="belcms_reply belcms_tooltip_bottom jquery_vote" data="Cliqué pour Voté" data-id="'.$value->id.'" data-answer="'.$value->id_question.'" data-quest="'.$value->id.'">' : '<div class="belcms_reply no_cursor">';
		?>
		<li>
			<?=$voting;?>
				<div class="belcms_reply_answer"><?=$value->answer;?></div>
				<div <?=$line;?> ></div>
				<div class="belcms_reply_text"><?=round($prc, 2);?>%</div>
			</div>
		</li>
		<?php
		endforeach;
		?>
	</ul>
	<?php
	$form = true;
	foreach ($var->answer as $value):
		if ($value->count_vote >= 1) {
			$form = false;
			break;
		}
	endforeach;
	if ($var->answer_nb > $answer and $form === true):
		$date = new \DateTimeImmutable($var->timestop);
		$expirationDate = $date->add(new \DateInterval($var->dateclose));
		$now_date = new \DateTime("now");
		$interval = $now_date->diff($expirationDate);
		if ($interval->invert == 0):
		?>
		<form id="belcms_widgets_survey_form">
			<input type="hidden" name="id" value="<?=$var->id;?>" id="belcms_widgets_survey_form_id">
			<input type="text" name="text" value="" required placeholder="Nouvelle réponse" id="belcms_widgets_survey_form_name">
			<button type="submit" form="belcms_widgets_survey_form" value="Submit"><i class="fa-solid fa-square-check fa-xl"></i></button> 
		</form>
		<?php
		endif;
	endif;
	?>
	<p id="belcms_reply_all"><a href="survey"><?=constant('VIEW_ALL_SURVEYS');?></a></p>
</div>
<?php
endif;
?>