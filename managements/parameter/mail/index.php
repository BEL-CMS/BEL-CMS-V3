<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.3 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<form action="prefgen/send?management&option=parameter" method="post">
	<div class="flex flex-col gap-6">
		<div class="grid lg:grid-cols-2 gap-6">
			<div class="card">
				<div class="card-header">
					<h4><?=constant('MAIL_TITLE_NAME');?></h4>
				</div>
				<div class="p-6">
					<div>
						<label for="host" class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">Host</label>
						<input name="host" type="text" class="form-input" id="host">
					</div>
					<div>
						<label for="port" class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">Port</label>
						<select name="port" id="port" class="form-input">
							<option value="2525">2525</option>
							<option value="587">587</option>
							<option value="465">465</option>
							<option value="25">25</option>
						</select>
					</div>
					<div>
						<label for="SMTPAuth" class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">SMTPAuth</label>
						<select name="SMTPAuth" id="SMTPAuth" class="form-input">
							<option value="true">true</option>
							<option value="false">false</option>
						</select>
					</div>
					<div>
						<label for="WordWrap" class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">WordWrap 50-70</label>
						<input type="range" min="50" max="80" class="form-input">
					</div>
					<div>
						<label for="SMTPAuth" class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">IsHTML</label>
						<select name="IsHTML" id="IsHTML" class="form-input">
							<option value="true">true</option>
							<option value="false">false</option>
						</select>
					</div>
					<div>
						<label for="charset" class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">Charset</label>
						<select name="charset" id="charset" class="form-input">
							<option value="utf-8">UTF-8</option>
							<option value="iso-8859-1">ISO-8859-1</option>
							<option value="Windows-1252">Windows-1252</option>
						</select>
					</div>
				</div>
			</div>
			<div class="flex flex-col gap-6">
			<div class="card">
				<div class="card-header">
					<h4><?=constant('MAIL_TITLE_NAME');?></h4>
				</div>
			</div>
		</div>
	</div>
</div>