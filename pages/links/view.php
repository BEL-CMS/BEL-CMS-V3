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

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<a id="main_menu" href="Links"><i class="fa-solid fa-arrow-rotate-left"></i>&nbsp;Retourné à la page principale</a>
<div id="links_view">
    <h2><?=$data->name;?></h2>
    <div id="link_desc"><?=$data->description;?></div>
    <div class="link_infos">
        <span><?=Common::TransformDate($data->date_insert, 'FULL', 'LONG');?></span><span><?=constant('ADD_THE');?></span>
    </div>
    <div class="link_infos">
        <span><?=$data->view;?></span><span><?=constant('VISIT');?></span>
    </div>
    <div class="link_infos">
        <span><?=$data->click;?></span><span><?=constant('CLICK');?></span>
    </div>
</div>
<div id="link_click"><a class="belcms_btn belcms_bg_grey" href="Links/Exit/<?=$data->id;?>" title=""><?=constant('VISIT_THIS_SITE');?></a></div>