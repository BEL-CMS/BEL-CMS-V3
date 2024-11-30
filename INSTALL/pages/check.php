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

$php_true      = checkPhp()    == true ? '<i style="color:green;" class="fa-regular fa-thumbs-up"></i>' : '<i style="color:red;" class="fa-regular fa-thumbs-down"></i>';
$checkPDO      = checkPDO()    == true ? '<i style="color:green;" class="fa-regular fa-thumbs-up"></i>' : '<i style="color:red;" class="fa-regular fa-thumbs-down"></i>';
$checkIntl     = checkIntl()   == true ? '<i style="color:green;" class="fa-regular fa-thumbs-up"></i>' : '<i style="color:red;" class="fa-regular fa-thumbs-down"></i>';
$checkMysqli   = checkMysqli() == true ? '<i style="color:green;" class="fa-regular fa-thumbs-up"></i>' : '<i style="color:red;" class="fa-regular fa-thumbs-down"></i>';
$smtp          = BelCMS::getIni('SMTP') == true ? '<i style="color:green;" class="fa-regular fa-thumbs-up"></i>' : '<i style="color:red;" class="fa-regular fa-thumbs-down"></i>';
$rewrite       = BelCMS::getIni('mod_rewrite') == true ? '<i style="color:green;" class="fa-regular fa-thumbs-up"></i>' : '<i style="color:red;" class="fa-regular fa-thumbs-down"></i>';
$short         = BelCMS::getIni('short_open_tag') == true ? '<i style="color:green;" class="fa-regular fa-thumbs-up"></i>' : '<i style="color:red;" class="fa-regular fa-thumbs-down"></i>';
if (checkPhp() && checkPDO() && checkIntl() && checkMysqli() && BelCMS::getIni('SMTP') && BelCMS::getIni('mod_rewrite') && BelCMS::getIni('short_open_tag')) {
	$check =  true;
} else {
	$check = false;
}
?>
<div id="main_content">
    <h1>Vérification des pré-requis</h1>
    <div class="main_content">
        <ul id="check">
            <li><span>PHP8</span><span><?=$php_true;?></span></li>
			<li><span>PDO</span><span><?=$checkPDO;?></span></li>
			<li><span>checkIntl</span><span><?=$checkIntl;?></span></li>
			<li><span>Mysqli/MariaDB</span><span><?=$checkMysqli;?></span></li>
			<li><span>SMTP Mail</span><span><?=$smtp;?></span></li>
			<li><span>short_open_tag</span><span><?=$short;?></span></li>
			<li><span>mod_rewrite</span><span><?=$rewrite;?></span></li>
        </ul>
    </div>
	<nav aria-label="Page navigation">
		<ul class="pagination justify-content-end">
			<li class="page-item">
				<a class="page-link" onclick="location.reload(true); return false;">Rafraichir</a>
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
	<progress max="100" value="15">15%</progress>
	<i class="pourcent">15%</i>
</div>