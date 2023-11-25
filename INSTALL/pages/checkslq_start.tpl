<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2023 Bel-CMS
 * @author as Stive - stive@determe.be
 */

$checkpdo = checkPDOConnect($_POST);
if ($checkpdo === true):
?>
<ul>
	<li>
		<a href="#">
			<span class="number">1</span>
			<span class="title">Accueil</span>
		</a>
	</li>
	<li>
		<a href="#">
			<span class="number">2</span>
			<span class="title">Contrôle du serveur</span>
		</a>
	</li>
	<li>
		<a href="#">
			<span class="number">3</span>
			<span class="title">Base de données</span>
		</a>
	</li>
	<li class="active">
		<a href="#">
			<span class="number">4</span>
			<span class="title">Installation</span>
		</a>
	</li>
	<li>
		<a href="#">
			<span class="number">5</span>
			<span class="title">Création d'un Compte</span>
		</a>
	</li>
	<li>
		<a href="#">
			<span class="number">6</span>
			<span class="title">Remerciement</span>
		</a>
	</li>
</ul>
<section id="code">
	<div id="install">
	</div>
</section>
<div id="button_bdd">
	<a id="submit_bdd" class="btn btn-primary" href="#">Installer</a>
</div>
<div class="belcms_notification">
	<header class="belcms_notification_header infos">
		<span>Information</span>
	</header>
	<div class="belcms_notification_msg">
		<div id="error_bdd">Aucune information pour l'instant</div>
	</div>
</div>
<ul id="menu"></ul>
<?php
else:
?>
<div class="belcms_notification">
	<header class="belcms_notification_header error">
		<span>Erreur Configuration BDD</span>
	</header>
	<div class="belcms_notification_msg"><?=$checkpdo;?></div>
</div>
<ul id="menu">
	<li id="preview">
		<a href="index.php?page=sql">Retour</a>
	</li>
</ul>
<?php
endif;