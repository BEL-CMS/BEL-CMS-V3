<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.5 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BELCMS\User\User as UserInfos;
use BelCMS\Requires\Common as Common;
require ROOT.DS.'pages'.DS.'user'.DS.'country.php';

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

if (UserInfos::isLogged() === true):
	if (!empty($user->profils->gender)) {
		$user->gender   = strtolower($user->profils->gender);
		$genderM        = $user->gender == 'MALE' ? 'selected' : '';
		$genderF        = $user->gender == 'FEMALE' ? 'selected' : '';
		$genderU        = $user->gender == 'NOSPEC' ? 'selected' : '';
	} else {
		$genderM        = '';
		$genderF        = '';
		$genderU        = 'selected';
	}
	$birthday = Common::DatetimeReverse($user->profils->birthday);
	if (empty($user->profils->avatar)) {
		$user->profils->avatar = constant('DEFAULT_AVATAR');
	}
	if (!empty($user->profils->hight_avatar) and !is_file($user->profils->hight_avatar)) {
		$user->profils->hight_avatar = 'assets/img/bg_default.png';
	}
?>
<section id="section_user">
	<form action="user/sendaccount" method="post">
	<?php require 'menu.php'; ?>
		<div id="section_user_profil">
			<h2>Informations personnelles</h2>
			<div class="section_user_profil_form_row">
				<i class="fa-regular fa-user"></i>
				<input id="username" type="text" required="required" name="username" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$" value="<?=$_SESSION['USER']->user->username;?>">
			</div>
			<div class="section_user_profil_form_row">
				<i class="fa-solid fa-at"></i>
				<input id="mail" required="required" type="email" name="mail" value="<?=$_SESSION['USER']->user->mail;?>">
			</div>
			<div class="section_user_profil_form_row">
			<i class="fa-solid fa-calendar-days"></i>
				<input id="birthday" placeholder="Anniversaire" class="bel_cms_input" type="date" name="birthday" value="<?=$_SESSION['USER']->profils->birthday;?>">
			</div>
			<div class="section_user_profil_form_row">
				<i class="fa-solid fa-link"></i>
				<input placeholder="Site-Web" name="websites" type="url" value="<?=$_SESSION['USER']->profils->websites;?>">
			</div>
			<div class="section_user_profil_form_row">
				<i class="fa-solid fa-earth-europe"></i>
				<select name="country">
					<?php
					foreach (contryList() as $k => $v):
						$selected = $user->profils->country == $v ? 'selected="selected"' : '';
						echo '<option '.$selected.' value="'.$v.'">'.$v.'</option>';
					endforeach;
					?>
				</select>
			</div>
			<div class="section_user_profil_form_row">
				<i class="fa-solid fa-venus-mars"></i>
				<select name="gender">
					<option <?=$genderM?> value="male"><?=constant('MALE')?></option>
					<option <?=$genderF?> value="female"><?=constant('FEMALE')?></option>
					<option <?=$genderU?> value="nospec"><?=constant('NO_SPEC')?></option>
				</select>
			</div>
		</div>
		<div id="section_user_profil_right">
			<div id="section_user_profil_avatar">
				<div id="section_user_profil_avatar_change">
					<img src="<?=$user->profils->avatar;?>">
				</div>
				<a href="User/Avatar">Upload nouvelle photo</a>
			</div>
			<h2>Signature</h2>
			<div class="form_user_label">
				<textarea name="info_text" class="bel_cms_textarea_simple"><?=$_SESSION['USER']->profils->info_text?></textarea>
			</div>
		</div>
		<button type="submit" class="belcms_btn belcms_bg_grey">Enregistrer</button>
	</form>
</section>
<?php
endif;