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
use BELCMS\User\User;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
if (User::isLogged() === true):
?>
	<section id="belcms_section">
		<div id="belcms_mails" class="belcms_grid_full">
			<div class="belcms_grid_1">
				<ul id="belcms_mail_menu">
					<li class="belcms_pb_5">
						<a href="Mails/New" data="<?=constant('NEW_MSG');?>" class="belcms_btn belcms_bg_blue belcms_tooltip_right">
							<i class="fa-solid fa-at"></i>
						</a>
					</li>
					<li class="belcms_pb_5">
						<a href="Mails" data="<?=constant('MAILBOX');?>" class="belcms_btn belcms_tooltip_right">
						<i class="fa-solid fa-envelope-open-text"></i>
						</a>
					</li>
					<li class="belcms_pb_5">
						<a href="Mails/Archive" data="<?=constant('ARCHIVES');?>" class="belcms_btn belcms_tooltip_right">
						<i class="fa-solid fa-envelopes-bulk"></i>
						</a>
					</li>
					<li class="belcms_pb_5 active">
						<a href="Mails/Close" data="<?=constant('CLOSE_MSG');?>" class="belcms_btn belcms_tooltip_right">
							<i class="fa-solid fa-square-xmark"></i>
						</a>
					</li>
				</ul>
			</div>
			<div class="belcms_grid_4">
				<div id="belcms_mails_title" class="belcms_pb_15">
					<h3><i class="fa-solid fa-inbox"></i> <?=constant('MAILBOX');?></h3>
				</div>
				<ul id="belcms_mails_list" class="belcms_pb_10">
					<?php
					if (empty($inbox)):
					?>
					<li><?=Notification::infos(constant('NO_MESSAGE_CLOS'), null);?></li>
					<?php
					else:
					foreach ($inbox as $value):
						$date = Common::TransformDate($value['read']->date_send, 'MEDIUM', 'SHORT');
						$user = User::ifUserExist($value['data']->author_send);
						if ($user !== false) {
							$user = User::getInfosUserAll($value['data']->author_send);
							$username = $user->user->username;
							$avatar = is_file($user->profils->avatar) ? $user->profils->avatar : constant('DEFAULT_AVATAR');
						} else {
							$user   = constant('MEMBER_DELETE');
							$avatar = constant('DEFAULT_AVATAR');
						}
						$subject = empty($value['data']->subject) ? constant('NO_SUBJECT') : $value['data']->subject;
					?>
						<li>
							<div id="belcms_mails_list_screen">
								<img src="<?=$avatar;?>" alt="" data="<?=$username;?>" class="belcms_tooltip_right">
							</div>
							<div>
								<span>
									<i class="fa-solid fa-square-envelope"></i>&nbsp;<b><?=Common::truncate($subject, 30);?></b>
								</span>
								<span><i class="fa-regular fa-clock"></i>&nbsp;<?=Common::truncate($date, 30);?></span>
							</div>
						</li>
						<?php
					endforeach;
					?>
					<?php
					endif;
					?>
				</ul>
			</div>
			<div class="belcms_grid_8">
				<div id="belcms_mails_clos">
					<?php
					Notification::infos(constant('MSG_CLOSE_ALL'), constant('CLOSE_MSG'));
					?>
				</div>
			</div>
		</div>
	</section>
<?php
endif;