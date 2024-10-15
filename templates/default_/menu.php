<?php use BelCMS\User\User; ?>
<div class="nav-holder-wrap">
	<div class="nav-title">Menu</div>
	<div class="nav-holder fl-wrap nv-widget">
		<nav>
			<ul>
				<li><i class="fal fa-home"></i><a href="https://bel-cms.dev">Home </a></li>
				<li>
					<i class="fal fa-file"></i>
					<a>Pages</a>
					<ul>
						<li><a href="Downloads">Téléchargements</a></li>
						<li><a href="Members">Membres</a></li>
						<li><a href="Forum">Forum</a></li>
						<li><a href="Guestbook">Livre d'or</a></li>
						<li><a href="Gallery">Galerie d'image</a></li>
					</ul>
				</li>
				<li>
				<i class="fa-solid fa-shop"></i>
				<a>Boutique</a>
					<ul>
						<li><a href="Market">Achats</a></li>
						<li><a href="Market/billing">Mes commandes</a></li>
					</ul>
				</li>
				<li><i class="fa-solid fa-hand-holding-dollar"></i><a href="Donations">Dons</a></li>
				<li>
					<i class="fal fa-users"></i>
					<a>Utilisateur</a>
					<ul>
						<?php
						if (User::isLogged()):
						?>
						<li><a href="User/Profil">Profile</a></li>
						<li><a href="Mails">Messagerie</a></li>
						<li><a href="User/security">Mot de passe</a></li>
						<li><a href="User/social">Liens Socials</a></li>
						<li><a href="User/games">Choix des jeux</a></li>
						<li><a href="/User/logout">Déconnexion</a></li>
						<?php
                   		else:
                    	?>
						<li><a href="User/login&echo">Login</a></li>
                    	<li><a href="User/register&echo">Enregistrement</a></li>
						<?php
                   		endif;
                    	?>
					</ul>
				</li>
				<li>
					<i class="fal fa-newspaper"></i>
					<a>Informations</a>
					<ul>
						<li><a href="Articles/read/2/legal">Legal</a></li>
						<li><a href="Articles/subpage/3/Coockies">Coockies</a></li>
						<li><a href="Articles/read/5/About">About</a></li>
					</ul>
				</li>
				<li><i class="fa-brands fa-github"></i><a href="https://github.com/BEL-CMS/BEL-CMS-V3">GitHub</a></li>
				<?php
				if (User::isLogged()):
				?>
				<li><i class="fa-solid fa-screwdriver-wrench"></i><a href="?admin">Administration</a></li>
				<?php
                endif;
                ?>
			</ul>
		</nav>
	</div>
</div>