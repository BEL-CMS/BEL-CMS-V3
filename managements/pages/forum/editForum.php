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
<form action="/Forum/send?management&page=true" method="post" class="form-horizontal">
<div class="x_panel">
	<div class="x_title">
		<h2>Menu Page Forum</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<a href="/Forum?management&page=true" class="btn btn-app">
			<i class="fa fas fa-home"></i> Accueil
		</a>
		<a href="Forum/parameter?management&page=true" class="btn btn-app">
			<i class="fa fas fa-cogs"></i> Configuration
		</a>
		<a href="/Forum/category?management&page=true" class="btn btn-app">
			<i class="fa far fa-plus-square"></i> <?=CATEGORY?>
		</a>
		<button type="submit" class="btn btn-app">
			<i class="fa fas fa-save"></i> <?=SAVE?>
		</button>
	</div>
</div>

<div class="col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading clearfix">
			<h4 class="panel-title"><?=FORUM?></h4>
		</div>
		<div class="panel-body basic-form-panel">
				<div class="form-group">
					<label for="label_title" class="col-sm-2 control-label"><?=TITLE?></label>
					<div class="col-sm-10">
						<input value="<?=$thread->title?>" name="title" class="form-control" id="label_title" type="text" required="required" placeholder="Titre du forum">
					</div>
				</div>

				<div class="form-group">
					<label for="label_subtitle" class="col-sm-2 control-label"><?=SUBTITLE?></label>
					<div class="col-sm-10">
						<input value="<?=$thread->subtitle?>" name="subtitle" class="form-control" id="label_subtitle" type="text" required="required" placeholder="Sous-titre du forum">
					</div>
				</div>

				<div class="form-group">
					<label for="label_orderby" class="col-sm-2 control-label"><?=ORDER?></label>
					<div class="col-sm-10">
						<input value="<?=$thread->orderby?>" name="orderby" class="form-control" id="label_orderby" type="number" required="required" placeholder="1" min="1">
					</div>
				</div>

				<div class="form-group">
					<label for="label_icon" class="col-sm-2 control-label"><?=VIEW?> (<a target="_blank" href="https://fontawesome.com/icons?d=gallery&m=free"><?=ICON?></a>)</label>
					<div class="col-sm-10">
						<input value="<?=$thread->icon?>" name="icon" class="form-control" id="label_icon" type="text" placeholder="fa fa-code">
					</div>
				</div>

				<div class="form-group">
					<label for="label_orderby" class="col-sm-2 control-label"><?=CATEGORY?></label>
					<div class="col-sm-10">
						<select required="required" name="id_forum" class="form-control">
							<?php
							foreach ($data as $v):
								if (isset($thread->id_forum->title)) {
									if ($v->title == $thread->id_forum->title) {
										$select = 'selected="selected"';
									} else {
										$select = null;
									}
								} else {
									$select = null;
								}
								echo '<option '.$select.' value="'.$v->id.'">'.$v->title.'</option>';
							endforeach;
							?>
						</select>
					</div>
				</div>

				<div class="form-actions">
					<input type="hidden" name="id" value="<?=$thread->id?>">
					<input type="hidden" name="send" value="editforum">
				</div>
		</div>
	</div>
</div>
</form>