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

use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<section id="section_gallery">
    <h2><?=constant('GALLERY');?></h2>
    <div id="section_opt">[ <a href="Gallery">Index</a> ]</div>
    <ul>
        <li id="section_gallery_title">
            <span class="section_gallery_title_img">Images :</span>
            <span class="section_gallery_title_name">Nom :</span>
            <span class="section_gallery_title_desc">Description :</span>
            <span class="section_gallery_title_date">Date :</span>
            <span class="section_gallery_title_vote">Vote :</span>
        </li>
        <?php
        foreach ($data as $v):
        ?>
        <li id="section_gallery_content">
            <span class="section_gallery_title_img"><a data="#img_<?=$v->id;?>" href="<?=$v->image;?>" class="glightbox"><img src="<?=$v->image;?>"><div id="img_<?=$v->id;?>" class="section_gallery_title_bg">Ouvrir</div></a></span>
            <span class="section_gallery_title_name"><h3><?=$v->name;?></h3></span>
            <span class="section_gallery_title_desc"><?=$v->description;?></span>
            <span class="section_gallery_title_date"><?=Common::TransformDate($v->date_insert, 'FULL', 'NONE');?><br><?=Common::TransformDate($v->date_insert, 'NONE', 'LONG');?></span>
            <span class="section_gallery_title_vote"><a href="gallery/addvote/<?=$v->id;?>"><i class="fa-regular fa-thumbs-up"></i></a><br>
            <span>+ <?=$v->vote;?> Vote</span></span>
        </span>
        </li>
        <?php
        endforeach;
        ?>
    </ul>
</section>