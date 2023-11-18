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
<section id="belcms_section_members_main">
	<?php
	foreach ($members as $a):
		$avatar = empty($a->profils->avatar) ? constant('DEFAULT_AVATAR') : $a->profils->avatar;
		$link   = empty($a->profils->websites) ? '#' : $a->profils->websites;
		$linkA  = empty($a->profils->websites) ? '' : 'class="active"';
		$fba    = empty($a->social->facebook)  ? '' : 'class="active"';
		$x      = empty($a->social->x_twitter) ? '' : 'class="active"';
		$dc     = empty($a->social->discord)   ? '' : 'class="active"';
		$pr     = empty($a->social->pinterest) ? '' : 'class="active"';
		$li     = empty($a->social->linkedIn)  ? '' : 'class="active"';
		$yt     = empty($a->social->youtube)   ? '' : 'class="active"';
		$wsa    = empty($a->social->whatsapp)  ? '' : 'class="active"';
		$ig     = empty($a->social->instagram) ? '' : 'class="active"';
		$mr     = empty($a->social->messenger) ? '' : 'class="active"';
		$tok    = empty($a->social->tiktok)    ? '' : 'class="active"';
		$sc     = empty($a->social->snapchat)  ? '' : 'class="active"';
		$st     = empty($a->social->telegram)  ? '' : 'class="active"';
		$rt     = empty($a->social->reddit)    ? '' : 'class="active"';
		$sk     = empty($a->social->skype)     ? '' : 'class="active"';
		$vr     = empty($a->social->viber)     ? '' : 'class="active"';
		$tms    = empty($a->social->teams_ms)  ? '' : 'class="active"';
		$tc     = empty($a->social->twitch)    ? '' : 'class="active"';
		if (file_exists($avatar)) {
			$avatar = $avatar;
		} else {
			$avatar = constant('DEFAULT_AVATAR');
		}
	?>
	<div class="belcms_grid_4">
		<div class="belcms_section_members_main_users">
			<div class="belcms_section_members_main_avatar">
				<img src="<?=$avatar;?>" alt="avatar_<?=$a->user->username;?>">
			</div>
			<h4 class="belcms_section_members_main_users_h4 align_center"><?=$a->user->username;?></h4>
			<ul class="bel_cms_section_members_main_ul align_center">
				<li data-tooltip="Lien" data-position="bottom" <?=$linkA;?>>
					<a href="<?=$link;?>" target="_blank"><i class="fa-solid fa-link"></i></a>
				</li>
				<li data-tooltip="<?=constant('FACEBOOK');?>" data-position="bottom" <?=$fba;?>>
					<a href="<?=$a->social->facebook;?>" target="_blank"><i class="fa-brands fa-facebook"></i></a>
				</li>
				<li data-tooltip="<?=constant('X_TWITTER');?>" data-position="bottom" <?=$x;?>>
					<a href="<?=$a->social->x_twitter;?>" target="_blank"><i class="fa-brands fa-square-x-twitter"></i></a>
				</li>
				<li data-tooltip="<?=constant('DISCORD');?>" data-position="bottom" <?=$dc;?>>
					<a href="<?=$a->social->discord;?>" target="_blank"><i class="fa-brands fa-discord"></i></a>
				</li>
				<li data-tooltip="<?=constant('PINTEREST');?>" data-position="bottom" <?=$pr;?>>
					<a href="<?=$a->social->pinterest;?>" target="_blank"><i class="fa-brands fa-pinterest-p"></i></a>
				</li>
				<li data-tooltip="<?=constant('LINKEDIN');?>" data-position="bottom" <?=$li;?>>
					<a href="<?=$a->social->linkedIn;?>" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a>
				</li>
				<li data-tooltip="<?=constant('YOUTUBE');?>" data-position="bottom" <?=$yt;?>>
					<a href="<?=$a->social->youtube;?>" target="_blank"><i class="fa-brands fa-youtube"></i></a>
				</li>
				<li data-tooltip="<?=constant('WHATSAPP');?>" data-position="bottom" <?=$wsa;?>>
					<a href="<?=$a->social->whatsapp;?>" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
				</li>
				<li data-tooltip="<?=constant('INSTAGRAM');?>" data-position="bottom" <?=$ig;?>>
					<a href="<?=$a->social->instagram;?>" target="_blank"><i class="fa-brands fa-instagram"></i></a>
				</li>
				<li data-tooltip="<?=constant('MESSENGER');?>" data-position="bottom" <?=$mr;?>>
					<a href="<?=$a->social->messenger;?>" target="_blank"><i class="fa-brands fa-facebook-messenger"></i></a>
				</li>
				<li data-tooltip="<?=constant('TIKTOK');?>" data-position="bottom" <?=$tok;?>>
					<a href="<?=$a->social->tiktok;?>" target="_blank"><i class="fa-brands fa-tiktok"></i></a>
				</li>
				<li data-tooltip="<?=constant('SNAPCHAT');?>" data-position="bottom" <?=$sc;?>>
					<a href="<?=$a->social->snapchat;?>" target="_blank"><i class="fa-brands fa-snapchat"></i></a>
				</li>
				<li data-tooltip="<?=constant('TELEGRAM');?>" data-position="bottom" <?=$st;?>>
					<a href="<?=$a->social->telegram;?>" target="_blank"><i class="fa-brands fa-telegram"></i></a>
				</li>
				<li data-tooltip="<?=constant('REDDIT');?>" data-position="bottom" <?=$rt;?>>
					<a href="<?=$a->social->reddit;?>" target="_blank"><i class="fa-brands fa-reddit"></i></a>
				</li>
				<li data-tooltip="<?=constant('SKYPE');?>" data-position="bottom" <?=$sk;?>>
					<a href="<?=$a->social->skype;?>" target="_blank"><i class="fa-brands fa-skype"></i></a>
				</li>
				<li data-tooltip="<?=constant('VIBER');?>" data-position="bottom" <?=$vr;?>>
					<a href="<?=$a->social->viber;?>" target="_blank"><i class="fa-brands fa-viber"></i></a>
				</li>
				<li data-tooltip="<?=constant('TEAMS_MS');?>" data-position="bottom" <?=$tms;?>>
					<a href="<?=$a->social->teams_ms;?>" target="_blank"><i class="fa-brands fa-microsoft"></i></a>
				</li>
				<li data-tooltip="<?=constant('TWITCH');?>" data-position="bottom" <?=$tc;?>>
					<a href="<?=$a->social->twitch;?>" target="_blank"><i class="fa-brands fa-twitch"></i></a>
				</li>
			</ul>
			<?php
			if ($a->user->username == $_SESSION['USER']->user->username):
			?>
			<div class="bel_cms_section_members_main_contact">
				<a href="User"><i class="fa-solid fa-user-gear"></i> Gérer mon compte</a>
			</div>
			<?php
			else:
			?>
			<div class="bel_cms_section_members_main_contact">
				<a data-tooltip="Envoyer un message à <?=$a->user->username;?>" data-position="top" href="User/mail/<?=$a->user->username;?>"><i class="fa-solid fa-envelope-circle-check"></i> Me Contacter</a>
			</div>
			<?php
			endif;
			?>
		</div>
	</div>
	<?php
	endforeach;
	?>
</section>
<?php
if (!empty($pagination)):
?>
	<div class="bel_cms_index_footer">
		<?=$pagination?>
	</div>
<?php
endif;
?>