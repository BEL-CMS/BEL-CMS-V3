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
<div class="flex flex-col gap-6">
	<div class="grid gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4><?=constant('BANISHMENT');?></h4>
				</div>
			</div>
			<div class="p-6">
				<form action="banishment/sendadd/?management&option=users" enctype="multipart/form-data" method="post">
					<div class="mt-2 mb-2">
						<label class="col-md-12 control-label" for="ban_author"><?=constant('NAME')?></label>
						<select class="form-input" name="author" id="ban_author">
							<option value="0"><?=constant('CHOSE_USER');?></option>
							<?php
							foreach ($author as $k => $v):
								if ($_SESSION['USER']->user->hash_key !== $v->hash_key):
							?>
							<option class="form-control" value="<?=$v->hash_key;?>"><?=$v->username;?></option>
							<?php
								endif;
							endforeach;
							?>
						</select>
					</div>
					<div class="mt-2 mb-2">
						<label class="col-sm-12 control-label" for="email"><?=constant('MAIL');?></label>
						<input type="email" name="email" id="email" class="form-input">
					</div>
					<div class="mt-2 mb-2">
						<label class="col-sm-12 control-label" for="checkbox"><?=constant('REASON');?></label>
						<textarea name="reason" class="bel_cms_textarea_simple"></textarea>
					</div>
					<div class="mt-2 mb-2">
						<label class="col-sm-12 control-label" for="input-name"><?=constant('DATE_OF_BAN');?></label>
						<select name="date" class="select2_single form-input">
							<option value="P99Y"><?=constant('LIFE');?></option>
							<option value="PT1M"><?=constant('ONE_MINUTE');?></option>
							<option value="PT5M"><?=constant('FIVE_MINUTES');?></option>
							<option value="PT15M"><?=constant('FIFTEEN_MINUTES');?></option>
							<option value="PT30M"><?=constant('THIRTY_MINUTES');?></option>
							<option value="PT1H"><?=constant('ONE_O_CLOCK');?></option>
							<option value="PT3H"><?=constant('THREE_O_CLOCK');?></option>
							<option value="PT6H"><?=constant('SIX_O_CLOCK');?></option>
							<option value="PT12H"><?=constant('TWELVE_O_CLOCK');?></option>
							<option value="P1D"><?=constant('A_DAY');?></option>
							<option value="P7D"><?=constant('ONE_WEEK');?></option>
							<option value="P14D"><?=constant('TWO_WEEK');?></option>
							<option value="P1M"><?=constant('A_MONTH');?></option>
							<option value="P3M"><?=constant('THREE_MONTHS');?></option>
							<option value="P6M"><?=constant('SIX_MONTHS');?></option>
							<option value="P1Y"><?=constant('ONE_YEAR');?></option>
							<option value="P5Y"><?=constant('FIVE_YEARS');?></option>
							<option value="P10Y"><?=constant('TEN');?></option>
						</select>
					</div>
					<div class="mt-2 mb-2">
						<label class="col-sm-12 control-label" for="checkbox"><?=constant('IPV4_IPV6');?></label>
						<input type="text" class="form-input" id="ipv4" name="ip_ban" placeholder="xxx.xxx.xxx.xxx">
					</div>
					<div class="mt-2 mb-2">
						<label class="col-sm-12 control-label"><?=constant('REQUIRE_ADMIN_MAX');?></label>
						<input type="text" min="32" max="32" name="gold" class="form-input">
					</div>
					<div class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">
						<button type="submit" class="btn bg-violet-500 border-violet-500 text-white">
							<i class="fa fa-dot-circle-o"></i><?=constant('SAVE');?>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>