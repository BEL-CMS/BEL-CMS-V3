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
?>
<section id="section_user">
	<div class="flex-wrapper">
		<div class="flex-grid">
			<div class="d-col-4 t-col-4 m-col-12">
				<?php include 'nav.php'; ?>
			</div>
			<div class="d-col-8 t-col-8 m-col-12">
				<form action="user/sendsecurity" method="post" class="belcms_section_user_main_form">
					<div class="form_input_social">
						<p class="form_input_social_label"><span class="mdp_old"><i class="fa-solid fa-lock-open"></i></span>
						<input name="password_old" placeholder="* Entrer votre ancien mot de passe." type="password" value="" autocomplete="off" required="required">
					</div>
					<div class="form_input_social">
						<p class="form_input_social_label"><span class="mdp_new"><i class="fa-solid fa-lock"></i></span>
						<input type="text" name="password_new" rel="gp" data-size="8" data-character-set="a-z,A-Z,0-9,#">
					</div>
					<div class="flex-grid">
						<div class="d-col-6 t-col-6 m-col-6">
							<p class="form_input_social_label"><button class="btn" type="submit">Enregistrer</button></p>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<?php
endif;
