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

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<section id="search">
    <h2><?=constant('SEARCH');?></h2>
    <ul id="search_letter">
    <?php
    foreach (array_merge(range('A', 'Z')) as $element):
        echo '<li><a href="Search/search/'.$element.'">'.$element.'</a></li>'; 
    endforeach;
    ?>
    </ul>
    <form id="form_Search" method="post" action="Search/options">
        <div class="form_row">
            <label><?=constant('SEARCH');?></label>
            <input type="search" value="" name="search" required onkeydown="if(event.keyCode==32) return false;" minlength="3" maxlength="32">
        </div>
        <div class="form_row">
            <select name="cat" id="cat" required>
                <option value="">--<?=constant('CHOSSES_AN_OPT');?>--</option>
                <option value="news"><?=constant('NEWS');?></option>
                <option value="articles"><?=constant('ARTICLE');?></option>
                <option value="downloads"><?=constant('DOWNLOADS');?></option>
                <option value="members"><?=constant('USER');?></option>
                <option value="guestbook"><?=constant('GUESTBOOK');?></option>
                <option value="gallery"><?=constant('GALLERY');?></option>
                <option value="links"><?=constant('LINKS');?></option>
                <option value="market"><?=constant('MARKET');?></option>
            </select>
        </div>
        <div class="form_row">
            <input type="submit" value="Rechercher" class="belcms_btn belcms_bg_grey">
        </div>
    </form>
</section>