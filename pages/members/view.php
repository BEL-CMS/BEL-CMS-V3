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

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<div id="belcms_section_members_view">
	<span class="bel-cms-pages_title"><?=$data->username?></span>
	<div id="belcms_section_members_view_left">
		<div class="belcms_card">
			<div id="belcms_section_members_view_avatar">
				<img src="<?=$data->avatar?>">
			</div>
		</div>
		<div id="bel_cms_members_view_lt_grps">
			<ul>
				<li class="title">Liste des groups</li>
			<?php
			foreach ($data->main_groups as $k => $v):
				if (array_key_exists($v, $groups)):
				?>
				<li>
					<span><?=defined($groups[$v]) ? constant($groups[$v]) : $groups[$v] ?></span>
				</li>
				<?php
				endif;
			endforeach;
			?>
			</ul>
		</div>
	</div>
	<div id="belcms_section_members_view_right">

	</div>

</div>
