<?php

use BelCMS\User\User;

$userProfils = User::getInfosUserAll($_SESSION['USER']->user->hash_key);
?>
<nav>
	<ul>
		<li>
			<img src="<?=$userProfils->profils->avatar;?>">
			<span>Bienvenue <?=$userProfils->user->username;?></span>
			<i class="fa-light fa-user-pen"></i>
		</li>
		<li>
			<a href="User">Accueil</a>
			<div><i class="fa-solid fa-house-user"></i></div>
		</li>
		<li>
			<a href="User/Security">Mot de passe</a>
			<div><i class="fa-solid fa-key"></i></div>
		</li>
		<li>
			<a href="User/Social">Social</a>
			<div><i class="fa-solid fa-retweet"></i></div>
		</li>
		<li>
			<a href="User/sessions">Historique des sessions</a>
			<div><i class="fa-solid fa-users-gear"></i></div>
		</li>
		<li>
			<a href="User/Groups">Groupe(s)</a>
			<div><i class="fa-solid fa-layer-group"></i></div>
		</li>
		<li>
			<a href="User/Logout">Se déconnecter</a>
			<div><i class="fa-solid fa-power-off"></i></div>
		</li>
	</ul>
</nav>