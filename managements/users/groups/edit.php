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
?>
<form action="/groups/sendedit?management&users=true" enctype="multipart/form-data" method="post" class="form-horizontal">
	<div class="row">
		<div class="col-md-4">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Paramètres Groupes</h3>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label><?=NAME?></label>
						<div class="col-sm-12">
							<?php
							if ($data->name == 'MEMBERS' or $data->name == 'ADMINISTRATORS'):
								$lock = 'readonly';
							else:
								$lock = '';
							endif;
							?>
							<input <?=$lock;?> name="name" type="text" class="form-control form-control-border" value="<?=$data->name?>">
						</div>
					</div>
					<div class="form-group">
						<label><?=COLOR?></label>
						<div class="col-sm-12">
							<input type="text" name="color" class="form-control form-control-border colorpicker" value="<?=$data->color?>">
						</div>
					</div>
					<div class="form-group">
						<label>Upload Image</label>
						<div class="custom-file">
							<input type="file" name="image" class="custom-file-input" id="upload" accept="image/*">
							<label class="custom-file-label" for="upload">Upload</label>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<input type="hidden" name="id" value="<?=$data->id_group?>">
					<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> <?=SAVE?></button>
				</div>	
			</div>
		</div>
	</div>
</form>
<?php
endif;