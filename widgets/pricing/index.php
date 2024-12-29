<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.1.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Core\Interaction;
use BelCMS\Core\Notification;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<div id="belcms_widgets_pricing">
    <?php
    foreach ($plan as $key => $value):
        $per = defined(strtoupper($value['header']->per)) ? constant($value['header']->per) : $value['header']->per;
    ?>
    <div class="belcms_widgets_pricing_box">
        <div class="belcms_widgets_pricing_header">
            <h1><?=$value['header']->name;?></h1>
            <h3><strong>Pour <?=number_format($value['header']->price, 2);?> €</strong> / <?=$per;?></h3>
        </div>
        <div class="belcms_widgets_pricing_content">
            <ul>
                <?php
                foreach ($value['listing'] as $key => $l):
                    if (!empty($l)):
                    ?>
                        <li><?=$l;?></li>
                    <?php
                    endif;
                endforeach;
                ?>
            </ul>
            <?php
            if (User::isLogged() == true):
            ?>
            <a class="belcms_widgets_pricing_link" href="pricing/method/<?=$value['header']->id;?>" title="Plan <?=$value['header']->name;?>">Choisir ce plan</a>
            <?php
            else:
            Notification::warning('Vous devez être logué', 'plan');
            endif;
            ?>
        </div>
    </div>
    <?php
    endforeach;
    ?>
</div>