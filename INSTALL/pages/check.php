<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.1.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

$php_true    = checkPhp()    == true ? '<span class="check_green">Le PHP minimum requis est ok.</span>' : '<span class="check_red">PHP 8.x minimum requis</span>';
$checkPDO    = checkPDO()    == true ? '<span class="check_green">la function pdo_mysql est ok.</span>' : '<span class="check_red">function pdo_mysql est requis</span>';
$checkIntl   = checkIntl()   == true ? '<span class="check_green">L\'extension checkIntl est ok.</span' : '<span class="check_red">L\'extension checkIntl est obligatoire</span>';
$checkMysqli = checkMysqli() == true ? '<span class="check_green">la function checkMysqli est ok.</span>' : '<span class="check_red">L\'extension checkMysqli est obligatoire</span>';
$smtp          = BelCMS::getIni('SMTP') == true ? '<span class="check_green">la function SMTP est ok.</span>' : '<span class="check_red">L\'extension SMTP est nécessaire</span>';
$rewrite       = BelCMS::getIni('mod_rewrite') == true ? '<span class="check_green">la function mod_rewrite est ok.</span' : '<span class="check_red">L\'extension mod_rewrite est nécessaire au bon fonctionnement des liens</span>';
$short         = BelCMS::getIni('short_open_tag') == true ? '<span class="check_green">la function pdo_mysql est ok.</span' : '<i style="color:red;" class="fa-regular fa-thumbs-down"></i>';
if (checkPhp() && checkPDO() && checkIntl() && checkMysqli() && BelCMS::getIni('SMTP') && BelCMS::getIni('mod_rewrite') && BelCMS::getIni('short_open_tag')) {
    $check =  true;
} else {
    $check = false;
}
?>
<div id="main_content">
    <div class="main_content">
        <ul id="table_check">
            <li>
                <div><?=$php_true;?></div>
            </li>
            <li>
                <div><?=$checkPDO;?></div>
            </li>
            <li>
                <div><?=$checkIntl;?></div>
            </li>
            <li>
                <div><?=$smtp;?></div>
            </li>
            <li>
                <div><?=$short;?></div>
            </li>
            <li>
                <div><?=$rewrite;?></div>
            </li>
        </ul>
    </div>
    <nav id="menu" aria-label="Page navigation">
        <ul class="pagination justify-content-end">
            <li class="page-item">
                <a class="page-link reload" onclick="location.reload(true); return false;">Rafraichir</a>
            </li>
            <?php 
            if ($check === true):
            ?>
            <li class="page-item">
                <a class="page-link" href="index.php?page=checkfiles">Suivant</a>
            </li>
            <?php
            else:
            ?>
            <li class="page-item">
                <a class="page-link disabled" href="#">Suivant</a>
            </li>
            <?php
            endif;
            ?>
        </ul>
    </nav>
</div>