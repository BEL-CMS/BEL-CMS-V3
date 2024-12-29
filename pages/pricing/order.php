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

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

use BelCMS\Requires\Common;
use BelCMS\User\User;

foreach ($data as $value):
    $verif = $value->verif == 0 ? '<span style="padding:5px;color:#FFF;background:red;">Hors ligne</span>' : '<span style="padding:5px;color:#FFF;background:green;">En ligne</span>';
?>
<table id="belcms_pricing_table">

    <tr>
        <td>Auteur</td>
        <td><?=User::getInfosUserAll($value->author)->user->username;?></td>
    </tr>
    <tr>
        <td>Date de création</td>
        <td><?=Common::TransformDate($value->date_insert, 'FULL', 'MEDIUM');?></td>
    </tr>
    <tr>
        <td>Date de fin</td>
        <td><?=Common::TransformDate($value->date_finish, 'FULL', 'MEDIUM');?></td>
    </tr>
        <td>En ligne</td>
        <td><?=$verif;?></td>
    </tr>
    </tr>
        <td colspan="2"><a class="belcms_btn belcms_bg_grey" href="pricing/Invoice/<?=$value->id_order;?>?echo">Ma facture</a></td>
    </tr>
</table>
<?php
endforeach;
?>
</table>
<br>