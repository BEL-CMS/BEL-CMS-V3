<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.6 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Core\Notification;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<section id="search">
    <h2><?=constant('LETTER');?>&nbsp;:&nbsp;<?=$letter;?><a href="search" title="Back" class="belcms_tooltip_bottom" data="<?=constant('BACK');?>"><i class="fa-regular fa-circle-left"></i></a></h2>
    <div id="search_list">
        <?php
        if (empty($data)):
            Notification::warning(constant('NO_DATA'), constant('LETTER'));
        else:
        ?>
            <table class="DataTableBelCMS">
        <?php
            foreach ($data as $v):
                echo '<tr><td><a href="Search/Content/'.$v->id.'/'.$v->title.'" title="'.$v->title.'">'.$v->title.'<td><tr>';
            endforeach;
        endif;
        ?>
        </table>
    </div>
</section>
<?php
echo $pagination;
?>
<script src="/assets/js/jQuery/jquery-3.7.1.min.js"></script>
<script src="/assets/plugins/DataTables-1.13.06/datatables.min.js"></script>