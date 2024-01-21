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

use BelCMS\Core\Notification;
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
                <?php
                if (!empty($user)):
                ?>
                <div id="section_user_table" class="divTable belcms_table">
                    <div class="divTableHeading">
                        <div class="divTableRow">
                            <div class="divTableHead">Adresse IP</div>
                            <div class="divTableHead">Date</div>
                            <div class="divTableHead">Site référent</div>
                        </div>
                    </div>
                    <div class="divTableBody">
                        <?php
                        foreach ($user as $key => $v):
                        ?>
                        <div class="divTableRow">
                            <div class="divTableCell"><?=$v->visitor_ip;?></div>
                            <div class="divTableCell"><?=Common::TransformDate($v->visitor_date, 'MEDIUM', 'MEDIUM');?></div>
                            <div class="divTableCell"><?=$v->visitor_refferer;?></div>
                        </div>
                        <?php
                        endforeach;
                        ?>
                    </div>
                </div>
                <?php
                else:
                    Notification::infos('Aucune donnée');
                endif;
                ?>
            </div>
        </div>
    </div>
</section>
<?php
endif;
?>