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

use BelCMS\Core\Config;
use BelCMS\Core\Secure;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<section id="belcms_section_members_main">
	<form>
		<input type="search" name="search" value="" placeholder="Recherche utilisateur">
	</form>
	<div id="members_main_grid">
		<?php
		foreach ($members as $key => $v):
			$largeAvatar = empty($v->profils->hight_avatar) ? 'assets/img/bg_default.png' : $v->profils->hight_avatar;
		?>
		<div class="members_main_grid">
			<figure>
				<img src="<?=$largeAvatar;?>" alt="members_bg_<?=$v->user->username;?>">
			</figure>
			<a class="members_main_avatar" href="Members/profil/<?=$v->user->username;?>">
				<img src="<?=$v->profils->avatar;?>">
			</a>
			<div class="members_main_username">
				<a href="Members/profil/<?=$v->user->username;?>" title="#"><?=$v->user->username;?></a>
			</div>
			<div class="members_main_link"><a href="<?=$v->profils->websites;?>"><?=$v->profils->websites;?></a></div>
			<ul class="members_main_stats">
				<li>
					<span><?=$v->profils->countPost;?></span><span>Post</span>
				</li>
				<li>
					<span><?=$v->profils->countDls;?></span><span>Téléchargements</span>
				</li>
				<li>
					<span><?=$v->profils->visits;?></span><span>Visites</span>
				</li>
			</ul>
			<div class="members_main_enter">
				<a href="Mails/New?user=<?=$v->user->username;?>">Me Contacter</a>
				<a href="Members/profil/<?=$v->user->username;?>">Profil</a>
			</div>
		</div>
		<?php
		endforeach;
		?>
	</div>
</section>