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

use BelCMS\Requires\Common;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<section id="belcms_shoutbox">
    <div id="belcms_shoutbox_main">
        <ul>
			<?php
			foreach ($var as $value):
				$user = User::getInfosUserAll($value->hash_key);
				$date = Common::TransformDate($value->date_msg, 'FULL', 'MEDIUM');
				$msg  = Common::getSmiley($value->msg);
			?>
			<li id="id_<?=$value->id;?>">
				<span><a href="#" style="color:<?=$user->user->color;?>;"><?=$user->user->username;?></a></span>
				<span><?=$msg;?></span>
				<i><?=$date;?></i>
				<?php
				if (!empty($value->file) or !empty($value->image)):
				echo '<div>';
				endif;
					if (!empty($value->file)):
					?>
					<a href="<?=$value->file;?>"><i class="fa-solid fa-paperclip" style="color: #74C0FC;"></i></a>
					<?php
					endif;
					if (!empty($value->image)):
					?>
					<a href="<?=$value->image;?>"><i class="fa-regular fa-image fa-flip-horizontal" style="color: #FFD43B;"></i></a>
					</a>
					<?php
					endif;
				if (!empty($value->file) or !empty($value->image)):
				echo '</div>';
				endif;
				?>
			</li>
			<?php
			endforeach;
			?>
		</ul>
	</div>
	<?php
	if (User::isLogged() === true):
	?>
	<form id="belcms_shoutbox_form" methode="post" accept="image/*, audio/*, video/*,.pdf, .doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" enctype="multipart/form-data">
		<input id="belcms_shoutbox_input" type="text" name="text" autocomplete="off" value="" placeholder="Entrer votre texte">
		<label id="shoutbox_form_file" class="belcms_tooltip_top" data="Uploadé un fichier">
			<i class="fa-solid fa-link"></i>
			<input type="file" name="file">
		</label>
		<label id="shoutbox_form_image" class="belcms_tooltip_top" data="Uploadé une image">
			<i class="fa-regular fa-image"></i> <i class="fa-solid fa-link"></i>
			<input type="file" accept="image/*" name="img">
		</label>
	</form>
	<?php
	else:
	?>
		<div id="shoutbox_login"><a href="#"><?=constant('LOGIN_REQUIRE_SHOUTBOX');?></a></div>
	<?php
	endif;
	?>
</section>
