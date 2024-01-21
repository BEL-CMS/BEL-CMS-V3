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

use BELCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
if (User::isLogged() === true):
    if (is_file(ROOT.DS.$_SESSION['USER']->profils->hight_avatar)) {
        $avatar = $_SESSION['USER']->profils->hight_avatar;
    } else {
        $avatar = 'assets/img/bg_default.png';
    }
?>
<section id="section_user">
	<div class="flex-wrapper">
		<div class="flex-grid">
			<div class="d-col-4 t-col-4 m-col-12">
				<?php include 'nav.php'; ?>
			</div>
			<div class="d-col-8 t-col-8 m-col-12">
				<h2 class="avatar_title">Background actuel</h2>
				<div id="user_avatar_bg">
					<img src="<?=$avatar;?>">
				</div>
                <form id="form_hight_avatar" action="user/NewBg" method="post" enctype="multipart/form-data">
                    <input name="hight_avatar" id="inputFile" type="file">
                    <button type="submit" class="belcms_btn belcms_btn_blue"><?=constant('ADD');?></button>
                </form>
            </div>
        </div>
    </div>
</section>
<?php
endif;