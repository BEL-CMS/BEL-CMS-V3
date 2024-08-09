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

use BelCMS\Core\Notification;
use BelCMS\User\User;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

if (User::isLogged() === true):
?>
<section id="section_user">
	<?php require 'menu.php'; ?>
	<div id="section_user_profil" class="full">
		<h2>Historique des sessions</h2>
        <?php
        foreach ($user as $key => $v):
        ?>
        <div class="section_user_profil_form_row">
            <div class="divTableCell"><?=Common::TransformDate($v->visitor_date, 'MEDIUM', 'MEDIUM');?></div>
            <div class="divTableCell"><?=$v->visitor_ip;?></div>
            <div class="divTableCell"><?=$v->visitor_refferer;?></div>
        </div>
        <?php
        endforeach;
        ?>
    </div>
</section>
<?php
endif;
?>