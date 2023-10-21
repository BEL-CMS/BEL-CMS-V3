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
if (Users::isLogged() === true):
	$user->gender   = mb_strtoupper($user->gender);
	$genderM        = strtoupper($user->gender) == strtoupper(constant('MALE')) ? 'selected' : '';
	$genderF        = strtoupper($user->gender) == strtoupper(constant('FEMALE')) ? 'selected' : '';
	$genderU        = strtoupper($user->gender) == strtoupper(constant('UNISEXUAL')) ? 'selected' : '';
	$user->birthday = Common::DatetimeSQL($user->birthday, false, 'Y-m-d');
	require_once 'nav.php';
?>

	<div id="belcms_section_user_main">
		<div id="belcms_section_user_main_left">
			<div class="belcms_card">
				<div class="belcms_title">Profil</div>
				<form action="user/sendaccount" method="post" class="belcms_section_user_main_form">
					<div>
						<h3 class="belcms_h3_input_lf">Nom d'utilisateur :</h3>
						<input placeholder="Nom d'utilisateur" class="bel_cms_input" name="username" type="text" required="required" value="<?=$user->username?>" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf">Adresse e-mail privé :</h3>
						<input type="email" placeholder="e-mail" class="bel_cms_input" required="required" name="mail" value="<?=$user->email?>">
						<i class="belcms_form_group_i" style="display: block; text-align: left;">* L'adresse email ne sera jamais affichée publiquement.</i>
					</div>
					<div>
						<h3 class="belcms_h3_input_lf">Votre anniversaire :</h3>
						<input id="birthday" placeholder="Anniversaire" class="bel_cms_input" type="date" name="birthday" value="<?=$user->birthday?>">
					</div>
					<div>
						<h3 class="belcms_h3_input_lf">Votre pays :</h3>
						<select name="country" class="bel_cms_input">
							<?php
							foreach (Common::contryList() as $k => $v):
								$selected = $user->country == $v ? 'selected="selected"' : '';
								echo '<option '.$selected.' value="'.$v.'">'.$v.'</option>';
							endforeach;
							?>
						</select>
					</div>
					<div>
						<h3 class="belcms_h3_input_lf">Votre genre :</h3>
						<select name="gender" class="bel_cms_input">
							<option <?=$genderM?> value="male"><?=MALE?></option>
							<option <?=$genderF?> value="female"><?=FEMALE?></option>
							<option <?=$genderU?> value="nospec"><?=NO_SPEC?></option>
						</select>
					</div>
					<div>
						<h3 class="belcms_h3_input_lf">Votre Site-Web :</h3>
						<input placeholder="Site-Web" class="bel_cms_input" name="websites" type="text" value="<?=$user->websites?>" pattern="https?://.+">
					</div>
					<button type="submit" class="belcms_btn"><?=CONFIRM?></button>
				</form>
			</div>
		</div>
		<div id="belcms_section_user_main_right">
			<div class="belcms_card">
				<div class="belcms_title">Avatar</div>
				<div id="belcms_section_user_main_right_avatar">
					<img src="<?=$user->avatar?>">
				</div>
				<div class="belcms_bg_grey_w belcms_pb_10">
					<a href="user/avatar" class="belcms_btn belcms_btn_blue"><?=MODIFY?></a>
				</div>
			</div>
		</div>
	</div>
<?php
endif;