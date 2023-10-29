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
<div id="bel_cms_inbox_show" class="section_bg card">
	<div class="card-header"><?=INBOX?></div>
	<div class="card-body">
		<header>
			<ul>
				<li>De : <?=$inbox[0]->origin->username?></li>
				<li>A : <?=$inbox[0]->to?></li>
				<li>Date : <?=$inbox[0]->date_msg?></li>
			</ul>
		</header>
		<?php
		foreach ($inbox as $k => $v):
			$class = $v->username == $_SESSION['USER']['HASH_KEY'] ? 'bel_cms_inbox_show_msg' : 'bel_cms_inbox_show_msg_other';
		?>
		<div class="<?=$class?>">
			<span class="bel_cms_inbox_show_msg_date"><?=$v->date_msg?></span>
			<div class="bel_cms_inbox_show_msg_current">
				<?=$v->message?>
			</div>
		</div>
		<?php
		endforeach;
		?>
	</div>
	<div class="card-footer">
		<form method="post" id="bel_cms_inbox_form_new" action="inbox/send">
			<div id="bel_cms_inbox_form_new_body">
				<div class="form-group">
					<textarea class="bel_cms_textarea_inbox" name="message" placeholder="<?=ENTER_MESSAGE?>"></textarea>
				</div>
				<div class="form-group">
					<input type="hidden" name="id" value="<?=$inbox[0]->id_msg?>">
					<input type="hidden" name="send" value="reponse">
					<button type="submit" class="btn btn-primary"><?=REPLY?></button>
				</div>
			</div>
		</form>
	</div>
</div>
