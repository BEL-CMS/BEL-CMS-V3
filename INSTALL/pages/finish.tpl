<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2023 Bel-CMS
 * @author as Stive - stive@determe.be
 */

$insert = insertUserBDD();
?>
<?php if ($insert === true): ?>
<div class="belcms_notification">
	<div class="belcms_notification_msg">
		<p>Votre installation s'est, à priori, bien déroulée.</p>
		<p>Merci de nous en faire part sur <a href="http://bel-cms.dev" title="BEL-CMS">bel-cms.dev</a> si vous avez rencontre le moindre souci lors de l'installation</p>
	</div>
</div>
<?php else: ?>
<div class="belcms_notification">
	<header class="belcms_notification_header error">
		<span>Erreur</span>
	</header>
	<div class="belcms_notification_msg">Une erreur est survenue durant l'installation veuillez vous référer au forum de <a href="https://bel-cms.dev"><b><i>Bel-CMS</i></b></a> sur le forum, avec le nom de l'erreur, merci<br><i style="color: red;"><?=$insert;?></i></div>
</div>
<?php endif;
if ($insert === true): ?>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="alert alert-danger" role="alert">Veuillez supprimer le dossier INSTALL de votre FTP, si cela n'a pas été fait automatiquement.</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="alert alert-success" role="alert">Redirection automatique dans 5s</div>
			</div>
		</div>
	</div>
</div>
<?php endif;
rmAllDir(ROOT.DS.'INSTALL');

if (!isset($_SESSION)) {
	session_start();
} else {
	$_SESSION = array();
}
$_SESSION = array();
$_SESSION['INSTALL'] = true;
redirect($_SERVER['HTTP_HOST'], 5);
