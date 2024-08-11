<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.9 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Core\Notification;
use BelCMS\Requires\Common;
use BELCMS\User\User;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
if (User::isLogged() === true):
?>
<section id="belcms_section_mails">
    <div id="belcms_section_mails_list">
        <?php include 'menu.php'; ?>
    </div>
    <div id="belcms_section_list_mails">
        <?php
        if (count($mails) != 0):
        foreach ($mails as $key => $value):
            $userReceive = User::getInfosUserAll($value->author_send);
            $userReceive = $userReceive->user->username;
            $date = Common::TransformDate($value->last_msg->date_send, 'MEDIUM', 'MEDIUM');
        ?>
        <a href="#" class="belcms_section_listing_mails">
            <span><input type="checkbox"></span>
            <span><img src="/assets/img/default_avatar.jpg"></span>
            <span><b><?=$userReceive;?></b> - <?=$value->subject;?></span>
            <span><?=$date;?></span>
        </a>
        <?php
        endforeach;
        else:
        echo '<div id="mails_notif">';
            Notification::infos(constant('NO_TRASH_MESSAGE'), constant('MAILBOX'));
        echo '</div>';
        endif;
        ?>
    </div>
</section>
<?php
endif;