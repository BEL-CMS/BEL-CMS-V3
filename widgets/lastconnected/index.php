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

use BelCMS\Requires\Common;
use BelCMS\User\User;
use BelCMS\Core\Config as Groups;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

if ($var !== null):
	$groups = Groups::getGroups();
?>
<div id="bel_cms_widgets_lastconnected" class="widget">
	<ul>
	<?php
	foreach ($var as $k => $v):
		if (User::ifUserExist($v->hash_key)):
		$infosUser = User::getInfosUserAll($v->hash_key);
		foreach ($groups as $key => $value) {
			if ($value['id'] == $infosUser->groups->user_group) {
				$group = $key;
			}
		}
		if (empty($infosUser->profils->avatar)) {
			$infosUser->profils->avatar = constant('DEFAULT_AVATAR');
		} else {
			if (!empty($infosUser->profils->avatar)) {
				$infosUser->profils->avatar = file_exists(ROOT.DS.$infosUser->profils->avatar) ? $infosUser->profils->avatar :  constant('DEFAULT_AVATAR');
			} else {
				$infosUser->profils->avatar = constant('DEFAULT_AVATAR');
			}
		}
		?>
			<li>
				<img title="<?=$infosUser->user->username?>" src="<?=$infosUser->profils->avatar?>" alt="avatar_<?=$infosUser->user->username?>" style="max-width: 50px; max-height: 50px;">
				<span>
					<p>
						<span data-tooltip="<?=$group;?>" data-position="right" class="right" style="color: <?=$infosUser->user->color;?>"><?=$infosUser->user->username;?></span>
					</p>
					<p><?=Common::transformDate($infosUser->page->last_visit, 'MEDIUM', 'SHORT') ?></p>
				</span>
			</li>
		<?php
		endif;
	endforeach;
	?>
	</ul>
</div>
<?php
else:
	?>
	 no data
	<?php 
endif;
