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
<form action="/styles/sendWidget?management&option=templates" method="post">
	<div class="card">
		<div class="card-header">
			Styles
		</div>
		<div class="card-body">
			<div class="form-group">
				<label class="col-sm-12 control-label" for="checkbox"><?=TEXT?></label>
					<textarea rows="15" cols="35" name="content" style="width: 100%;">
						<?php
						echo $data;
						?>
					</textarea>
				</div>
			</div>
		</div>
		<div class="card-footer">
			<input type="hidden" name="widget" value="<?=$widget;?>">
			<button type="submit" class="btn btn-primary"><?=SUBMIT?></button>
		</div>
	</div>
</form>