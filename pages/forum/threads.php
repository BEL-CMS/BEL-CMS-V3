<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.2]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2023 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Core\Notification;
use BelCMS\Requires\Common;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
if (User::isLogged()):
	?>
	<div id="forum_new">
		<a data-toggle="tooltip" title="<?=constant('NEW_THREAD');?>" href="Forum/NewThread?id=<?=$id?>" class="belcms_btn belcms_bg_black"><i class="fas fa-plus"></i> <?=constant('NEW_THREAD');?></a>
	</div>
	<?php	
endif;
?>
<section id="belcms_forum">
	<?php
	if (empty($threads)):
		Notification::infos('Aucun sujet disponible dans la base de données', 'Forum');
	else:
	?>
		<div class="belcms_forum_main_cat">
	<?php
	foreach ($threads as $value):
		$user = User::getInfosUserAll($value->author);
		$user = $user == false ? constant('MEMBER_DELETE') : $user->user->username;
		$userlast = User::getInfosUserAll($value->last->author);
		$userlast = $userlast == false ? constant('MEMBER_DELETE') : $userlast->user->username;
		$icon = $value->lockpost == 1 ? 'fa-solid fa-comment-slash' : 'fa-solid fa-comment-dots';
		$red  = $value->lockpost == 1 ? 'redpost' : '';
	?>
		<div class="belcms_forum_main_cat_block <?=$red;?>">
			<div class="belcms_forum_main_cat_ico"><i class="<?=$icon;?>"></i></div>
			<div class="belcms_forum_main_cat_subtitle">
				<h3><a href="Forum/Post/<?=Common::MakeConstant($value->title)?>?id=<?=$value->id?>"><?=$value->title?></a></h3>
				<div>Poste par : <?=$user;?></div>
			</div>
			<div class="belcms_forum_main_cat_last_post">
				<div><?=$userlast;?></div>
				<div><?=Common::truncate(Common::VarSecure($value->last->content, null), '45');?></div>
			</div>
		</div>
	<?php
	endforeach;
	?>
	</div>
</section>
<?php
endif; ?>