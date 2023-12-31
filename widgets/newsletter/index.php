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
<div class="card-body">
	<div class="widget-newsletter">
		<div><span class="m-text">Abonnez-vous à la newsletter.</span></div>
		<form action="Newsletter/send" method="post">
			<input type="text" class="fullwidth" name="email" placeholder="Votre email...">
			<button style="width: 100%;" class="mt-1">Envoyer votre email</button>
			<div class="hint"><strong><?=$count?></strong> abonnés déjà</div>
		</form>
	</div>
</div>