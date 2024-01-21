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
?>
<div class="bel_cms_accordion">
	<h3><i class="fa-regular fa-circle-user fa-shake"></i> <strong>Mon profil</strong><br>
		<p>Changez votre avatar et votre couverture, vos informations personnelles.<p></h3>
	<div>
		<ul>
			<li><a href="User"><i class="fa-solid fa-arrow-right-to-bracket"></i> Infos Personnel</a></li>
			<li><a href="User/Security"><i class="fa-solid fa-arrow-right-to-bracket"></i> Changer le mot de passe</a></li>
			<li><a href="User/Social"><i class="fa-solid fa-arrow-right-to-bracket"></i> infos Social</a></li>
		</ul>
	</div>
	<h3><i class="fa-solid fa-user-gear fa-bounce"></i> <strong>Mon Compte</strong><br>
		<p>Modifiez les paramètres, configurez les notifications et vérifiez votre confidentialité<p></h3>
	<div>
		<ul>
			<li><a href="User/Generals"><i class="fa-solid fa-arrow-right-to-bracket"></i> Réglages généraux</a></li>
			<li><a href="User/Sessions"><i class="fa-solid fa-arrow-right-to-bracket"></i> Historique des sessions</a></li>
			<li><a href="User/Notification"><i class="fa-solid fa-arrow-right-to-bracket"></i> Notifications</a></li>
		</ul>
	</div>
	<h3><i class="fa-solid fa-users-gear fa-fade"></i> <strong>Groupes</strong><br>
		<p>Liste de vos groupes<p></h3>
	<div>
		<ul>
			<li><i class="fa-solid fa-arrow-right-to-bracket"></i> <a href="User/Groups">Vos Groupes</a></li>
		</ul>
	</div>
</div>