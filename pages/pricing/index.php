<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.8 [PHP8.3]
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
debug($plan, false);
?>
<section id="belcms_pricing">
    <h1>Tarification simple pour tous les utilisateurs :</h1>
    <div id="belcms_pricing_plan">
        <?php
        $i = 0;
        foreach ($plan as $v):
            $i = $i +1;
        ?>
        <div class="belcms_pricing_col">
            <div>
                <h3><span><?=$i;?>.</span> <?=$v->name;?></h3>
                <div class="belcms_pricing_item">
                    <span class="light"><i class="fa-solid fa-euro-sign"></i></span>
                    <span><i class="strong"><?=$v->price;?></i> <i class="light">/</i> Par <?=$v->per;?></span>
                </div>
                <div class="belcms_pricing_description">
                    <p><?=$v->description;?></p>
                </div>
                <?php
                if ($v->listing != false):
                ?>
                <ul class="belcms_pricing_listing">
                    <?php
                    if (!empty($v->listing->cat_1)):
                        if ($v->listing->actif_1 == true) {
                            $cat_1 = '<i class="fa-solid fa-check"></i>';
                            $color_1 = 'belcms_pricing_listing_green';
                        } else {
                            $cat_1 = '<i class="fa-solid fa-ban"></i>';
                            $color_1 = 'belcms_pricing_listing_red';
                        }
                    ?>
                    <li>
                        <span class="<?=$color_1;?>"><?=$cat_1;?></span>
                        <span><?=$v->listing->cat_1;?></span>
                    </li>
                    <?php
                    endif;
                    if (!empty($v->listing->cat_2)):
                        if ($v->listing->actif_2 == true) {
                            $cat_2   = '<i class="fa-solid fa-check"></i>';
                            $color_2 = 'belcms_pricing_listing_green';
                        } else {
                            $cat_2 = '<i class="fa-solid fa-ban"></i>';
                            $color_2 = 'belcms_pricing_listing_red';
                        }
                    ?>
                    <li>
                        <span class="<?=$color_2;?>"><?=$cat_2;?></span>
                        <span><?=$v->listing->cat_2;?></span>
                    </li>
                    <?php
                    endif;
                    if (!empty($v->listing->cat_3)):
                        if ($v->listing->actif_3 == true) {
                            $cat_3   = '<i class="fa-solid fa-check"></i>';
                            $color_3 = 'belcms_pricing_listing_green';
                        } else {
                            $cat_3   = '<i class="fa-solid fa-ban"></i>';
                            $color_3 = 'belcms_pricing_listing_red';
                        }
                    ?>
                    <li>
                        <span class="<?=$color_3;?>"><?=$cat_3;?></span>
                        <span><?=$v->listing->cat_3;?></span>
                    </li>
                    <?php
                    endif;
                    if (!empty($v->listing->cat_4)):
                        if ($v->listing->actif_4 == true) {
                            $cat_4   = '<i class="fa-solid fa-check"></i>';
                            $color_4 = 'belcms_pricing_listing_green';
                        } else {
                            $cat_4   = '<i class="fa-solid fa-ban"></i>';
                            $color_4 = 'belcms_pricing_listing_red';
                        }
                    ?>
                    <li>
                        <span class="<?=$color_4;?>"><?=$cat_4;?></span>
                        <span><?=$v->listing->cat_4;?></span>
                    </li>
                    <?php
                    endif;
                    if (!empty($v->listing->cat_5)):
                        if ($v->listing->actif_5 == true) {
                            $cat_5   = '<i class="fa-solid fa-check"></i>';
                            $color_5 = 'belcms_pricing_listing_green';
                        } else {
                            $cat_5   = '<i class="fa-solid fa-ban"></i>';
                            $color_5 = 'belcms_pricing_listing_red';
                        }
                    ?>
                    <li>
                        <span class="<?=$color_5;?>"><?=$cat_5;?></span>
                        <span><?=$v->listing->cat_5;?></span>
                    </li>
                    <?php
                    endif;
                    ?>
                </ul>
                <?php
                endif;
                ?>
                <form action="pricing/choise">
                    <input type="hidden" value="<?=$v->id;?>">
                    <input type="submit" value="Choisissez ce plan">
                </form>
            </div>
        </div>
        <?php
        endforeach;
        ?>
    </div>
</section>
