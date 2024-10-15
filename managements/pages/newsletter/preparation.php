<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.1.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Requires\Common;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<form action="newsletter/sendppreparation?management&option=pages" method="post">
	<div class="grid lg:grid-cols-2 gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('PLANNING');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="flex flex-col gap-2">
					<div class="form-check">
						<input type="radio" class="form-radio text-success" name="send" id="formRadio01" value="all">
						<label class="ms-1.5" for="formRadio01"><?=constant('ALLMAIL');?></label>
					</div>
					<?php
					foreach ($groups as $key => $v):
						$name = defined(strtoupper($key)) ? constant(strtoupper($key)) : $key;
					?>
					<div class="form-check">
						<input type="radio" class="form-radio text-success" name="send" id="<?=$key;?>" value="<?=$v['id'];?>">
						<label class="ms-1.5" for="<?=$key;?>"><?=$name;?></label>
					</div>
					<?php
					endforeach;
					?>
					<div class="form-check">
						<input type="radio" class="form-radio text-success" name="send" id="formRadio02" value="2">
						<label class="ms-1.5" for="formRadio02"><?=constant('ALL_NEWS');?></label>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('TPL');?></h4>
				</div>
			</div>
			<div class="p-6">
			<?php
			foreach ($tpl as $key => $v):
			?>
			<div class="form-check">
				<input type="radio" class="form-radio text-success" name="tpl" id="<?=$v->name;?>" value="<?=$v->id;?>">
				<label class="ms-1.5" for="<?=$v->name;?>"><?=$v->name;?> du <?=Common::TransformDate($v->date, 'LONG', 'SHORT');?></label>
			</div>
			<?php
			endforeach;
			?>
		</div>
	</div>
	<div class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">
		<button type="submit" class="btn bg-violet-500 border-violet-500 text-white"><i class="fa fa-dot-circle-o"></i> <?=constant('SAVE');?></button>
	</div>
</form>