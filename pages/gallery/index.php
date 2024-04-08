<?php
use BelCMS\Core\Notification;
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
if (empty($category['cat']) && empty($img['img'])) {
    Notification::warning(constant('NO_IMAGES_IN_DATABASE'), constant('GALLERY'));
}
?>
<?php
if (!empty($category['cat'])):
?>
<section id="section_gallery">
    <form id="gallery_form" method="get" action="Gallery/Cat/">
        <select id="jQuery_cat">
            <option selected disabled>Choisir une catégorie</option>
            <option value="0">Aucune catégorie</option>
        <?php
        foreach ($category['cat'] as $key => $value):
        ?>
            <option value="<?=$value->id;?>"><?=$value->name;?></option>
        <?php
        endforeach;
        ?>
        </select>
    </form>
    <?php
    if (!empty($img['img'])):
        foreach ($img['img'] as $key => $value):
        ?>
        <div class="gallery">
            <a data="Voir en popup" href="<?=$value->image;?>" class="belcms_tooltip_top image-popup">
                <img src="<?=$value->image;?>">
            </a>
            <div class="gallery_row">
                <span>Titre : </span>
                <span><?=$value->name;?></span>
            </div>
            <div class="gallery_row">
                <span>Publication : </span>
                <span><?=Common::TransformDate($value->date_insert, 'FULL', 'NONE')?></span>
            </div>
            <div class="gallery_row">
                <span>Vu : </span>
                <span><?=$value->view;?></span>
            </div>
            <button class="belcms_tooltip_left belcms_btn belcms_bg_grey" data="Voir plus de détail" onclick="window.location.href='gallery/Detail/<?=$value->id?>'">Voir plus de détail</button>
        </div>
        <?php
        endforeach;
    endif;
    ?>
</section>
<?php
endif;