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
	<li>
		<a href="#">
			<span class="number">4</span>
			<span class="title">Installation</span>
		</a>
	</li>
	<li>
		<a href="#">
			<span class="number">5</span>
			<span class="title">Remerciement</span>
		</a>
	</li>
</ul>
<div class="belcms_notification">
	<header class="belcms_notification_header infos">
		<span>Création du compte administrateur</span>
	</header>
	<div class="belcms_notification_msg">Création du compte administrateur le seul et unique qui aura le statut <b>gold</b> pour pouvoir bannir un autre administrateur de niveau 1.</div>
</div>
<form id="form" action="?page=finish" method="post">
	<div class="form-group row">
		<label for="user" class="col-sm-2 col-form-label col-form-label-sm">Compte Administrateur</label>
		<div class="col-sm-10">
			<input type="text" required="required" class="form-control form-control-sm" id="user" placeholder="Nom d'utilisateur" name="username">
		</div>
	</div>
	<div class="form-group row">
		<label for="email" class="col-sm-2 col-form-label col-form-label-sm">Adresse E-Mail</label>
		<div class="col-sm-10">
			<input name="email" type="email" required="required" class="form-control form-control-sm" id="email" placeholder="E-mail">
		</div>
	</div>
	<div class="form-group row">
		<label for="password" class="col-sm-2 col-form-label col-form-label-sm">Mot de passe</label>
		<div class="col-sm-10">
			<input name="password" type="password" required="required" class="form-control form-control-sm" id="password" autocomplete="off" placeholder="Mot de passe">
		</div>
	</div>
</form>
<ul id="menu">
	<li id="disabled">
		<a href="#">Précédent</a>
	</li>
	<li id="next" class="menuuser" style="display: none;">
		<a href="#" onclick="send()">Enregistrer</a>
	</li>
</ul>
<script> 
	function send() { 
		document.getElementById("form").submit(); 
	} 
</script> 