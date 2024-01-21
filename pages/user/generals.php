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
	$gravatar = $_SESSION['USER']->profils->gravatar == '1' ? 'checked' : '';
	$profils  = $_SESSION['USER']->profils->profils  == '1' ? 'checked' : '';
?>
<section id="section_user">
	<div class="flex-wrapper">
		<div class="flex-grid">
			<div class="d-col-4 t-col-4 m-col-12">
				<?php include 'nav.php'; ?>
			</div>
			<div class="d-col-8 t-col-8 m-col-12">
				<form id="form_user_settings" action="User/sendGen" method="post">
					<p class="form_user_settings_p">
						<input <?=$gravatar;?> type="checkbox" name="gravatar" value="on" id="gravatar">
						<label for="gravatar"><span class="ui"></span><i class="label_i">Utiliser Gravatar</i></label>
					</p>
					<p class="form_user_settings_p">
						<input <?=$profils;?> type="checkbox" id="profils" name="profils" value="on">
						<label for="profils"><span class="ui"></span><i class="label_i">Qui peut voir votre profil, Membres seulement ?</i></label>
					</p>
					<p>
						<button type="submit" class="belcms_btn belcms_btn_blue"><?=constant('MODIFY');?></button>
					</p>
				</form>
            </div>
        </div>
    </div>
</section>
<?php
endif;