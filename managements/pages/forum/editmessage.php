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
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12">
        <div class="block">
            <div class="block-title">
                <h2>Edition du message</h2>
            </div>
			<form action="/Forum/sendeditMessage?management&page=true" method="post" class="form-horizontal form-bordered">
				<div class="form-group">
					<label class="col-sm-3 control-label" for="checkbox">Contenue</label>
					<div class="col-sm-9">
						<textarea class="bel_cms_textarea_simple" name="info_text"><?=$data->content;?></textarea>
					</div>
				</div>
				<div class="form-group">
					<input type="hidden" name="id" value="<?=$data->id;?>">
					<input type="submit" value="Editer ce post" class="btn btn-primary btn-rounded btn-lg btn-shadow pull-right">
				</div>
			</form>
		</div>
	</div>
</div>