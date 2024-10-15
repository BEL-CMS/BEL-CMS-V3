<?php
use BelCMS\User\User;
?>
<nav>
	<ul class="no-list-style">
		<li>
			<a href="index.php" class="act-link">Accueil</a>
		</li>
		<li>
		<li>
            <a href="Downloads">Téléchargement</a>
    	</li>
		<li>
            <a href="Forum">Forum</a>
    	</li>
		<li>
				<a href="#">Pages <svg class="svg-inline--fa fa-caret-down" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M137.4 374.6c12.5 12.5 32.8 12.5 45.3 0l128-128c9.2-9.2 11.9-22.9 6.9-34.9s-16.6-19.8-29.6-19.8L32 192c-12.9 0-24.6 7.8-29.6 19.8s-2.2 25.7 6.9 34.9l128 128z"></path></svg><!-- <i class="fa-solid fa-caret-down"></i> Font Awesome fontawesome.com --></a>
				<ul>
					<li><a href="Gallery" title="Images">Galerie d'image</a></li>
					<li><a href="Links" title="Liens">Liens</a></li>
					<li><a href="Search" title="Recherche">Recherche</a></li>
					<li><a href="FAQ" title="Foire aux questions">Foire aux questions</a></li>
					<li><a href="Donations" title="Participation don">Participation € (dons)</a></li>
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