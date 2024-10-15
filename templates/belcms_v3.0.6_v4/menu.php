<?php
use BelCMS\User\User;
?>
<nav class="nav-inner" id="menu_init">
	<ul>
		<li><a href="index.php">Accueil</a></li>
		<li><a href="Downloads">Téléchargement</a></li>
		<li><a href="Forum">Forum</a></li>
		<li>
			<a href="#">Pages</a>
			<ul>
				<li><a href="Gallery">Galerie d'image</a></li>
				<li><a href="Links">Liens</a></li>
				<li><a href="Search">Recherche</a></li>
				<li><a href="FAQ">Foire aux questions</a></li>
				<li><a href="Donations">Participation € (dons)</a></li>
			</ul>
		</li>
		<li>
			<a href="#">Utilisateur</a>
			<ul>
				<?php
				if (User::isLogged() == true):
				?>
				<li><a href="User/Profil">Profile</a></li>
				<li><a href="Mails">Messagerie</a></li>
				<li><a href="User/security">Mot de passe</a></li>
				<li><a href="User/social">Liens Socials</a></li>
				<li><a href="User/logout">Déconnexion</a></li>
				<li><a href="?admin">Administration</a>
				<?php
				else:
				?>
				<li><a href="User/login&echo" title="Log-in">Log-in</a></li>
				<li><a href="User/register&echo" title="Enregistrement">Enregistrement</a></li>
				<li><a href="User/lostpassword&echo" title="recovey password">Mot de passe perdu</a></li>
				<?php
				endif;
				?>
			</ul>
		</li>
	</ul>
</nav>
