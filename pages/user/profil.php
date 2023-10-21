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
?>
<section id="bel_cms_page_user">


	<ul class="nav nav-tabs" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
		</li>
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Profils</a>
			<div class="dropdown-menu">
				<a class="dropdown-item" href="#dropdown-avatar" role="tab" id="dropdown-avatar-tab" data-toggle="tab" aria-controls="dropdownAvatar"><?=MY_AVATAR?></a>
				<a class="dropdown-item" href="#dropdown-profil" role="tab" id="dropdown-profil-tab" data-toggle="tab" aria-controls="dropdownProfil"><?=EDIT_PROFIL?></a>

				<a class="dropdown-item" href="#dropdown-social" role="tab" id="dropdown-social-tab" data-toggle="tab" aria-controls="dropdownAvatar"><?=EDIT_PROFIL_SOCIAL?></a>
				<a class="dropdown-item" href="#dropdown-mail" role="tab" id="dropdown-mail-tab" data-toggle="tab" aria-controls="dropdownAvatar"><?=EDIT_MAIL_PASS?></a>
			</div>
		</li>
		<li class="nav-item">
			<a class="logout nav-link" data-toggle="tooltip" title="<?=SIGN_OUT?>" href="User/Logout" alt="<?=SIGN_OUT?>"><i class="fas fa-sign-out-alt"></i></a>
		</li>
	</ul>

	<div id="clothing-nav-content" class="tab-content">

		<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
			<div class="card">
				<div class="card-header"><?=ABOUT?><a class="logout" href="User/Logout" alt="<?=SIGN_OUT?>"><i class="fas fa-sign-out-alt"></i></a></div>
				<div class="card-body">
					<div id="bel_cms_page_user_main_avatar">
						<img src="<?=$user->avatar?>" alt="avatar_<?= $user->username?>">
					</div>
					<div id="bel_cms_page_user_main_infos">
						<ul class="list-group list-group-flush">
							<li class="list-group-item"><span><?=PSEUDO?></span><span><?=$user->username?></span></li>
							<li class="list-group-item"><span><?=GENDER?></span><span><?=$user->gender?></span></li>
							<li class="list-group-item"><span><?=BIRTHDAY?></span><span><?=Common::TransformDate($user->birthday, 'LONG', 'NONE')?></span></li>
							<li class="list-group-item"><span><?=LOCATION?></span><span><?=$user->country?></span></li>
							<li class="list-group-item"><span><?=DATE_INSCRIPTION?></span><span><?=Common::TransformDate($user->date_registration, 'LONG', 'LONG')?></span></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane fade" id="dropdown-avatar" aria-labelledby="dropdown-avatar-tab">
			<div class="card">
				<div class="card-header"><?=MY_AVATAR?></div>
				<div class="card-body">
					<ul id="bel_cms_user_ul_avatar">
						<?php
						foreach ($user->list_avatar as $v):
							$alt = str_replace('uploads/users/'.$user->hash_key.'/', '', $v);
						?>
						<li>
							<a href="#<?=$v?>" class="bel_cms_jquery_avatar_sel">
								<img width="100" height="100" src="<?=$v?>" alt="<?=$alt?>">
								<span>Selectionner</span>
							</a>
						</li>
						<?php
						endforeach;
						?>
					</ul>
				</div>
				<div class="card-footer text-muted">
					<form action="User/Send" method="post" enctype="multipart/form-data">
						<div class="form-group">
							<div class="custom-file">
								<input name="avatar" type="file" id="input_avatar" lang="fr" required="required">
								<label class="custom-file-label" for="input_avatar">Depuis mon ordinateur </label>
							</div>
						</div>
						<input type="hidden" name="send" value="sendavatar">
						<button type="submit" class="btn btn-primary"><?=constant('ADD_YOUR_AVATAR')?></button>
					</form>
				</div>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane fade" id="dropdown-profil" aria-labelledby="dropdown-profil-tab">
			<?php
			$user->gender = mb_strtoupper($user->gender);
			$genderM = strtoupper($user->gender) == strtoupper(constant('MALE')) ? 'checked="checked"' : '';
			$genderF = strtoupper($user->gender) == strtoupper(constant('FEMALE')) ? 'checked="checked"' : '';
			$genderU = strtoupper($user->gender) == strtoupper(constant('UNISEXUAL')) ? 'checked="checked"' : '';
			$user->info_text = $user->info_text == UNKNOWN ? '' : $user->info_text;
			$user->birthday = Common::DatetimeSQL($user->birthday, false, 'Y-m-d');
			?>
			<div class="card">
				<form action="User/Send" method="post" enctype="multipart/form-data">
					<div class="card-header"><?=EDIT_PROFIL?></div>
					<div class="card-body">
						<div id="edit_profil_infos">
							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="fa fa-user"></i></div>
								</div>
								<input class="form-control" name="username" type="text" placeholder="<?=constant('ENTER_NAME_PSEUDO')?>" required="required" value="<?=$user->username?>" disabled="disabled" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$">
							</div>

							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="fa fa-birthday-cake"></i></div>
								</div>
								<input class="form-control" name="birthday" type="date" value="<?=$user->birthday?>" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}">
							</div>

							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="fa fa-link"></i></div>
								</div>
								<input class="form-control" name="websites" type="text" placeholder="Votre Site Web" value="<?=$user->websites?>" pattern="https?://.+">
							</div>

							<div class="form-group margin-bottom-20">
								<label style="display: block;">Votre sexe :</label>
								<input type="radio" <?=$genderM?> name="gender" value="male">&nbsp;<i class="fa fa-male"></i>&nbsp;<?=MALE?>&nbsp;&nbsp;
								<input type="radio" <?=$genderF?> name="gender" value="female">&nbsp;<i class="fa fa-female"></i>&nbsp;<?=FEMALE?>&nbsp;&nbsp;
								<input type="radio" <?=$genderU?> name="gender" value="unisexual">&nbsp;<?=NO_SPEC?>
							</div>


							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="fa fa-map-signs"></i></div>
								</div>
								<select name="country" class="form-control">
									<?php
									foreach (Common::contryList() as $k => $v):
										$selected = $user->country == $v ? 'selected="selected"' : '';
										echo '<option '.$selected.' value="'.$v.'">'.$v.'</option>';
									endforeach;
									?>
								</select>
							</div>

							<div class="form-group">
								<label>Description :</label>
								<textarea class="tinimce" name="info_text" placeholder="Votre description..."><?php echo $user->info_text; ?></textarea>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<input type="hidden" name="send" value="editprofile">
						<button type="submit" class="btn btn-primary"><?=constant('UPDATE_NOW')?></button>
					</div>
				</form>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane fade" id="dropdown-social" aria-labelledby="dropdown-social-tab">
			<div class="card">
				<form action="User/Send" method="post" class="bel_cms">
					<div class="card-header"><?=EDIT_PROFIL_SOCIAL?></div>
					<div class="card-body">
						<div id="edit_profil_social">
							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="fab fa-facebook-f"></i></div>
								</div>
								<input class="form-control" name="facebook" type="text" placeholder="<?=constant('ENTER_YOUR');?> facebook" value="<?=$user->facebook?>" pattern="^[a-z\d\.]{5,}$">
							</div>

							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="fab fa-twitter"></i></div>
								</div>
								<input class="form-control" name="twitter" type="text" placeholder="<?=constant('ENTER_YOUR');?> twitter" value="<?=$user->twitter?>" pattern="^[A-Za-z0-9_]{1,15}$">
							</div>

							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="fab fa-google"></i></div>
								</div>
								<input class="form-control" name="googleplus" type="text" placeholder="<?=constant('ENTER_YOUR');?> gplus" value="<?=$user->googleplus?>">
							</div>

							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="fab fa-pinterest-p"></i></div>
								</div>
								<input class="form-control" name="pinterest" type="text" placeholder="<?=constant('ENTER_YOUR');?> pinterest" value="<?=$user->pinterest?>">
							</div>

							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="fab fa-linkedin-in"></i></div>
								</div>
								<input class="form-control" name="linkedin" type="text" placeholder="<?=constant('ENTER_YOUR');?> linkedin" value="<?=$user->linkedin?>">
							</div>
						</div>
					</div>
					<div class="card-footer">
						<input type="hidden" name="send" value="editsocial">
						<button type="submit" class="btn btn-primary"><?=constant('UPDATE_NOW')?></button>
					</div>
				</form>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane fade" id="dropdown-mail" aria-labelledby="dropdown-mail-tab">
			<div class="card">
				<form action="User/Send" method="post">
					<div class="card-header"><?=EDIT_MAIL_PASS?></div>
					<div class="card-body">
						<div id="edit_mail_pass">
							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="fa fa-envelope"></i></div>
								</div>
								<input class="form-control" name="email" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('PRIVATE')?> <?=constant('MAIL')?>" type="email" value="<?=$user->email?>" required="required">
							</div>

							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="far fa-envelope"></i></div>
								</div>
								<input class="form-control" name="public_mail" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('MAIL')?> <?=constant('PUBLIC')?>" type="email" value="<?=$user->public_mail?>">
							</div>

							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="fa fa-lock"></i></div>
								</div>
								<input class="form-control" name="newpassword" type="password" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('NEW_PASSWORD')?>" value="" pattern="[a-zA-ZÀ-ÿ#'/*-&@$%]{6,16}" autocomplete="off">
							</div>

							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="fa fa-unlock"></i></div>
								</div>
								<input class="form-control" name="password" type="password" placeholder="<?=constant('ENTER_YOUR');?> <?=constant('ACTUAL_PASSWORD')?>" value="" pattern="[a-zA-ZÀ-ÿ#'/*-&@$%]{6,16}" autocomplete="off">
							</div>
						</div>
					</div>
					<div class="card-footer">
						<input type="hidden" name="send" value="mailpassword">
						<button type="submit" class="btn btn-primary"><?=constant('UPDATE_NOW')?></button>
					</div>
				</form>
			</div>
		</div>
	</div>

</section>
<?php
endif;