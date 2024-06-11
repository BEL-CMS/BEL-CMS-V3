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
<form action="Mail/send?management&option=parameter" method="post">
	<div class="flex flex-col gap-6">
		<div class="grid lg:grid-cols-2 gap-6">
			<div class="card">
				<div class="card-header">
					<h4><?=constant('MAIL_TITLE_NAME');?></h4>
				</div>
				<div class="p-6">
					<div>
						<label for="host" class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">Host</label>
						<input name="host" type="text" class="form-input" id="host" value="<?=$data->host;?>">
					</div>
					<div>
						<label for="port" class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">Port</label>
						<select name="port" id="port" class="form-input">
							<option value="<?=$data->Port;?>"><?=$data->Port;?></option>
							<option value="2525">2525</option>
							<option value="587">587</option>
							<option value="465">465</option>
							<option value="25">25</option>
						</select>
					</div>
					<div>
						<label for="SMTPAuth" class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">SMTPAuth</label>
						<select name="SMTPAuth" id="SMTPAuth" class="form-input">
							<option value="<?=$data->SMTPAuth;?>"><?=$data->SMTPAuth;?></option>
							<option value="true">true</option>
							<option value="false">false</option>
						</select>
					</div>
					<div>
						<label for="SMTPAutoTLS" class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">SMTPAutoTLS</label>
						<select name="SMTPAutoTLS" id="SMTPAutoTLS" class="form-input">
							<option value="<?=$data->SMTPAutoTLS;?>"><?=$data->SMTPAutoTLS;?></option>
							<option value="true">true</option>
							<option value="false">false</option>
						</select>
					</div>
					<div>
						<label for="WordWrap" class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">WordWrap 40-70</label>
						<input type="range" min="40" max="70" class="form-input" value="<?=$data->WordWrap;?>">
					</div>
					<div>
						<label for="SMTPAuth" class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">IsHTML</label>
						<select name="IsHTML" id="IsHTML" class="form-input">
							<option value="<?=$data->IsHTML;?>"><?=$data->IsHTML;?></option>
							<option value="true">true</option>
							<option value="false">false</option>
						</select>
					</div>
					<div>
						<label for="charset" class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">Charset</label>
						<select name="charset" id="charset" class="form-input">
							<option value="<?=$data->charset;?>"><?=$data->charset;?></option>
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
				<div class="p-6">
					<div>
						<label for="setFrom" class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">Email a affiché</label>
						<input name="setFrom" type="text" class="form-input" id="setFrom" value="<?=$data->setFrom;?>">
					</div>
					<div>
						<label for="fromName" class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">Nom a affiché</label>
						<input name="fromName" type="text" class="form-input" id="fromName" value="<?=$data->fromName;?>">
					</div>
					<div>
						<label for="username" class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">Nom d'utilisateur</label>
						<input name="username" type="text" class="form-input" id="username" value="<?=$data->username;?>">
					</div>
					<div>
						<label for="Password" class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">Mot de passe</label>
						<input name="Password" type="password" class="form-input" id="Password" value="<?=$data->Password;?>">
					</div>
				</div>
			</div>
			<div class="flex flex-col gap-12">
				<div>
                    <div class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">
                         <button type="submit" class="btn bg-violet-500 border-violet-500 text-white"><i class="fa fa-dot-circle-o"></i> <?=constant('SAVE');?></button>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>