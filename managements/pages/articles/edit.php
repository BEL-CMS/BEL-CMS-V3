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
$c    = null;
if ($data->tags != null) {
	foreach ($data->tags as $k => $v) {
		$v = str_replace(' ','',$v);
		if ($c != $k+1) {
			$tags.= $v. ', ';
		} else {
			$tags.= $v;
		}
	}
}
?>
<div class="flex flex-col gap-6">
	<div class="grid lg:grid-cols-1 gap-6">
		<div class="card">
			<div class="card-header">
				<h4><?=constant('EDITING');?> <?=constant('ARTICLE');?></h4>
			</div>
			<div class="p-6">
				<form action="/articles/sendedit?management&option=pages" method="post" class="form-horizontal form-bordered">
					<div>
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('NAME');?> :</label>
						<div class="col-sm-12">
							<input name="name" type="text" class="form-input" value="<?=$data->name?>">
						</div>
					</div>
					<div>
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('TAGS');?> :</label>
						<div class="col-sm-12">
							<input name="tags" placeholder="( séparer par des => , )" value="<?=$tags?>" type="text" value="" data-role="tagsinput" class="form-input">
						</div>
					</div>
					<div>
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('TEXT');?> :</label>
						<div class="mt-2 mb-2">
							<textarea class="bel_cms_textarea_full" name="content"><?=$data->content?></textarea>
						</div>
					</div>
					<div>
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('READMORE_ADMIN');?></label>
						<div class="col-sm-12 mt-2 mb-2">
							<textarea class="bel_cms_textarea_full" name="additionalcontent"><?=$data->additionalcontent?></textarea>
						</div>
					</div>
					<div>
						<div>
							<input type="hidden" name="author" value="<?=$data->author?>">
							<input type="hidden" name="id" value="<?=$data->id?>">
							<button type="submit" class="btn bg-violet-500 border-violet-500 text-white"><i class="fa fa-dot-circle-o"></i> <?=constant('SAVE')?></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
endif;