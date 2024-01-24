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
	<div id="bel_cms_widgets_shoutbox" class="widget">
		<div class="widget-content">
			<ul id="bel_cms_widgets_shoutbox_msg">
				<?php
				$i = 1;
				if (count($var) != 0):
					foreach ($var as $k => $v):
						$i++;
						if (!empty($v->hash_key)) {
							$infosUser = User::getInfosUserAll($v->hash_key);
							$username  = $infosUser->user->username;
							$avatar    = empty($infosUser->profils->avatar) ? constant('DEFAULT_AVATAR') : $infosUser->profils->avatar;
							$color     = User::colorUsername($v->hash_key);
						} else {
							$username  = constant('UNKNOWN');
							$avatar    = constant('DEFAULT_AVATAR');
							$color     = constant('DEFAULT_COLOR_USERNAME');
						}

						$msg = ' ' . $v->msg;
						$msg = preg_replace("#([\t\r\n ])(www|ftp)\.(([\w\-]+\.)*[\w]+(:[0-9]+)?(/[^ \"\n\r\t<]*)?)#i", '\1<a href="http://\2.\3" onclick="window.open(this.href); return false;">\2.\3</a>', $msg);
						$msg = preg_replace("#([\n ])([a-z0-9\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $msg);
						?>
						<li id="id_<?=$v->id?>">
							<a class="belcms_tooltip_top avatar" data="<?=$username?>" href="Members/View/<?=$username?>">
								<img src="<?=$avatar?>">
							</a>
							<div class="message_wrap">
								<div class="info"> <a style="color: <?=$color?>" data-toggle="tooltip" title="<?=$username?>" href="Members/View/<?=$username?>" class="name belcms_tooltip_top" data="<?=$username?>"><?=$username?></a> <span class="time"><?=$v->date_msg?></span>
								</div>
								<div class="text"><?=Common::getSmiley($msg)?></div>
							</div>
						</li>
						<?php
					endforeach;
				endif;
				?>
			</ul>
		</div>
	<?php
	if (User::isLogged()):
	?>
	<div class="card-footer text-muted">
		<form class="alertAjaxForm" action="shoutbox/send&json" method="post">
			<div class="form-group" style="position: relative;">
				<input type="text" class="form-control" name="text" placeholder="<?=constant('YOUR_MESSAGE');?>">
			</div>
			<div class="form-group">
				<button class="btn btn-primary" type="submit"><?=constant('SEND')?></button>
			</div>
		</form>
	</div>
	<?php
	else:
	?>
	<div class="card-footer text-muted">
		<form id="Login" action="/user/sendLogin" method="post">
			<div class="form-group">
				<input name="username" required="required" autofocus="" type="text" class="form-control" id="inputEmail" placeholder="Email or username">
			</div>
			<div class="form-group">
				<input name="password" required="required" type="password" class="form-control" id="inputPassword" placeholder="Password">
			</div>
			<input type="hidden" name="send" value="login">
			<button type="submit" class="btn btn-primary">Login</button>
		</form>
	</div>
	<?php
	endif;
	?>
</div>
