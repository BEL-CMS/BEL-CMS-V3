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
createDirAll();
$php_class     = checkPhp() === false ? 'error' : 'success';
$php_msg       = checkPhp() === false ? 'Le PHP nécessaire est au minimum de 8.0.0 et vous etes au PHP['.PHP_VERSION.']' : 'Aucun souci, vous possédez bien le PHP['.PHP_VERSION.'] nécessaire.';
$sqli_class    = checkMysqli() === false ? 'error' : 'success';
$sqli_msg      = checkMysqli() === false ? '' : 'Aucun souci, vous avez bien le MySQLI actif';
$intl_class    = checkIntl() === false ? 'error' : 'success';
$intl_msg      = checkIntl() === false ? 'Le mod IntlDateFormatter est nécessaire' : 'Aucun souci, vous possédez bien le IntlDateFormatter actif';
$pdo_class     = checkPDO() === false ? 'error' : 'success';
$pdo_msg       = checkPDO() === false ? 'La class PDO est nécessaire.' : 'Aucun souci, vous avez bien la class PDO actif';
$config        = checkWriteConfig() === false ? 'error' : 'success';
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
									<span class="title">Contrôle des dossiers</span>
								</a>
							</li>
							<li class="active">
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
						<span id="title">
							<h2>Teste les composants nécessaires à l'installation du C.M.S</h2>
						</span>
						<div id="component">
							<ul>
								<li>
									<div class="belcms_notification">
										<header class="belcms_notification_header <?=$php_class;?>">
											<span>PHP version ≥ 8.0.0</span>
										</header>
										<div class="belcms_notification_msg"><?=$php_msg;?></div>
									</div>
								</li>
								<li>
									<div class="belcms_notification">
										<header class="belcms_notification_header <?=$sqli_class;?>">
											<span>Extension MySQL</span>
										</header>
										<div class="belcms_notification_msg"><?=$sqli_msg;?></div>
									</div>
								</li>
								<li>
									<div class="belcms_notification">
										<header class="belcms_notification_header <?=$intl_class;?>">
											<span>IntlDateFormatter (intl)</span>
										</header>
										<div class="belcms_notification_msg"><?=$intl_msg;?></div>
									</div>
								</li>
								<li>
									<div class="belcms_notification">
										<header class="belcms_notification_header <?=$pdo_class;?>">
											<span>PDO Driver</span>
										</header>
										<div class="belcms_notification_msg"><?=$pdo_msg;?></div>
									</div>
								</li>
							</ul>
						</div>
						<ul id="menu">
							<li>
								<a href="?page=checkdir">Précédent</a>
							</li>
							<?php
							if (checkPhp() && checkPDO() && checkIntl()):
								echo '	<li id="next">
											<a href="?page=sql">Suivant</a>
										</li>';	
							else:
								echo '	<li id="disabled">
											<a href="#">Suivant</a>
										</li>';						
							endif;
							?>
						</ul>