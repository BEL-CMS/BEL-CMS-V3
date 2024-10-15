<?php
use BelCMS\User\User;
?>
<div class="nav-holder main-menu">
	<nav>
		<ul class="no-list-style">
			<li><a href="index.php" title="Accueil">Accueil</a></li>
			<li><a href="Downloads" title="Téléchargement">Téléchargement</a></li>
			<li><a href="Forum" title="Forum">Forum</a></li>
			<li>
				<a href="#">Pages <i class="fa-solid fa-caret-down"></i></a>
				<ul>
					<li><a href="Gallery" title="Images">Galerie d'image</a></li>
					<li><a href="Links" title="Liens">Liens</a></li>
					<li><a href="Search" title="Recherche">Recherche</a></li>
					<li><a href="FAQ" title="Foire aux questions">Foire aux questions</a></li>
					<li><a href="Donations" title="Participation don">Participation € (dons)</a></li>
				</ul>
			</li>
			<li>
				<a href="#">C.M.S <i class="fa-solid fa-caret-down"></i></a>
				<ul>
					<li><a href="downloads/detail/6/Bel_CMS_V3" title="Télécharger CMS">Télécharger</a></li>
					<li><a href="Articles" title="Articles">Articles</a></li>
				</ul>
			</li>
			<li>
				<a href="#">Utilisateur <i class="fa-solid fa-caret-down"></i></a>
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
					<li><a href="User/lostpassword&echo" title="Mot de passe perdu">Mot de passe perdu</a></li>
				<?php
				endif;
				?>
				</ul>
			</li>
		</ul>
	</nav>
</div>