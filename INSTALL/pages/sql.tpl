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
if (checkPhp() && checkPDO() && checkIntl()):
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
							<li class="active">
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

						<form id="form" action="?page=checkslq_start" method="post">
							<div class="belcms_notification">
								<div class="belcms_notification_msg">Pour utiliser BEL-CMS vous devez <i>créer une base de donées</i> afin d'y enregistrer toutes les données nécessaires au fonctionement de votre site.</div>
							</div>
							<div id="bdd">
								<ul>
									<li>
										<div class="belcms_notification">
											<header class="belcms_notification_header infos">
												<span>Il s'agit ici de l'adresse du serveur MySQL de votre hébergement.</span>
											</header>
											<div class="belcms_notification_msg">
												<input name="serversql" required="required" type="text" class="form-control" id="serversql" value="localhost" placeholder="localhost">
											</div>
										</div>
									</li>
									<li>
										<div class="belcms_notification">
											<header class="belcms_notification_header infos">
												<span>Le prefix permet d'installer plusieurs fois BEL-CMS ou autres sur une seule base MySQL en utilisant un prefix différent à chaque fois, vous pouvez le laisser vide.</span>
											</header>
											<div class="belcms_notification_msg">
												<input name="prefix" type="text" class="form-control" id="prefix" aria-describedby="basic-addon3" value="belcms_">
											</div>
										</div>
									</li>
									<li>
										<div class="belcms_notification">
											<header class="belcms_notification_header infos">
												<span>Il s'agit du port utiliser de votre base de donnée MySQL.</span>
											</header>
											<div class="belcms_notification_msg">
												<input value="3306" name="port" required="required" type="text" class="form-control" id="port" aria-describedby="basic-addon3">
											</div>
										</div>
									</li>
									<li>
										<div class="belcms_notification">
											<header class="belcms_notification_header infos">
												<span>Il s'agit du nom de votre base de données MySQL, souvent vous devez vous rendre dans l'administration de votre hébergement pour créer une base de données, mais parfois celle-ci vous est déjà fournie dans le mail d'inscription de votre hébergement.</span>
											</header>
											<div class="belcms_notification_msg">
												<input name="name" required="required" type="text" class="form-control" id="name" aria-describedby="basic-addon3">
											</div>
										</div>
									</li>
									<li>
										<div class="belcms_notification">
											<header class="belcms_notification_header infos">
												<span>Il s'agit de votre identifiant qui vous permet de vous connecter à votre base MySQL.</span>
											</header>
											<div class="belcms_notification_msg">
												<input name="user" required="required" type="text" class="form-control" id="user" aria-describedby="basic-addon3">
											</div>
										</div>
									</li>
									<li>
										<div class="belcms_notification">
											<header class="belcms_notification_header infos">
												<span>Il s'agit du mot de passe, qui vous permet de vous connecter à votre base de donnée MySQL.</span>
											</header>
											<div class="belcms_notification_msg">
												<input name="password" type="password" class="form-control" id="password" aria-describedby="basic-addon3">
											</div>
										</div>
									</li>
								</ul>
							</div>
							<ul id="menu">
								<li id="preview">
									<a href="index.php?page=control">Précédent</a>
								</li>
								<li id="next">
									<a href="#" onclick="send()">Enregistrer</a>
								</li>
							</ul>
						</form>
<script> 
	function send() { 
		document.getElementById("form").submit(); 
	} 
</script> 
<?php
endif;