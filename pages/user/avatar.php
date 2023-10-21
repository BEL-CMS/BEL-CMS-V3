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
	$list = array();
	$path = "uploads/users/".$user->hash_key."/";
	if($dossier = opendir($path))
	{
	    while(($fichier = readdir($dossier)))
	    {

	        if($fichier != '.' && $fichier != '..' && $fichier != 'index.php')
	        {
	            $pattern = '/(gif|jpg|png)$/i'; //extension d'image accepter

	            $matche = preg_match($pattern, $fichier);
	            if ($matche)
	            {
	                $list[] = $fichier;
	            }

	        }
	    }

	}
	require_once 'nav.php';
?>
	<div id="belcms_section_user_avatar">
		<div id="belcms_section_user_avatar_left">
			<div class="belcms_card">
				<div class="belcms_title">Avatar actuel</div>
				<div id="belcms_section_user_main_right_avatar">
					<img src="<?=$user->avatar?>">
					<hr>
					<div class="belcms_title">Avatar actuel</div>
					<form action="user/newavatar" method="post" enctype="multipart/form-data">
						<div class="setting image_picker">
							<div class="settings_wrap">
								<br>
								<label class="drop_target">
									<div class="image_preview"></div>
									<input name="avatar" id="inputFile" type="file">
								</label>
							</div>
						</div>
						<hr>
						<button type="submit" class="belcms_btn belcms_btn_blue">Ajouter</button>
					</form>
				</div>
			</div>
		</div>
		<div id="belcms_section_user_avatar_right">
			<div class="belcms_card">
				<div class="belcms_title">Avatar sauvegarder</div>
				<div id="belcms_section_user_main_right_avatar">
					<form id="avatarSubmit" method="post" action="user/avatarsubmit">
						<ul id="bel_cms_user_ul_avatar">
							<?php
							foreach ($list as $k => $v):
								$alt = 'uploads/users/'.$user->hash_key.'/'.$v;
							?>
							<li>
								<label for="sel_avatar_<?=$k?>">
								<a href="#<?=$v?>" class="bel_cms_jquery_avatar_sel" data-id="<?=$k?>">
									<input class="select_avatar" id="sel_avatar_<?=$k?>" type="radio" name="avatar" value="<?=$alt?>">
									<img width="100" height="100" class="bel_cms_jquery_avatar_sel" src="<?=$alt?>" alt="<?=$alt?>">
								</a>
								</label>
							</li>
							<?php
							endforeach;
							?>
						</ul>
						<hr>
						<input id="selectavatar" type="hidden" name="select" value="select">
						<button type="submit" class="belcms_btn belcms_btn_blue">Enregistrer</button>
						<button id="delavatar" type="submit" class="belcms_btn belcms_bg_red">Supprimer</button>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php
endif;