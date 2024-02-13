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
	<li class="active">
		<a href="#">
			<span class="number">2</span>
			<span class="title">Contrôle des dossiers</span>
		</a>
	</li>
	<li>
		<a href="#">
			<span class="number">3</span>
			<span class="title">Contrôle du serveur</span>
		</a>
	</li>
	<li>
		<a href="#">
			<span class="number">4</span>
			<span class="title">Base de données</span>
		</a>
	</li>
	<li>
		<a href="#">
			<span class="number">5</span>
			<span class="title">Installation</span>
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
	<?php
	foreach (createDirAll() as $key => $value):
	?>
		<div><span><?=$key;?></span><span><?=$value;?></span></div>
	<?php
	endforeach;
	?>
	</div>
</section>
<br>
<div class="alert alert-success" role="alert">Vérifie que tous les dossiers et accessible en écriture</div>
<ul id="menu">
	<li id="disabled">
		<a href="#">Précédent</a>
	</li>
	<li id="next">
		<a href="?page=control">Suivant</a>
	</li>
</ul>