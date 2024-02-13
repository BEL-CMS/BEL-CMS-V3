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
?>
<div class="belcms_notification">
	<div class="belcms_notification_msg">
		<p>Votre installation s'est, à priori, bien déroulée.</p>
		<p>Merci de nous en faire part sur <a href="http://bel-cms.dev" title="BEL-CMS">bel-cms.dev</a> si vous avez rencontre le moindre souci lors de l'installation</p>
	</div>
</div>
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
				<div class="alert alert-success" role="alert">Redirection automatique dans 10s<br>Créer un compte directement, le 1ᵉʳ compte créé sera administrateur</div>
			</div>
		</div>
	</div>
</div>
<?php
@chmod(ROOT.DS.'INSTALL', 0777);
recursive_delete(ROOT.DS.'INSTALL');
?>
<script type="text/javascript">
	setTimeout("location.href = '<?=$_SESSION['HTTP_HOST'];?>';", 10000);
</script>