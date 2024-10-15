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

use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

$mail = (empty($data->cms_mail_website->value)) ? $_SERVER['SERVER_ADMIN'] : $data->cms_mail_website->value;
$checked1 = $data->cms_debug->value == '1' ? 'checked="checked"' : '';
$checked2 = $data->cms_log->value   == '1' ? 'checked="checked"' : '';
?>
<form action="prefgen/send?management&option=parameter" method="post">
	<div class="flex flex-col gap-6">
		<div class="grid lg:grid-cols-2 gap-6">
			<div class="card">
				<div class="card-header">
					<h4><?=constant('MANAGEMENT_TITLE_NAME');?></h4>
				</div>
				<div class="p-6">
					<div>
						<label for="ADMIN_WEBSITE_NAME" class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">
							<?=constant('CMS_TITLE');?>
						</label>
						<input name="cms_website_name" <?=$data->cms_website_name->editable;?> value="<?=$data->cms_website_name->value;?>" type="text" class="form-input" id="ADMIN_WEBSITE_NAME">
					</div>
					<div>
						<label for="ADMIN_WEBSITE_DESCRIPTION" class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">
							<?=constant('ADMIN_WEBSITE_DESCRIPTION');?>
						</label>
						<input name="cms_website_description" <?=$data->cms_website_description->editable;?> value="<?=$data->cms_website_description->value;?>" type="text" class="form-input" id="ADMIN_WEBSITE_DESCRIPTION">
					</div>
					<div>
						<label for="ADMIN_WEBSITE_KEYWORDS" class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">
							<?=constant('ADMIN_WEBSITE_KEYWORDS');?>
						</label>
						<input name="cms_website_keywords" value="<?=$data->cms_website_keywords->value;?>" type="text" class="form-input" id="ADMIN_WEBSITE_KEYWORDS">
					</div>
					<div>
						<div class="flex">
							<div class="mt-2 mb-2 inline-flex items-center whitespace-nowrap px-3 rounded-s border border-e-0 border-gray-200 bg-gray-50 text-gray-500 dark:bg-gray-700 dark:border-gray-700 dark:text-gray-400">
								<?=constant('ADMIN_REGISTER_CHARTER');?>
							</div>
							<textarea rows="4" class="form-textarea ltr:rounded-s-none rtl:rounded-e-none mt-2 mb-2"><?=$data->cms_register_charter->value;?></textarea>
						</div>
					</div>
					<div>
						<label for="ADMIN_MAIL_WEBSITE" class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('ADMIN_MAIL_WEBSITE');?></label>
						<input name="cms_mail_website" <?=$data->cms_mail_website->editable;?> value="<?=$mail;?>" type="text" class="form-input" id="ADMIN_MAIL_WEBSITE">
					</div>
					<div>
						<label for="ADMIN_CAPTCHA" class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('ADMIN_CAPTCHA');?></label>
						<input name="captcha" <?=$data->captcha->editable;?> value="<?=$data->captcha->value;?>" type="number" min="3" class="form-input" id="ADMIN_CAPTCHA">
					</div>
					<div>
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('ADMIN_VALIDATION');?></label>

						<select class="form-select" id="ADMIN_VALIDATION" name="validation">
						<?php
						 	echo  $data->validation->value == 'mail' ? '<option selected value="mail">'.constant('ADMIN_VALIDATION').'</option>' : ''; 
							echo '<option value="0">'.constant('ADMIN_VALIDATION_AUTO').'</option>';
							echo '<option value="mail">'.constant('ADMIN_VALIDATION').'</option>';
							?>
                        </select>
					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-header">
					<h3 class="card-title"><?=constant('INDICATION_SETTING');?></h3>
				</div>
				<div class="p-6">
					<div>
						<label for="DATE_INSTALL" class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('DATE_INSTALL');?></label>
						<input <?=$data->cms_date_install->editable;?> value="<?=Common::TransformDate($data->cms_date_install->value, 'FULL', 'SHORT');?>" type="text" class="form-input" id="DATE_INSTALL">
					</div>
					<div>
						<label for="ADMIN_WEBSITE_LANG" class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('ADMIN_WEBSITE_LANG');?></label>
						<input <?=$data->cms_website_lang->editable;?> value="<?=$data->cms_website_lang->value;?>" type="text" class="form-input" id="ADMIN_WEBSITE_LANG">
					</div>
					<div>
						<label for="ADMIN_VERSION_CMS" class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('ADMIN_VERSION_CMS');?></label>
						<input <?=$data->cms_version->editable;?> value="<?=$data->cms_version->value;?>" type="text" class="form-input" id="ADMIN_VERSION_CMS">
					</div>
					<div>
						<label for="ADMIN_TPL_WEBSITE" class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('ADMIN_TPL_WEBSITE');?></label>
						<input <?=$data->cms_tpl_website->editable;?> value="<?=$data->cms_tpl_website->value == '' ? constant('NO_THEME_DEFINED') : $data->cms_tpl_website->value;?> " type="text" class="form-input" id="ADMIN_TPL_WEBSITE">
					</div>
					<div>
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('ADMIN_TPL_FULL');?></label>
						<select multiple="" class="form-input" disabled="disabled">
							<?php
							$a = explode(',', $data->cms_tpl_full->value);
							foreach ($a as $v):
								echo '<option>'.$v.'</option>';
							endforeach;
							?>
						</select>
					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-header">
					<h4><?=constant('ERRORS_AND_API_SETTINGS');?></h4>
				</div>
				<div class="p-6">	
					<div>
						<div class="flex items-center opacity-60">
							<input class="form-switch" name="cms_debug" type="checkbox" <?=$checked1;?> value="1" role="switch" id="cms_debug">
							<label class="ms-1.5" for="cms_debug"><?=constant('ADMIN_BELCMS_DEBUG');?></label>
						</div>
					</div>
					<div>
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2" for="ADMIN_API_KEY"><?=constant('ADMIN_API_KEY');?></label>
						<input name="api_key" <?=$data->api_key->editable;?> value="<?=$data->api_key->value;?>" type="text" class="form-input" id="ADMIN_API_KEY">
					</div>
				</div>
			</div>
			<button type="submit" class="btn bg-primary text-white"><?=constant('SAVE');?></button>
		</div>
	</div>
</form>
