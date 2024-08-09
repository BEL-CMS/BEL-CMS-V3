<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.8 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Requires\Common;
use BELCMS\User\User as UserInfos;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
if (UserInfos::isLogged() === true):
	$list = array();
	$path = "uploads/users/".$_SESSION['USER']->user->hash_key."/";
	if ($dossier = opendir($path)) {
	    while(($fichier = readdir($dossier))) {
	        if ($fichier != '.' && $fichier != '..' && $fichier != 'index.php' && $fichier != 'index.html') {
	            $pattern = '/(gif|jpg|png|jpeg)$/i'; //extension d'image accepter
	            $matche = preg_match($pattern, $fichier);
	            if ($matche) {
	                $list[] = $fichier;
	            }
	        }
	    }
	}
?>
<section id="section_user">
	<?php require 'menu.php'; ?>
	<div id="section_user_profil">
		<h2>Avatar Disponible</h2>
		<div class="section_user_profil_avatar">
			<?php
			foreach ($list as $v):
				$img = 'uploads/users/'.$_SESSION['USER']->user->hash_key.'/'.$v;
			?>
				<div class="section_user_profil_avatar_list">
					<a class="avatar_del" href="User/addAvatar?avatar=<?=$img;?>&select=delete">Supprimer</a>
					<img src="<?=$img;?>">
					<div class="section_user_profil_avatar_list_select"><a href="User/AddAvatar?avatar=<?=$img;?>&select=select">Selectionner</a></div>
				</div>
			<?php
			endforeach;
			?>
		</div>
	</div>
	<div id="section_user_profil_right">
		<h2>Uploadé un Avatar *</h2>
		<form action="user/newavatar" method="post" enctype="multipart/form-data">
			<input name="avatar" id="inputFile" type="file">
			<img id="uploads_logo_avatar" src="assets/img/Upload_logo.png">
			<button type="submit" class="belcms_btn belcms_btn_blue"><?=constant('ADD');?></button>
			<p style="font-size: 11px;"><i style="color:red">*  </i>100px/100px (<?=constant('MAX_UPLOADS');?> <?=Common::ConvertSize(Common::GetMaximumFileUploadSize())?>)</p>
		</form>
	</div>
</section>
<?php
endif;