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

$checkpdo = checkPDOConnect($_POST);
if ($checkpdo != true):
?>
<div id="main_content" style="clear: both;width:100%;">
	<h1>Bienvenue sur l'installation de Bel-CMS V.3.1.0</h1>
    <div class="alert alert-danger" role="alert">Erreur de connexion à la base de données MySQL/MariaDB</div>
	<ul id="menu">
		<li><a href="index.php?page=pdo">Retour</a></li>
	</ul>
</div>
<?php
else:
?>
<div id="main_content">
	<h1>Installation de la base de données</h1>
	<div class="main_content">
        <div id="code"></div>
    </div>
    <nav>
        <ul class="pagination justify-content-end">
            <li class="page-item">
                <a id="submit_bdd" class="page-link">Installer</a>
            </li>
            <li class="page-item">
                <a id="next_link" class="page-link hidden" href="index.php?page=finish">Suivant</a>
            </li>
        </ul>
    </nav>
</div>
<?php
endif;
?>