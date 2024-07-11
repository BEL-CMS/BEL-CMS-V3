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

use BelCMS\Core\Interaction;
use BelCMS\Core\Notification;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<section id="search">
    <h2><?=constant('SEARCH');?><a href="search" title="Back" class="belcms_tooltip_bottom" data="<?=constant('BACK');?>"><i class="fa-regular fa-circle-left"></i></a></h2>
    <ul id="search_letter">
    <?php
    foreach (array_merge(range('A', 'Z')) as $element):
        echo '<li><a href="Search/search/'.$element.'">'.$element.'</a></li>'; 
    endforeach;
    ?>
    </ul>  
    <ul id="search_ul">
    <?php
    if (empty($data)) {
        Notification::infos(constant('NO_DATA'), constant('SEARCH'));
    }
    if ($read[0] == 'members') {
        foreach ($data as $v):
        ?>
            <li><a href="Members/profil/<?=$v->username;?>"><?=$v->{$read[1]};?></a></li>
        <?php
        endforeach;
    } else if ($read[0] == 'news') {
        foreach ($data as $v):
            ?>
                <li><a href="News/readmore/<?=$v->rewrite_name;?>/<?=$v->id;?>"><?=$v->{$read[1]};?></a></li>
            <?php
        endforeach;
    } else if ($read[0] == 'articles') {
        foreach ($data as $v):
            ?>
                <li><a href="Articles/read/<?=$v->id;?>/legal/<?=$v->name;?>"><?=$v->{$read[1]};?></a></li>
            <?php
        endforeach;
    } else if ($read[0] == 'downloads') {
        foreach ($data as $v):
            ?>
                <li><a href="Downloads/detail/<?=$v->id;?>/<?=$v->name;?>"><?=$v->{$read[1]};?></a></li>
            <?php
        endforeach;   
    } else if ($read[0] == 'guestbook') {
        foreach ($data as $v):
            ?>
                <li><a href="GuestBook"><?=$v->{$read[1]};?></a></li>
            <?php
        endforeach;   
    } else if ($read[0] == 'gallery') {
        foreach ($data as $v):
            ?>
                <li><a href="gallery/Detail/<?=$v->id;?>"><?=$v->{$read[1]};?></a></li>
            <?php
        endforeach;   
    } else if ($read[0] == 'links') {
        foreach ($data as $v):
            ?>
                <li><a href="Links/View/<?=$v->id;?>"><?=$v->{$read[1]};?></a></li>
            <?php
        endforeach;   
    } else if ($read[0] == 'market') {
        foreach ($data as $v):
            ?>
                <li><a href="Market/Buy/<?=$v->id;?>"><?=$v->{$read[1]};?></a></li>
            <?php
        endforeach;   
    }
    ?>
    </ul>
</section>