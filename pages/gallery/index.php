<?php
use BelCMS\Core\Notification;
use BelCMS\Requires\Common;
/**
 * Bel-CMS [Content management system]
 * @version 3.0.7 [PHP8.3]
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
$countCat = count($cat);
?>
<section id="section_gallery">
    <h2><?=constant('GALLERY');?></h2>
    <div id="section_opt">[ <a href="Gallery">Index</a> | <a href="Gallery/New">Nouveaux</a> | <a href="Gallery/popular">Populaire</a> | <a href="Gallery/Propose">Proposé</a> ]</div>
    <?php
    if ($countCat == 0):
        Notification::warning(constant('NO_IMAGES_IN_DATABASE'), constant('GALLERY'));
    endif;
    ?>
    <div id="belcms_main_gallery">
        <?php
        foreach ($cat as $data):
            $img = empty($data->banner) ? '/assets/img/dossier.png' : $data->banner;
            $color = empty($data->color) ? '#205081' : $data->color;
        ?>
        <div class="belcms_main_gallery_box">
            <div class="belcms_main_gallery_bg" style="background: #fbfbfb;">
                <div style="background: <?=$color;?>;">
                    <a href="Gallery/subcat/<?=$data->id;?>" title="<?=$data->name;?>">
                        <img class="belcms_main_gallery_img" src="<?=$img;?>">
                    </a>
                </div>
                <a href="Gallery/subcat/<?=$data->id;?>" title="lien - <?=$data->name;?>"><?=$data->name;?></a>
            </div>
        </div>
        <?php
        endforeach;
        ?>
    </div>
    <div id="section_gallery_footer"><i>( Il y a <?=$count;?> Images & <?=$countCat;?> Catégories dans la base de données )</i></div>
    <?php
	echo $pagination;
	?>
</section>