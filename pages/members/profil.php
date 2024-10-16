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
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
$maingroup = config::getGroupsForID($data->groups->user_group);
$name_group = defined($maingroup->name) ? constant($maingroup->name) : $maingroup->name;
if (empty($data->profils->avatar)) {
	$avatar = constant('DEFAULT_AVATAR');
} else {
	$avatar = $data->profils->avatar;
}
$groupsAll = array();
foreach ($data->groups->all_groups as $k => $id) {
	$id = (string) $id;
	$data->groups->all_groups[$k] = Config::getGroupsForID($id);
}
if (!empty($data->profils->gender)) {
	if (strtoupper($data->profils->gender) == 'MALE') {
		$gender = constant('MALE');
	} else if (strtoupper($data->profils->gender) == 'FEMALE') {
		$gender = constant('FEMALE');
	} else {
		$gender = constant('NOSPEC');
	}
} else {
	$gender = constant('NOSPEC');
}
$birthday = !empty($data->profils->birthday) ? Common::TransformDate($data->profils->birthday, 'LONG', 'NONE') : constant('NO_SPEC');
?>
<div id="belcms_members_index">
	<div id="belcms_members_index_header">
		<div id="belcms_members_index_avatar">
			<img src="<?=$avatar;?>">
		</div>
		<h2><?=$data->user->username;?></h2>
		<div id="belcms_members_index_header_infos">
			<span><b>Role</b> : <?=$name_group;?></span>
			<span><b>Dernière activité</b> : <?=Common::TransformDate($data->page->last_visit, 'LONG', 'MEDIUM');?></span>
			<span><b>Date anniversaire</b> : <?=$birthday;?></span>
		</div>
	</div>
	<div id="belcms_members_profil_infos">
				<ul>
					<li id="belcms_members_profil_infos_title">
						<span><i class="fa-solid fa-user-tag fa-beat"></i>&ensp;<?=constant('GENERAL_INFORMATION');?></span>
					</li>
					<li>
						<div class="belcms_grid_6"><i class="fa-regular fa-user"></i>&ensp;<?=constant('USERNAME');?></div>
						<div class="belcms_grid_6"><?=$data->user->username;?></div>
					</li>
					<li>
						<div class="belcms_grid_6"><i class="fa-solid fa-mars-and-venus-burst"></i>&ensp;<?=constant('GENDER');?></div>
						<div class="belcms_grid_6"><?=$gender;?></div>
					</li>
					<li>
						<div class="belcms_grid_6"><i class="fa-solid fa-globe"></i>&ensp;<?=constant('COUNTRY');?></div>
						<div class="belcms_grid_6"><?=$data->profils->country;?></div>
					</li>
					<li>
						<div class="belcms_grid_6"><i class="fa-solid fa-at"></i>&ensp;<?=constant('MAIL');?></div>
						<div class="belcms_grid_6"><?=$data->profils->public_mail;?></div>
					</li>
					<li>
						<div class="belcms_grid_6"><i class="fa-solid fa-link"></i>&ensp;<?=constant('WEBSITE');?></div>
						<div class="belcms_grid_6"><a href="<?=$data->profils->websites;?>"><?=$data->profils->websites;?></a></div>
					</li>
				</ul>
			</div>
</div>