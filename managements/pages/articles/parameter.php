<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.1.0 [PHP8.3]
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
<form action="Articles/sendparameter?management&option=pages" method="post">
	<div class="flex flex-col gap-6">
		<div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-6">
			<div class="card">
				<div class="card-header">
					<h4><?=constant('ARTICLES_ACTIVE');?></h4>
				</div>
				<div class="p-6">
					<div>
						<div class="flex items-center opacity-60">
							<input class="form-switch" <?=$config->active == 1 ? 'checked' : ''?> name="active" type="checkbox"  value="1" role="switch" id="active">
							<label class="ms-1.5" for="active"><?=constant('ARTICLES_PAGE_ACTIVE');?></label>
						</div>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header">
					<h4><?=constant('ACCESS_TO_ADMIN');?></h4>
				</div>
				<div class="p-6">
					<?php
					foreach ($groups as $k => $v):
						$checked = in_array($v['id'], $config->access_admin) ? 'checked' : '';
						$checked = $v['id'] == 1 ? 'checked readonly' : $checked;
					?>
					<div class="mt-2 mb-2">
						<div class="flex items-center">
                            <input id="<?=$v['id']?>" value="<?=$v['id']?>" type="checkbox" name="admin[]" class="form-switch square text-success" <?=$checked?>>
                            <label for="<?=$v['id']?>" class="ms-2"><?=$k?></label>
                        </div>
					</div>
					<?php
					endforeach;
					?>
				</div>
			</div>

			<div class="card">
				<div class="card-header">
					<h4><?=constant('ACCESS_TO_GROUPS');?></h4>
				</div>
				<div class="p-6">
					<?php
					$visitor = constant('VISITORS');
					$groups->$visitor['id'] = 0;
					foreach ($groups as $k => $v):
						$checked = in_array($v['id'], $config->access_groups) ? 'checked' : '';
						$checked = $v['id'] == 1 ? 'checked readonly' : $checked;
						?>
						<div class="mt-2 mb-2">
							<div class="flex items-center">
								<input id="<?=$v['id']?>" value="<?=$v['id']?>" type="checkbox" name="groups[]" class="form-switch square text-success" <?=$checked?>>
								<label for="<?=$v['id']?>" class="ms-2"><?=$k?></label>
							</div>
						</div>
						<?php
					endforeach;
					?>
				</div>
			</div>
			<button type="submit" class="btn bg-primary text-white"><?=constant('SEND');?></button>
		</div>
	</div>
</form>
<?php
endif;
