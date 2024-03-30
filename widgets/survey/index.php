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
?>
<div id="belcms_widgets_survey">
	<div id="belcms_widgets_quest">
		<div id="belcms_widgets_text">Un système de gestion de contenu, souvent abrégé en CMS</div>
		<div id="belcms_widgets_nb_vote">26</div>
	</div>
	<ul id="belcms_widgets_survey_list_vote">
		<li>
			<div class="belcms_reply belcms_tooltip_bottom" data="Cliqué pour Voté">
				<div class="belcms_reply_line" style="right: calc(100% - 26%);">jhghjg</div>
				<div class="belcms_reply_text">26%</div>
			</div>
		</li>
		<li>
			<div class="belcms_reply belcms_tooltip_bottom" data="Cliqué pour Voté">
				<div class="belcms_reply_line" style="right: calc(100% - 54%);"></div>
				<div class="belcms_reply_text">54%</div>
			</div>
		</li>
		<li>
			<div class="belcms_reply belcms_tooltip_bottom" data="Cliqué pour Voté">
				<div class="belcms_reply_line" style="right: calc(100% - 26%);"></div>
				<div class="belcms_reply_text">26%</div>
			</div>
		</li>
		<li>
			<div class="belcms_reply belcms_tooltip_bottom" data="Cliqué pour Voté">
				<div class="belcms_reply_line" style="right: calc(100% - 30%);"></div>
				<div class="belcms_reply_text">30%</div>
			</div>
		</li>
	</ul>
	<form action="" method="post" id="belcms_widgets_survey_form">
		<input type="text" name="text" value="" required placeholder="Nouvelle réponse">
		<button type="submit" form="belcms_widgets_survey_form" value="Submit"><i class="fa-solid fa-square-check fa-xl"></i></button> 
	</form>
</div>