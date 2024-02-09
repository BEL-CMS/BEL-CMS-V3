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

namespace BELCMS\Pages\Controller;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<ul id="section_links_ul">
    <?php
    $i = 0;
    foreach ($data as $value):
        $i = $i + 1;
        $value->countLinks = $value->countLinks == 0 ? '' : '('.$value->countLinks.')';
    ?>
    <li>
        <a style="color:<?=$value->color;?>" href="Links/getLinksCat/<?=$value->id;?>"><i class="fa-solid fa-caret-right"></i> <?=$value->name;?><i><?=$value->countLinks;?></i></a>
        <span><?=$value->description;?></span>
    </li>
    <?php
    endforeach;
    ?>
</ul>