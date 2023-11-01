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
<div class="card">
	<div class="card-header">
		<h3 class="card-title"><?=BANISHMENT;?></h3>
		<div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
				<i class="fas fa-minus"></i>
			</button>
		</div>
	</div>
	<div class="card-body">
		<div class="form-group">
			<form action="/ban/sendadd?management&option=users" method="post" class="form-horizontal form-bordered">
				<div class="form-group">
					<label class="col-sm-12 control-label" for="ban_author"><?=NAME?></label>
					<div class="col-sm-12">
						<select class="control-label" name="author" id="ban_author">
							<option value="0"><?=CHOSE_USER;?></option>
							<?php
							foreach ($author as $k => $v):
								if ($_SESSION['USER']['HASH_KEY'] !== $v->hash_key):
							?>
							<option class="form-control" value="<?=$v->hash_key;?>"><?=$v->username;?></option>
							<?php
								endif;
							endforeach;
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-12 control-label" for="email"><?=MAIL?></label>
					<div class="col-sm-12">
						<input type="email" name="email" id="email">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-12 control-label" for="checkbox"><?=REASON;?></label>
					<div class="col-sm-12">
						<textarea name="reason"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-12 control-label" for="input-name"><?=DATE_OF_BAN?></label>
					<select name="date" class="select2_single form-control">
						<option value="P99Y"><?=LIFE?></option>
						<option value="PT1M"><?=ONE_MINUTE;?></option>
						<option value="PT5M"><?=FIVE_MINUTES;?></option>
						<option value="PT15M"><?=FIFTEEN_MINUTES;?></option>
						<option value="PT30M"><?=THIRTY_MINUTES;?></option>
						<option value="PT1H"><?=ONE_O_CLOCK;?></option>
						<option value="PT3H"><?=THREE_O_CLOCK;?></option>
						<option value="PT6H"><?=SIX_O_CLOCK;?></option>
						<option value="PT12H"><?=TWELVE_O_CLOCK;?></option>
						<option value="P1D"><?=A_DAY;?></option>
						<option value="P7D"><?=ONE_WEEK;?></option>
						<option value="P14D"><?=TWO_WEEK;?></option>
						<option value="P1M"><?=A_MONTH;?></option>
						<option value="P3M"><?=THREE_MONTHS;?></option>
						<option value="P6M"><?=SIX_MONTHS;?></option>
						<option value="P1Y"><?=ONE_YEAR;?></option>
						<option value="P5Y"><?=FIVE_YEARS;?></option>
						<option value="P10Y"><?=TEN;?></option>
					</select>
				</div>
				<div class="form-group">
					<label class="col-sm-12 control-label" for="checkbox"><?=IPV4_IPV6;?></label>
					<div class="col-sm-12">
						<input type="text" class="form-input" id="ipv4" name="ip_ban" placeholder="xxx.xxx.xxx.xxx">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-12 control-label"><?=REQUIRE_ADMIN_MAX;?></label>
					<div class="col-sm-12">
						<input type="text" min="32" max="32" name="gold" class="form-control">
					</div>
				</div>
				<div class="form-group form-actions">
					<div class="col-sm-12 col-sm-offset-3">
						<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> <?=SAVE?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>