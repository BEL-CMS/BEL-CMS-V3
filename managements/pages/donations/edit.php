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

use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<form action="Donations/sendedit?management&option=pages" method="post">
	<div class="grid lg:grid-cols-2 gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('DONATIONS');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
					<div class="mt-2 mb-2">
                        <div class="flex items-center opacity-60">
							<input class="form-switch" <?=$data->valid == 1 ? 'checked' : ''?> name="active" type="checkbox"  value="1" role="switch" id="active">
							<label class="ms-1.5" for="active"><?=constant('PAIE_OK');?></label>
						</div>
					</div>
					<div class="mt-2 mb-2">
                        <label class="text-gray-800 text-sm font-medium inline-block mb-2"><?=constant('PAY_BY');?></label>
						<input type="text" class="form-input" value="<?=$data->type;?>" disabled>
					</div>
					<div class="mt-2 mb-2">
                        <label class="text-gray-800 text-sm font-medium inline-block mb-2"><?=constant('TOTAL_DONATION');?></label>
						<input type="text" name="number" class="form-input" value="<?=$data->sold;?>" requires>
					</div>
					<div class="mt-2 mb-2">
                        <label class="text-gray-800 text-sm font-medium inline-block mb-2"><?=constant('DATE_OF_DONATION');?></label>
						<input type="text" class="form-input" value="<?=Common::TransformDate($data->date_paie,'FULL', 'MEDIUM');?>" disabled>
					</div>
					<div class="mt-2 mb-2">
                        <label class="text-gray-800 text-sm font-medium inline-block mb-2"><?=constant('ID_DONATION');?></label>
						<input type="text" class="form-input" value="<?=$data->id_purchase;?>" disabled>
					</div>
                </div>
            </div>
        </div>
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('INFOS_USER_DONATIONS');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
                    <div class="mt-2 mb-2">
                        <label for="simpleinput" class="text-gray-800 text-sm font-medium inline-block mb-2"><?=constant('FIRST_NAME_PSEUDO');?></label>
                        <input type="text" class="form-input" value="<?=$data->name;?>" disabled>
                    </div>
                    <div class="mt-2 mb-2">
                        <label for="simpleinput" class="text-gray-800 text-sm font-medium inline-block mb-2"><?=constant('EMAIL_ADRESS');?></label>
                        <input type="email" class="form-input" value="<?=$data->mail;?>" disabled>
                    </div>
                </div>
            </div>
			<div class="p-6">
				<div class="overflow-x-auto">
					<textarea disabled><?=$data->msg;?></textarea>
                </div>
            </div>
        </div>
    </div>
	<div class="mt-2 mb-2">
		<input type="hidden" name="id" value="<?=$data->id;?>">
		<button type="submit" class="btn bg-violet-500 border-violet-500 text-white">
			<i class="fa fa-dot-circle-o"></i><?=constant('EDIT');?>
		</button>
	</div>
</form>