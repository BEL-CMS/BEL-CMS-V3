<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2023 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
$user = User::isLogged() ? $_SESSION['USER']->user->username : '';
$readonly = User::isLogged() ? 'readonly' : '';
 ?>
<section id="section_guestbook">
	<h2><?=constant('GUEST_BOOK_NEW');?></h2>
	<form id="form_guestbook" action="guestbook/SendNew" method="post">
		<div>
			<label for="author"><?=constant('ENTER_YOUR_NAME');?></label>
			<input <?=$readonly;?> type="text" value=<?=$user;?> name="author" id="author" required>
		</div>
		<div>
			<textarea required name="message"></textarea>
		</div>
		<div>
			<input required name="query_guestbook" type="number" min="1" max="18" class="form-control" autocomplete="off" placeholder="Captcha resolvé le petit calcul : <?=$_SESSION['TMP_QUERY_GUESTBOOK']['NUMBER_1']?> + <?=$_SESSION['TMP_QUERY_GUESTBOOK']['NUMBER_2']?>">
			<input type="hidden" value="" name="captcha">
		</div>
		<div class="donation_purchase_row">
            <input id="btn_submit" type="submit" value="<?=constant('SUBMIT');?>">
        </div>
	</form>
</section>