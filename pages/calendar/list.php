<?php
use BelCMS\Requires\Common;
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
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
?>
<section id="calendar_list">
    <?php
    foreach ($data as $value):
        $img = empty($value->image) ? 'assets/img/no_screen.png' : $value->image;
        $date = $value->start_date == $value->end_date ? Common::TransformDate($value->start_date, 'FULL') : Common::TransformDate($value->end_date, 'FULL', 'NONE').' - ' .Common::TransformDate($value->start_date, 'FULL', 'NONE');
    ?>
    <div class="calendar_list">
        <div class="calendar_list_img">
            <img src="<?=$img;?>">
        </div>
        <div class="calendar_list_infos">
            <h3><?=$value->name;?></h3>
            <span><i class="fa-solid fa-calendar-days"></i>&ensp;<?=$date;?></span>
            <span><i class="fa-solid fa-clock"></i>&ensp;<?=$value->start_time;?> - <?=$value->end_time;?></span>
            <span><i class="fa-solid fa-map-location-dot"></i>&ensp;<?=$value->location;?></span>
            <span class="calendar_list_infos_desc"><?=$value->description;?>
        </div>
    </div>
    <?php
    endforeach;
    ?>
    <?php
    if (!empty($pagination)):
    ?>
        <div class="bel_cms_index_footer">
            <?=$pagination?>
        </div>
    <?php
    endif;
    ?>
</section>