            <div class="nav-holder-wrap">
                <div class="nav-title">Menu</div>
                <div class="nav-holder fl-wrap nv-widget">
                    <nav>
                        <ul>
                            <li>
                                <i class="fal fa-home"></i>
                                <a href="articles">Accueil</a>
                            </li>
                            <li>
                                <i class="fal fa-users"></i>
                                <a href="members">Membres</a>
                            </li>
                            <li>
                                <i class="fal fa-file"></i>
                                <a href="page">Information</a>
                            </li>
                            <li>
                                <i class="fal fa-globe"></i>
                                <a href="forum">Forum</a>
                            </li>
                            <li>
                                <i class="fal fa-download"></i>
                                <a href="downloads">Téléchargements</a>
                            </li>
                            <li>
                                <i class="fal fa-user"></i>
                                <a>Utilisateur</a>
                                <ul>
                                    <?php
                                    if (Users::isLogged() === true):
                                    ?>
                                    <li><a href="User/Profil">Profile</a></li>
                                    <li><a href="User/Avatar">Avatar</a></li>
                                    <li><a href="User/Safety">Confidentialité</a></li>
                                    <li><a href="User/Security">Sécurité</a></li>
                                    <li><a href="User/social">Social</a></li>
                                    <li><a href="?admin">Administration</a></li>
                                    <?php else: ?>
                                    <li><a href="User/Login">/login</a></li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>