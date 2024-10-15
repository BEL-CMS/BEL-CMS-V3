<?php
use BelCMS\User\User;
?>
<nav class="nav-inner" id="menu">
    <ul>
        <li>
            <a href="index.php" class="act-link">Home</a>
        </li>
        <li>
            <a href="#">Pages</a>
            <ul>
                <li><a href="Members">Membres</a></li>
                <li><a href="Forum">Forum</a></li>
                <li><a href="Downloads">Téléchargements</a></li>
                <li><a href="Dons">Dons</a></li>
                <li><a href="FAQ">Foire au questions</a></li>
            </ul>
        </li>
        <li>
            <a href="#" class="act-link">Utilisateur</a>
            <ul>
                <li><a href="User/Profil">Profile</a></li>
                <li><a href="Mails">Messagerie</a></li>
                <li><a href="User/security">Mot de passe</a></li>
                <li><a href="User/social">Liens Socials</a></li>
                <li><a href="User/games">Choix des jeux</a></li>
                <li><a href="/User/logout">Déconnexion</a></li>
            </ul>
        </li>
        <li>
            <a href="#">Shop</a>
            <ul>
                <li><a href="Market">A vendre</a></li>
                <li><a href="Market/Invoice">Mes achats</a></li>
            </ul>
            <!--level 3 end -->
        </li>
        <?php
        if (User::isLogged()):
        ?>
        <li>
            <a href="index.php?admin">Administration</a>
        </li>
        <?php
        endif;
        ?>
    </ul>
</nav>