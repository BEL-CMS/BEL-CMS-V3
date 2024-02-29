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
	<div id="forum_new_treads">
		<a data="<?=constant('NEW_THREAD');?>" href="Forum/NewThread?id=<?=$id?>"><i class="fas fa-plus"></i> <?=constant('NEW_THREAD');?></a>
	</div>
	<?php	
endif;
?>
<section id="belcms_forum_main">
	<?php
	if (empty($threads)):
		Notification::infos('Aucun sujet disponible dans la base de données', 'Forum');
	else:
	?>
		<div class="belcms_forum_main_cat">
	<?php
	foreach ($threads as $value):
		$userinfos = User::getInfosUserAll($value->author);
		$user = $userinfos == false ? constant('MEMBER_DELETE') : $userinfos->user->username;
		$avatar = !empty($userinfos->profils->avatar) ? $userinfos->profils->avatar : constant('DEFAULT_AVATAR');
		$originDate = Common::TransformDate($value->date_post, 'MEDIUM', 'NONE');
		$icon = $value->lockpost == 1 ? 'fa-solid fa-comment-slash' : 'fa-solid fa-comment-dots';
		$red  = $value->lockpost == 1 ? 'redpost' : '';
		if (!empty($value->last)) {
			$lastUser = User::getInfosUserAll($value->last->author);
			$lastUser = '<a href="Members/profil/'.$lastUser->user->username.'">'.$lastUser->user->username.'</a>';
			$lastDate = Common::TransformDate($value->date_post, 'MEDIUM', 'NONE');
			$dateNow  = date("Y-m-d");
			$dateNow  = Common::TransformDate($dateNow, 'MEDIUM', 'NONE');
			if ($lastDate == $dateNow) {
				$lastDate = constant('TODAY');
			}
		}
		$vewLastPost = $value->viewpost;
	?>
		<div class="belcms_forum_main_block_content">
			<span class="belcms_forum_main_block_content_ico">
				<i class="<?=$icon?>"></i>
			</span>
			<span class="belcms_forum_main_block_content_title">
				<span><a href="Forum/Post/<?=Common::MakeConstant($value->title)?>?id=<?=$value->id?>"><?=$value->title?></a></span>
				<span><?=$user;?> . <?=$originDate;?></span>
			</span>
			<span class="belcms_forum_threads_block_content_stats">
				<span>Réponse<i><?=$value->reply;?></i></span>
				<span>Affichages<i><?=$vewLastPost;?></i></span>
			</span>
			<span class="belcms_forum_threads_block_content_stats">
				<span style="text-align: right;"><?=$lastDate;?></span>
				<span style="text-align: right;"><?=$lastUser;?></span>
			</span>
		</div>
	<?php
	endforeach;
	?>
	</div>
</section>
<?php
endif; ?>