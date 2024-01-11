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
<?php
	foreach ($members as $a):
		$spanGroups = '';
		foreach ($a->groups->all_groups as $v) {
			$group = Config::getGroupsForID($v);
			$name  = defined($group->name) ? constant($group->name) : $group->name;
			$spanGroups .= '<span style=background:'.$group->color.';color:#FFF;>'.$name.'</span>'.PHP_EOL;
		}
		$avatar       = empty($a->profils->avatar)    ? constant('DEFAULT_AVATAR') : $a->profils->avatar;
		$facebook     = !empty($a->social->facebook)  ? '<li><a class="belcms_tooltip_bottom" data="facebook" href="'.$a->social->facebook.'" target="_blank"><i class="fa-brands fa-facebook"></i></a></li>' : '';
		$youtube      = !empty($a->social->youtube)   ? '<li><a class="belcms_tooltip_bottom" data="youtube" href="'.$a->social->youtube.'" target="_blank"><i class="fa-brands fa-youtube"></i></a></li>' : '';
		$whatsapp     = !empty($a->social->whatsapp)  ? '<li><a class="belcms_tooltip_bottom" data="whatsapp" href="'.$a->social->whatsapp.'" target="_blank"><i class="fa-brands fa-whatsapp"></i></a></li>' : '';
		$instagram    = !empty($a->social->instagram) ? '<li><a class="belcms_tooltip_bottom" data="instagram" href="'.$a->social->instagram.'" target="_blank"><i class="fa-brands fa-instagram"></i></a></li>' : '';
		$messenger    = !empty($a->social->messenger) ? '<li><a class="belcms_tooltip_bottom" data="messenger" href="'.$a->social->messenger.'" target="_blank"><i class="fa-brands fa-facebook-messenger"></i></a></li>' : '';
		$tiktok       = !empty($a->social->tiktok)    ? '<li><a class="belcms_tooltip_bottom" data="tiktok" href="'.$a->social->tiktok.'" target="_blank"><i class="fa-brands fa-tiktok"></i></a></li>' : '';
		$snapchat     = !empty($a->social->snapchat)  ? '<li><a class="belcms_tooltip_bottom" data="snapchat" href="'.$a->social->snapchat.'" target="_blank"><i class="fa-brands fa-snapchat"></i></a></li>' : '';
		$telegram     = !empty($a->social->telegram)  ? '<li><a class="belcms_tooltip_bottom" data="telegram" href="'.$a->social->telegram.'" target="_blank"><i class="fa-brands fa-telegram"></i></a></li>' : '';
		$pinterest    = !empty($a->social->pinterest) ? '<li><a class="belcms_tooltip_bottom" data="pinterest" href="'.$a->social->pinterest.'" target="_blank"><i class="fa-brands fa-pinterest-p"></i></a></li>' : '';
		$x_twitter    = !empty($a->social->x_twitter) ? '<li><a class="belcms_tooltip_bottom" data="x_twitter" href="'.$a->social->x_twitter.'" target="_blank"><i class="fa-brands fa-square-x-twitter"></i></a></li>' : '';
		$reddit       = !empty($a->social->reddit)    ? '<li><a class="belcms_tooltip_bottom" data="reddit" href="'.$a->social->reddit.'" target="_blank"><i class="fa-brands fa-reddit"></i></a></li>' : '';
		$linkedIn     = !empty($a->social->linkedIn)  ? '<li><a class="belcms_tooltip_bottom" data="linkedIn" href="'.$a->social->linkedIn.'" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a></li>' : '';
		$skype        = !empty($a->social->skype)     ? '<li><a class="belcms_tooltip_bottom" data="skype" href="'.$a->social->skype.'" target="_blank"><i class="fa-brands fa-skype"></i></a></li>' : '';
		$viber        = !empty($a->social->viber)     ? '<li><a class="belcms_tooltip_bottom" data="viber" href="'.$a->social->viber.'" target="_blank"><i class="fa-brands fa-viber"></i></a></li>' : '';
		$teams_ms     = !empty($a->social->teams_ms)  ? '<li><a class="belcms_tooltip_bottom" data="teams_ms" href="'.$a->social->teams_ms.'" target="_blank"><i class="fa-brands fa-microsoft"></i></a></li>' : '';
		$discord      = !empty($a->social->discord)   ? '<li><a class="belcms_tooltip_bottom" data="discord" href="'.$a->social->discord.'" target="_blank"><i class="fa-brands fa-discord"></i></a></li>' : '';
		$twitch       = !empty($a->social->twitch)    ? '<li><a class="belcms_tooltip_bottom" data="twitch" href="'.$a->social->twitch.'" target="_blank"><i class="fa-brands fa-twitch"></i></a></li>' : '';
		if (!file_exists($avatar)) {
			$avatar = constant('DEFAULT_AVATAR');
		}
	?> 
	<div class="belcms_section_members_main_row"> 
		<ul>
			<li>
				<div class="belcms_members_avatar">
					<img src="<?=$avatar;?>" alt="avatar_<?=$a->user->username;?>">
				</div>
				<div class="belcms_members_autor_content">
					<div class="belcms_members_autor_content_title">
						<h3><a href="Members/profil/<?=$a->user->username;?>"><?=$a->user->username;?></a>&ensp;/&ensp;<a class="belcms_tooltip_bottom" data="Envoyé un message privé" href="Mails/New?user=<?=$a->user->username;?>"><i class="fa-solid fa-envelope"></i></a></h3>
						<ul class="belcms_autor_social">
							<?php
							echo $facebook;
							echo $youtube; 
							echo $whatsapp; 
							echo $instagram;
							echo $messenger;
							echo $tiktok; 
							echo $snapchat; 
							echo $telegram; 
							echo $pinterest;
							echo $x_twitter;
							echo $reddit; 
							echo $linkedIn; 
							echo $skype; 
							echo $viber; 
							echo $teams_ms; 
							echo $discord;  
							echo $twitch; 
							?>
						</ul>
						<div class="belcms_members_autor_text">
							<?=$a->profils->info_text;?>
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<div class="belcms_autor_group">
					<div class="fa fa-bars"></div> <span class="no_barre">Groupes</span>
					<?=$spanGroups;?>
					<?php
					if (!empty($a->profils->websites) and Secure::isUrl($a->profils->websites)) {
						echo '<a href="'.$a->profils->websites.'" class="belcms_autor_group_web">'.$a->profils->websites.'</a>';
					}
					?>
				</div>
			</li>
		</ul>
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