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
	            $pattern = '/(gif|jpg|png)$/i'; //extension d'image accepter
	            $matche = preg_match($pattern, $fichier);
	            if ($matche) {
	                $list[] = $fichier;
	            }
	        }
	    }
	}
?>
<section id="section_user">
	<div class="flex-wrapper">
		<div class="flex-grid">
			<div class="d-col-4 t-col-4 m-col-12">
				<?php include 'nav.php'; ?>
			</div>
			<div class="d-col-8 t-col-8 m-col-12">
				<p>Avatar actuel</p>
				<div id="user_avatar">
					<img src="<?=$_SESSION['USER']->profils->avatar;?>">
				</div>
				<div id="user_save_avatar">
					<ul>
						<?php
						foreach ($list as $k => $v):
							$alt = 'uploads/users/'.$_SESSION['USER']->user->hash_key.'/'.$v;
						?>
						<li>
							<div>
								<img src="<?=$alt;?>" alt="">
							</div>
							<div>
								<a class="user_add_avatar" href="User/AddAvatar?avatar=<?=$alt;?>&select=select"><i class="fa-regular fa-eye"></i>  Ajouter comme avatar</a>
								<a class="user_del_avatar" href="User/addAvatar?avatar=<?=$alt;?>&select=delete"><i class="fa-solid fa-eye-slash"></i>  Supprimer</a>
							</div>
						</li>
						<?php
						endforeach;
						?>
					</ul>
				</div>
				<form action="user/newavatar" method="post" enctype="multipart/form-data">
					<input name="avatar" id="inputFile" type="file">
					<button type="submit" class="belcms_btn belcms_btn_blue"><?=constant('ADD');?></button>
				</form>
			</div>
		</div>
	</div>
</section>
<?php
endif;