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
	<li class="active">
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
<section>
	<span id="title">
		<h2>Bienvenue sur l'installation de BEL-CMS [PHP 8.3] v3.0.0</h2>
	</span>
	<p>Nous vous remercions d'avoir choisi notre CMS, en espérant qu'il vous plaira, n'hésitez pas à poster sur le <a href="https://bel-cms.dev/Forum" title="Bel-CMS">Forum</a> ou <a href="https://discord.gg/3fkp6gdjsk" title="Discord Bel-CMS">Discord</a> pour demander des nouveautés.</p>
	<p>Bel-CMS est un CMS open source. Il permet d'installer et d'administrer un site web de manière simple et interactive. Il nécessite simplement un hébergement PHP8/MySQL pour fonctionner.</p>
	<div class="belcms_notification">
		<header class="belcms_notification_header infos">
			<span>Attention</span>
		</header>
		<div class="belcms_notification_msg">À la prochaine, page, les vérifications seront faites pour regarder si vous possédez bien le nécessaire pour l'installation.</div>
	</div>
</section>
<ul id="menu">
	<li id="disabled">
		<a href="#">Précédent</a>
	</li>
	<li id="next">
		<a href="?page=control">Suivant</a>
	</li>
</ul>
<?php
    // Ancienne installation
	$domain = ($_SERVER['HTTP_HOST']);
	setcookie('BELCMS_HASH_KEY', 'data', time()-60*60*24*365, '/', $domain, false);
	setcookie('BELCMS_NAME', 'data', time()-60*60*24*365, '/', $domain, false);
	setcookie('BELCMS_PASS', 'data', time()-60*60*24*365, '/', $domain, false);
	unset($_SESSION['USER'], $_COOKIE["BELCMS_HASH_KEY"],$_COOKIE["BELCMS_NAME"], $_COOKIE["BELCMS_PASS"]);
?>