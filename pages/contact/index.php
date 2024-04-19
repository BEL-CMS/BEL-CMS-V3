<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.1 [PHP8.3]
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
<div id="belcms_contact">
	<h3>Contactez-nous</h3>
	<form id="belcms_contact_form" action="Contact/send" method="post">
		<div class="belcms_contact_form_br">
			<input maxlength="64" type="text" placeholder="Entrer votre nom" name="name" required>
			<input maxlength="64" type="email" placeholder="Entrer votre email" name="mail" required>
		</div>
		<div class="belcms_contact_form_br">
			<input type="text" placeholder="Entrer le sujet" name="subject" required>
			<input maxlength="13" type="tel" placeholder="Entrer votre n°de tel" name="tel">
		</div>
		<div class="belcms_contact_form_br">
			<textarea name="message" class="bel_cms_textarea_simple" placeholder="Votre message"></textarea>
		</div>
			<input id="captcha" required name="query_contact" type="number" min="1" max="18" autocomplete="off" placeholder="Captcha : resolvé le petit calcul : <?=$captcha['NB_ONE'];?> + <?=$captcha['NB_TWO'];?>">
			<input type="hidden" value="" name="captcha">
		<div class="belcms_contact_form_br">
			<button type="submit" class="belcms_bg_grey">Envoyer</button>
		</div>
	</form>
</div>