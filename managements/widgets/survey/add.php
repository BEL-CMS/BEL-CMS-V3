<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
if (isset($_SESSION['LOGIN_MANAGEMENT']) && $_SESSION['LOGIN_MANAGEMENT'] === true):
?>
<div class="flex flex-col gap-6">
	<div class="grid lg:grid-cols-1 gap-6">
		<div class="card">
			<div class="card-header">
				<h4><?=constant('NEW');?> <?=constant('SURVEY');?></h4>
			</div>
			<div class="p-6">
				<form action="survey/sendNew?management&option=widgets" method="post">
					<div>
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('QUESTION');?></label>
						<div class="col-sm-12">
							<input name="name" type="text" class="form-input" value="" required>
						</div>
					</div>
					<div>
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('END_VOTE');?></label>
						<select name="dateclose" class="form-input">
							<option value="0"><?=constant('PLEASE_CHOOSE_OPTION');?></option>
							<option value="PT1M"><?=constant('PT1M');?></option>
							<option value="PT5M"><?=constant('PT5M');?></option>
							<option value="PT30M"><?=constant('PT30M');?></option>
							<option value="PT1H"><?=constant('PT1H');?></option>
							<option value="PT3H"><?=constant('PT3H');?></option>
							<option value="PT6H"><?=constant('PT6H');?></option>
							<option value="PT12H"><?=constant('PT12H');?></option>
							<option value="P1D"><?=constant('P1D');?></option>
							<option value="P7D"><?=constant('P7D');?></option>
							<option value="P14D"><?=constant('P14D');?></option>
							<option value="P1M"><?=constant('P1M');?></option>
							<option value="P3M"><?=constant('P3M');?></option>
							<option value="P6M"><?=constant('P6M');?></option>
							<option value="P1Y"><?=constant('P1Y');?></option>
							<option value="P5Y"><?=constant('P5Y');?></option>
							<option value="P5Y"><?=constant('P5Y');?></option>
							<option value="P10Y"><?=constant('P10Y');?></option>
							<option value="P99Y"><?=constant('P99Y');?></option>
						</select>
					</div>
					<div>
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('NUMBER_OF_RESPONSES');?></label>
						<div class="col-sm-12">
							<input name="nb" type="number" min="2" class="form-input" value="2">
						</div>
					</div>
					<div>
						<div class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">
							<button type="submit" class="btn bg-violet-500 border-violet-500 text-white"><i class="fa fa-dot-circle-o"></i> <?=constant('SAVE');?></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php 
endif;