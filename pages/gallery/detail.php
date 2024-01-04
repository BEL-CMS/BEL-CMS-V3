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
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
$user = User::ifUserExist($img->uploader) ? User::getInfosUserAll($img->uploader)->user->username : constant('MEMBER_DELETE');
$date = Common::TransformDate($img->date_insert, 'FULL', 'NONE');
$cat  = !empty($img->cat) ? '<li><span>Catégorie</span><span>'.$img->cat.'</span></li>' : '';
?>
<section id="section_gallery">
<?php
    if (!empty($category['cat'])):
    ?>
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
    endif;
    ?>
    <figure id="gallery_img_left">
        <a data="Voir en popup" href="<?=$img->image;?>" class="belcms_tooltip_top image-popup">
            <img src="<?=$img->image;?>">
        </a>
    </figure>
    <figcaption id="gallery_img_right">
        <ul>
            <li><span>Titre</span><span><?=$img->name;?></span>
            <li><span>Date de publication</span><span><?=$date;?></span>
            <li><span>Uploader</span><span><?=$user;?></span>
            <?=$cat;?>
            <li><input  data="Clic pour copier, l'adresse de l'image" class="belcms_tooltip_top" id="gallery_img_input" type="text" readonly value="<?=$_SESSION['CONFIG_CMS']['HOST'].$img->image;?>">
        </ul>
    </figcaption>
</section>