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
if (isset($_SESSION['LOGIN_MANAGEMENT']) && $_SESSION['LOGIN_MANAGEMENT'] === true):
$tags = null;
$c = count($data->tags);
foreach ($data->tags as $k => $v) {
	$v = str_replace(' ','',$v);
	if ($c != $k+1) {
		$tags.= $v. ', ';
	} else {
		$tags.= $v;
	}
}
?>
<div class="card">
	<div class="card-header">
		<h3 class="card-title"><?=EDITING;?> <?=ARTICLE?></h3>
		<div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
				<i class="fas fa-minus"></i>
			</button>
		</div>
	</div>
	<div class="card-body">
		<form action="/articles/sendedit?management&option=pages" method="post" class="form-horizontal form-bordered">
			<div class="form-group">
				<label class="col-sm-12 control-label" for="checkbox"><?=NAME?> :</label>
				<div class="col-sm-12">
					<input name="name" type="text" class="form-control" value="<?=$data->name?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-12 control-label" for="checkbox"><?=TAGS;?> :</label>
				<div class="col-sm-12">
					<input name="tags" placeholder="( séparer par des => , )" value="<?=$tags?>" type="text" value="" data-role="tagsinput" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-12 control-label" for="checkbox"><?=TEXT?> :</label>
				<div class="col-sm-12">
					<textarea class="bel_cms_textarea_full" name="content"><?=$data->content?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-12 control-label" for="checkbox"><?=READMORE;?>...</label>
				<div class="col-sm-12">
					<textarea class="bel_cms_textarea_full" name="additionalcontent"><?=$data->additionalcontent?></textarea>
				</div>
			</div>
			<div class="form-group form-actions">
				<div class="col-sm-12 col-sm-offset-3">
					<input type="hidden" name="author" value="<?=$data->author?>">
					<input type="hidden" name="id" value="<?=$data->id?>">
					<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> <?=SAVE?></button>
				</div>
			</div>
		</form>
	</div>
</div>
<?php
endif;