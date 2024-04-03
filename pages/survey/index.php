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
$i = 0;
$form = true;
debug($data);

$answer = count($data->answer);
?>
<section id="bel_cms_survey">
	<h2><?=$data->question;?></h2>
	<ul>
		<?php
		foreach ($data->quest as $value):
			$i = $i +1;
			$userVote = $value->count_vote == '0' ? 0 : $value->count_vote;
			if ($data->vote != 0) {
				$prc = ($userVote / $data->vote) * 100;
			} else {
				$prc = 0;
			}
		?>
		<li>
			<span class="bel_cms_survey_count"><?=$i;?></span>
			<span class="bel_cms_survey_answer"><?=$value->answer;?></span>
			<span class="bel_cms_survey_progress_bar"><span class="bel_cms_survey_progress_bar_width" style="width:<?=$prc;?>%;"></span></span>
			<span class="bel_cms_survey_progress_bar_pourcent"><?=$prc;?>%</span>
		</li>
		<?php
		endforeach;
		?>
	</ul>
	<?php
	if ($var->answer_nb > $answer and $form === true):
	?>
	<form id="belcms_widgets_survey_form">
		<input type="hidden" name="id" value="<?=$var->id;?>" id="belcms_widgets_survey_form_id">
		<input type="text" name="text" value="" required placeholder="Nouvelle réponse" id="belcms_widgets_survey_form_name">
		<button type="submit" form="belcms_widgets_survey_form" value="Submit"><i class="fa-solid fa-square-check fa-xl"></i></button> 
	</form>
	<?php
	endif;
	?>
</section>
<?=$pagination;?>
