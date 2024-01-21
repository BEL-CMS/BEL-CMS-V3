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

use BELCMS\User\User as UserInfos;
use BelCMS\Requires\Common as Common;
require ROOT.DS.'pages'.DS.'user'.DS.'country.php';

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

if (UserInfos::isLogged() === true):
	$user->gender   = strtolower($user->profils->gender);
	$genderM        = strtoupper($user->profils->gender) == 'MALE' ? 'selected' : '';
	$genderF        = strtoupper($user->profils->gender) == 'FEMALE' ? 'selected' : '';
	$genderU        = strtoupper($user->profils->gender) == 'NOSPEC' ? 'selected' : '';
	$birthday = Common::DatetimeReverse($user->profils->birthday);
	if (empty($user->profils->avatar)) {
		$user->profils->avatar = constant('DEFAULT_AVATAR');
	}
	if (!empty($user->profils->hight_avatar) and !is_file($user->profils->hight_avatar)) {
		$user->profils->hight_avatar = 'assets/img/bg_default.png';
	}
?>
<section id="section_user">
	<div class="flex-wrapper">
		<div class="flex-grid">
			<div class="d-col-4 t-col-4 m-col-12">
				<?php include 'nav.php'; ?>
			</div>
			<div class="d-col-8 t-col-8 m-col-12">
				<div class="user_avatar">
					<div class="user_avatar_content">
						<figure>
							<img src="<?=$user->profils->hight_avatar;?>">
						</figure>
						<div class="user_min_avatar">
							<img src="<?=$user->profils->avatar;?>">
						</div>
						<div class="user_blank"></div>
					</div>
				</div>
				<div class="user_avatar">
					<a href="User/Avatar" class="user_avatar_content plain">
						<span><i class="fa-solid fa-user"></i></span>
						<span>
							<p>Changer d'avatar</p>
							<p>100x100px size</p>
						</span>
					</a>
				</div>
				<div class="user_avatar">
					<a href="User/Background" class="user_avatar_content plain">
						<span><i class="fa-solid fa-panorama"></i></span>
						<span>
							<p>Changer de couverture</p>
							<p>1200x300px size</p>
						</span>
					</a>
				</div>
				<div class="clear"></div>
				<form action="user/sendaccount" method="post" class="flex-wrapper form_user">
					<div class="flex-grid">
						<div class="d-col-6 t-col-6 m-col-12">
							<div class="form_user_label">
								<label for="username">Nom d'utilisateur :</label>
								<input id="username" type="text" required="required" name="username" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$" value="<?=$_SESSION['USER']->user->username;?>">
							</div>
							<div class="form_user_label">
								<label for="birthday">Votre anniversaire :</label>
								<input id="birthday" placeholder="Anniversaire" class="bel_cms_input" type="date" name="birthday" value="<?=$_SESSION['USER']->profils->birthday;?>">
							</div>
							<div class="form_user_label">
								<label>Votre pays :</label>
								<select name="country">
								<?php
								foreach (contryList() as $k => $v):
									$selected = $user->profils->country == $v ? 'selected="selected"' : '';
									echo '<option '.$selected.' value="'.$v.'">'.$v.'</option>';
								endforeach;
								?>
								</select>
							</div>
						</div>
						<div class="d-col-6 t-col-6 m-col-12">
							<div class="form_user_label">
								<label for="mail">Adresse e-mail privé :*</label>
								<input id="mail" required="required" type="email" name="mail" value="<?=$_SESSION['USER']->user->mail;?>">
							</div>
							<div class="form_user_label">
								<label for="">Votre site internet :</label>
								<input placeholder="Site-Web" name="websites" type="url" value="<?=$_SESSION['USER']->profils->websites;?>">
							</div>
							<div class="form_user_label">
								<label>Votre genre :</label>
								<select name="gender">
									<option <?=$genderM?> value="male"><?=constant('MALE')?></option>
									<option <?=$genderF?> value="female"><?=constant('FEMALE')?></option>
									<option <?=$genderU?> value="nospec"><?=constant('NO_SPEC')?></option>
								</select>
							</div>
						</div>
					</div>
					<div class="flex-grid">
						<div class="d-col-12">
							<div class="form_user_label">
								<label>Votre Bio</label>
								<textarea name="info_text" class="bel_cms_textarea_simple"><?=$_SESSION['USER']->profils->info_text?></textarea>
							</div>
						</div>
					</div>
					<div class="flex-grid">
						<div class="d-col-12">
							<button type="submit" class="belcms_btn"><?=constant('CONFIRM')?></button>
						</div>
					</div>
					<p>* l'email renseigné ne sera jamais publié, il restera privé</p>
				</form>
			</div>
		</div>
	</div>
</section>
<?php
endif;