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
                <?php
                foreach ($data as $v):
                ?>
                <div class="user_notification">
                    <span><?=$v->message;?></span>
                    <span><?=Common::TransformDate($v->date_notif, 'MEDIUM', 'SHORT') ?></span>
                    <i class="fa-solid fa-comment"></i>
                </div>
                <?php
                endforeach;
                ?>
            </div>
        </div>
    </div>
</section>
<?php
endif;
?>