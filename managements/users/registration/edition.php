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

use BelCMS\Core\Secures;
use BelCMS\Requires\Common;
require_once ROOT.DS.'pages'.DS.'user'.DS.'country.php';

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<div class="flex flex-col gap-6">
	<div class="grid lg:grid-cols-2 gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4>Centre utilisateurs</h4>
				</div>
			</div>
			<div class="p-6">
				<form action="/registration/sendPrivate/?management&option=users" enctype="multipart/form-data" method="post">
					<div>
						<label class="col-md-12 control-label" for="inputSuccess1"><?=constant('NAME')?></label>
						<div class="col-md-12">
							<input value="<?=$user->user->username?>" id="inputSuccess1" type="text" class="form-input" placeholder="userName" readonly="readonly">
						</div>
					</div>
					<div>
						<label class="col-md-12 control-label" for="inputSuccess2">E-mail Privé</label>
						<div class="col-md-12">
							<input name="mail" value="<?=$user->user->mail?>" type="email" class="form-input" id="inputSuccess2" placeholder="email">
						</div>
					</div>
					<div>
						<label class="col-md-12 control-label" for="inputSuccess3">IP Utilisateur</label>
						<div class="col-md-12">
							<input value="<?=$user->user->ip?>" type="text" class="form-input has-feedback-left" id="inputSuccess3" placeholder="IP" readonly="readonly">
						</div>
					</div>
					<div>
						<label class="col-md-3 control-label" for="inputSuccess4">HashKey</label>
						<div class="col-md-12">
							<input type="text" class="form-input" readonly="readonly" id="inputSuccess4" value="<?=$user->user->hash_key?>">
						</div>
					</div>
					<input type="hidden" name="hash_key" value="<?=$user->user->hash_key;?>">
					<div>
						<div class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">
							<input type="hidden" name="hash_key" value="<?=$user->user->hash_key;?>">
							<button type="submit" class="btn bg-violet-500 border-violet-500 text-white"><i class="fa fa-dot-circle-o"></i> Enregister</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4>Gestions du groupe : Principale</h4>
				</div>
			</div>
			<div class="p-6">
				<form action="/registration/sendMainGroup?management&option=users" method="post" class="form-horizontal form-bordered">
					<div class="form-group">
						<label class="col-md-12 control-label" for="inputSuccess2">Groupe</label>
						<select name="main" class="form-select" tabindex="-1">
							<?php
							foreach (Secures::getGroups() as $key => $value):
							$title = defined(strtoupper($value)) ? constant(strtoupper($value)) : $value;
							$main_groups = $key == $user->groups->user_group ? 'selected="selected"': '';
							?>
							<option <?=$main_groups?> value="<?=$key?>"><?=$title?></option>
							<?php
							endforeach;
							?>
						</select>
					</div>
					<input type="hidden" name="hash_key" value="<?=$user->user->hash_key;?>">
					<div>
						<div class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">
							<button type="submit" class="btn bg-violet-500 border-violet-500 text-white"><i class="fa fa-dot-circle-o"></i> Enregister</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4>Gestions du groupe : Secondaire</h4>
				</div>
			</div>
			<div class="card-body">
				<form action="/registration/sendSecondGroup?management&option=users" method="post" class="p-6">
					<?php
					foreach (Secures::getGroups() as $key => $value):
						$title  = defined(strtoupper($value)) ? constant(strtoupper($value)) : $value;
						$groups = $user->groups->all_groups;
						if (in_array($key, $groups)) {
							$groups = 'checked="checked"';
						} else {
							$groups = '';
						}
						$groupsuser = $key == 2 ? 'checked="checked" readonly=""': ''; 
						?>
						<div class="flex items-center p-1"> 
                        	<input name="second[]" value="<?=$key;?>" type="checkbox" id="inputSuccess_<?=$key?>" class="form-switch square text-secondary" <?=$groups?> <?=$groupsuser?>>
                        	<label for="inputSuccess_<?=$key?>" class="ms-2"><?=$title?></label>
						</div>
					<?php
					endforeach;
					?>
					<input type="hidden" name="hash_key" value="<?=$user->user->hash_key;?>">
					<div>
						<div class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">
							<button type="submit" class="btn bg-violet-500 border-violet-500 text-white"><i class="fa fa-dot-circle-o"></i> Enregister</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="grid lg:grid-cols-2 gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4>Information public</h4>
				</div>
			</div>
			<div class="p-6">
				<form action="/registration/sendInfoPublic?management&option=users" enctype="multipart/form-data" method="post" class="form-horizontal form-bordered">
					<?php
					$user->profils->birthday = Common::DatetimeSQL($user->profils->birthday, false, 'Y-m-d');
					?>
					<div class="form-group">
						<label class="col-md-12 control-label" for="inputSuccess1">Anniversaire</label>
						<div class="col-md-12">
							<input id="birthday" class="form-input" type="date" name="birthday" value="<?=$user->profils->birthday?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="inputSuccess2">Public email</label>
						<div class="col-md-12">
							<input name="public_mail" value="<?=$user->profils->public_mail?>" type="email" class="form-input" placeholder="public email">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-12 control-label" for="gender">Genre</label>
						<div class="col-md-12">
							<select name="gender" id="gender" class="form-input">
							<?php
							if ($user->profils->gender == 'male') {
								$male      = 'selected="selected"';
								$female    = null;
								$unisexual = null;
							} elseif ($profil->profils->gender == 'female') {
								$female    = 'selected="selected"';
								$male      = null;
								$unisexual = null;
							} elseif ($profil->profils->gender == 'unisexual') {
								$unisexual = 'selected="selected"';
								$male      = null;
								$female    = null;
							}
							?>
							<option <?=$unisexual?> value="unisexual">Non spécifié</option>
							<option <?=$male?> value="male">Homme</option>
							<option <?=$female?> value="female">Femme</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-12 control-label" for="inputSuccess4">Pays</label>
						<div class="col-md-12">
							<select name="country" class="form-input">
							<?php
							foreach (contryList() as $k => $v):
								$selected = $user->profils->country == $v ? 'selected="selected"' : '';
								echo '<option '.$selected.' value="'.$v.'">'.$v.'</option>';
							endforeach;
							?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-12 control-label" for="inputSuccess4">Website</label>
						<div class="col-md-12">
							<input name="websites" value="<?=$user->profils->websites?>" type="url" class="form-input" placeholder="https://">
						</div>
					</div>
					<input type="hidden" name="hash_key" value="<?=$user->user->hash_key;?>">
					<div>
						<div class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">
							<button type="submit" class="btn bg-violet-500 border-violet-500 text-white"><i class="fa fa-dot-circle-o"></i> Enregister</button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4>Gestion Social</h4>
				</div>
			</div>
			<div class="p-6">
				<form action="/registration/sendSocial?management&option=users" method="post">
					<div class="form-group">
						<?php
						foreach ($user->social as $key => $value):
							if ($key != 'id' && $key != 'hash_key'):
							?>
							<div class="form-group">
								<label class="col-md-12 control-label" for="<?=$key?>"><?=$key?></label>
								<div class="col-md-12">
									<input type="text" id="<?=$key?>" class="form-input" name="<?=$key?>" value="<?=$value?>">
								</div>
							</div>
							<?php
							endif;
						endforeach;
						?>
					</div>
					<input type="hidden" name="hash_key" value="<?=$user->user->hash_key;?>">
					<div>
						<div class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">
							<button type="submit" class="btn bg-violet-500 border-violet-500 text-white"><i class="fa fa-dot-circle-o"></i> Enregister</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
