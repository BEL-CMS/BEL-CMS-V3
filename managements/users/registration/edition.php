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
<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Centre utilisateurs</h3>
			</div>
			<div class="card-body">
				<form action="/registration/sendPrivate/<?=$user->id?>?management&users" enctype="multipart/form-data" method="post">
					<div class="form-group">
						<label class="col-md-12 control-label" for="inputSuccess1"><?=NAME?></label>
						<div class="col-md-12">
							<input value="<?=$user->username?>" id="inputSuccess1" type="text" class="form-control" placeholder="userName" readonly="readonly">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-12 control-label" for="inputSuccess2">E-mail Privé</label>
						<div class="col-md-12">
							<input name="email" value="<?=$user->email?>" type="email" class="form-control" id="inputSuccess2" placeholder="email">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-12 control-label" for="inputSuccess3">IP Utilisateur</label>
						<div class="col-md-12">
							<input value="<?=$user->ip?>" type="text" class="form-control has-feedback-left" id="inputSuccess3" placeholder="IP" readonly="readonly">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="inputSuccess4">HashKey</label>
						<div class="col-md-12">
							<input type="text" class="form-control" readonly="readonly" id="inputSuccess4" value="<?=$user->hash_key?>">
						</div>
					</div>
					<input type="hidden" name="hash_key" value="<?=$user->hash_key;?>">
					<div class="form-group form-actions">
						<div class="col-md-12 col-md-offset-3">
							<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Submit</button>
							<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Gestions du groupe : Principale</h3>
			</div>
			<div class="card-body">
				<form action="/registration/sendMainGroup?management&users&parameter=true" method="post" class="form-horizontal form-bordered">
					<div class="form-group">
						<label class="col-md-12 control-label" for="inputSuccess2">Groupe</label>
						<div class="col-md-12">
							<select name="main" class="select2_single form-control" tabindex="-1">
							<?php
							foreach (Secures::getGroups() as $key => $value):
							$title = defined(strtoupper($value)) ? constant(strtoupper($value)) : $value;
							$main_groups = $key == $user->main_groups ? 'selected="selected"': '';
							?>
							<option <?=$main_groups?> value="<?=$key?>"><?=$title?></option>
							<?php
							endforeach;
							?>  
							</select>
						</div>
					</div>
					<input type="hidden" name="hash_key" value="<?=$user->hash_key;?>">
					<div class="form-group form-actions">
						<div class="col-md-9 col-md-offset-3">
							<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Submit</button>
							<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Gestions du groupe : Secondaire</h3>
		</div>
		<div class="card-body">
			<form action="/registration/sendSecondGroup?management&page&parameter=true" method="post" class="form-horizontal form-bordered">
				<?php
				foreach (Secures::getGroups() as $key => $value):
				?>
				<div class="form-group">
					<?php
					$title  = defined(strtoupper($value)) ? constant(strtoupper($value)) : $value;
					$groups = explode('|', $user->groups);
					if (in_array($key, $groups)) {
						$groups = 'checked="checked"';
					} else {
						$groups = '';
					}
					$groupsuser = $key == 2 ? 'checked="checked" readonly=""': ''; 
					?> 
					<label class="col-md-12 control-label" for="inputSuccess2"><?=$title?></label>
					<div class="col-md-12">
						<input value="<?=$key?>" name="second[]" type="checkbox" <?=$groups?> <?=$groupsuser?>> 
					</div>
				</div>
				<?php
				endforeach;
				?>
				<input type="hidden" name="hash_key" value="<?=$user->hash_key;?>">
				<div class="form-group form-actions">
					<div class="col-md-12 col-md-offset-3">
						<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Submit</button>
						<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>
					</div>
				</div>
			</form>
		</div>
	</div>

</div>

<div class="col-md-6">
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Information public</h3>
		</div>
		<div class="card-body">
			<form action="/registration/sendInfoPublic?management&page&parameter=true" enctype="multipart/form-data" method="post" class="form-horizontal form-bordered">
				<?php
				$profil->birthday = Common::DatetimeSQL($profil->birthday, false, 'Y-m-d');
				?>
				<div class="form-group">
					<label class="col-md-12 control-label" for="inputSuccess1">Anniversaire</label>
					<div class="col-md-12">
						<input id="birthday" class="form-control" type="date" name="birthday" value="<?=$profil->birthday?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label" for="inputSuccess2">Public email</label>
					<div class="col-md-12">
						<input name="public_mail" value="<?=$profil->public_mail?>" type="email" class="form-control" id="inputSuccess3" placeholder="public email">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-12 control-label" for="inputSuccess3">Genre</label>
					<div class="col-md-12">
						<select name="gender" class="form-control">
						  <?php
						  if ($profil->gender == 'male') {
							$male      = 'selected="selected"';
							$female    = null;
							$unisexual = null;
						  } elseif ($profil->gender == 'female') {
							$female    = 'selected="selected"';
							$male      =  null;
							$unisexual = null;
						  } elseif ($profil->gender == 'unisexual') {
							$unisexual =' selected="selected"';
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
						<select name="country" class="form-control">
						  <?php
						  foreach (Common::contryList() as $k => $v):
							$selected = $profil->country == $v ? 'selected="selected"' : '';
							echo '<option '.$selected.' value="'.$v.'">'.$v.'</option>';
						  endforeach;
						  ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-12 control-label" for="inputSuccess4">Website</label>
					<div class="col-md-12">
						<input name="websites" value="<?=$profil->websites?>" type="url" class="form-control" placeholder="https://">
					</div>
				</div>
				<input type="hidden" name="hash_key" value="<?=$user->hash_key;?>">
				<div class="form-group form-actions">
					<div class="col-md-12 col-md-offset-3">
						<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Submit</button>
						<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Gestion Social</h3>
		</div>
		<div class="card-body">
			<form action="/registration/sendSocial?management&page&parameter=true" method="post" class="form-horizontal form-bordered">
				<div class="form-group">
					<?php
					foreach ($social as $key => $value):
						if ($key != 'id' && $key != 'hash_key'):
						?>
						<div class="form-group">
							<label class="col-md-12 control-label" for="<?=$key?>"><?=$key?></label>
							<div class="col-md-12">
								<input type="text" id="<?=$key?>" class="form-control" name="<?=$key?>" value="<?=$value?>">
							</div>
						</div>
						<?php
						endif;
					endforeach;
					?>
				</div>
				<input type="hidden" name="hash_key" value="<?=$user->hash_key;?>">
				<div class="form-group form-actions">
					<div class="col-md-12 col-md-offset-3">
						<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Submit</button>
						<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
