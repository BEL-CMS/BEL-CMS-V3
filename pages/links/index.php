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

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
$i = 0;
?>
<div id="loader"></div>
<section id="section_links">
    <h2>Liens Web</h2>
    <div class="section_links">[ <a class="jquery" href="Links/One?echo">Index</a> | <a class="jquery" href="Links/New?echo">Nouveaux</a> | <a class="jquery" href="Links/Popular?echo">Populaires</a> | <a class="jquery" href="Links/Propose?echo">Proposer</a> ]</div>
    <ul id="section_links_ul">
        <?php
        foreach ($data as $value):
            $i = $i + 1;
            $value->countLinks = $value->countLinks == 0 ? '' : '('.$value->countLinks.')';
        ?>
        <li>
            <a class="query_ajax" style="color:<?=$value->color;?>" href="Links/getLinksCat/<?=$value->id;?>"><i class="fa-solid fa-caret-right"></i> <?=$value->name;?><i><?=$value->countLinks;?></i></a>
            <span><?=$value->description;?></span>
        </li>
        <?php
        endforeach;
        ?>
    </ul>
    <div id="section_ajax"></div>
    <div id="section_links_footer"><i>( Il y a <?=$count;?> Liens & <?=$i;?> Catégories dans la base de données )</i></div>
</section>
<?php
