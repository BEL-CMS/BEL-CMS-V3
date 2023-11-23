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
					<li class="belcms_pb_5 active">
						<a href="Mails" data="<?=constant('MAILBOX');?>" class="belcms_btn belcms_tooltip_right">
						<i class="fa-solid fa-envelope-open-text"></i>
						</a>
					</li>
					<li class="belcms_pb_5">
						<a href="Mails/Archive" data="<?=constant('ARCHIVES');?>" class="belcms_btn belcms_tooltip_right">
						<i class="fa-solid fa-envelopes-bulk"></i>
						</a>
					</li>
					<li class="belcms_pb_5">
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
					<li><?=Notification::infos(constant('NO_MESSAGE'), null);?></li>
					<?php
					else:
                        $mail_id = current($inbox);
                        $_SESSION['MAIL_ID'] = $mail_id['data']->mail_id;
					foreach ($inbox as $value):
						if ($value['data']->archive_receives == 0):
                            $lastMsg = end($value['read']);
							$date = Common::TransformDate($lastMsg->date_send, 'MEDIUM', 'SHORT');
							$user = User::ifUserExist($value['data']->author_send);
							if ($user !== false) {
								$user = User::getInfosUserAll($value['data']->author_send);
								$username = $user->user->username;
								$avatar = is_file($user->profils->avatar) ? $user->profils->avatar : constant('DEFAULT_AVATAR');
							} else {
								$user   = constant('MEMBER_DELETE');
								$avatar = constant('DEFAULT_AVATAR');
							}
							$subject   = empty($value['data']->subject) ? constant('NO_SUBJECT') : $value['data']->subject;
							$color     = $value['data']->read_msg_receives == 1 ? 'iNew':'Iview';
							if ($value['data']->author_send == $_SESSION['USER']->user->hash_key) {
								$color     = $value['data']->read_msg_send == 1 ? 'iNew':'Iview';
								$textRead  = $value['data']->read_msg_send == 0 ? constant('UNREAD_MESSAGE') : constant('MESSAGE_READ');
							} else if ($value['data']->author_receives == $_SESSION['USER']->user->hash_key) {
								$color     = $value['data']->read_msg_receives == 1 ? 'iNew':'Iview';
								$textRead  = $value['data']->read_msg_receives == 1 ? constant('MESSAGE_READ') : constant('UNREAD_MESSAGE');
							}
							?>
							<li>
								<div id="belcms_mails_list_screen">
									<img src="<?=$avatar;?>" alt="" data="<?=$username;?>" class="belcms_tooltip_right">
								</div>
								<div>
									<span>
										<b data="<?=$textRead;?>" class="<?=$color;?> belcms_tooltip_right"><i class="fa-solid fa-square-envelope"></i></b>&nbsp;
										<a href="Mails/Read/<?=$value['data']->mail_id;?>" data="<?=constant('READ');?>" class="belcms_tooltip_right">
											<?=Common::truncate($subject, 30);?>
										</a>
									</span>
									<span><i class="fa-regular fa-clock"></i>&nbsp;<?=Common::truncate($date, 30);?></span>
									<a href="Mails/Remove/<?=$value['data']->mail_id;?>" title="<?=constant('DELETE');?>">
										<i class="fa-solid fa-trash-can"></i>
									</a>
								</div>
							</li>
						<?php
						endif;
					endforeach;
					?>
					<?php
					endif;
					?>
				</ul>
			</div>
			<div class="belcms_grid_8" style="display: block;">
                <div id="belcms_mails_list_read">
                    <?php
                    foreach ($inbox as $value):
                        foreach ($value['read'] as $k => $read):
                            $clock = Common::TransformDate($read->date_send, 'MEDIUM', 'MEDIUM');
                            $user  = User::getInfosUserAll($read->author_send);
                        ?>
                        <div class="belcms_mails_list_read">
                            <div class="belcms_mails_list_read_infos">
                                <ul>
                                    <li><i class="fa-solid fa-user-pen"></i>&nbsp;<?=$user->user->username;?>
                                    <li><i class="fa-regular fa-clock"></i>&nbsp;<?=$clock;?></li>
                                </ul>
                            </div>
                            <div class="belcms_mails_list_read_msg">
                                <?=Common::decrypt($read->message, $read->mail_id);?>
								<?php
								if (!empty($read->upload)):
								?>
									<div class="attachment">
										<a href="<?=$read->upload?>" target="_blank"><i class="fa-regular fa-floppy-disk"></i>&ensp;<?=constant('FILE');?></a> (<?=Common::SizeFile(ROOT.$read->upload)?>)
									</div>
								<?php
								endif;
								?>
                            </div>
                        </div>
                        <?php 
                        endforeach;
                    ?>
                    <?php
                    endforeach;
                    ?>
                </div>
                <a id="belcms_mails_list_reply" href="Mails/Reply/<?=$_SESSION['MAIL_ID'];?>" data="<?=constant('REPLY');?>" class="belcms_tooltip_top" class="belcms_btn">
                    <i class="fa-solid fa-envelope-open-text"></i>&nbsp;<?=constant('REPLY');?>
                </a>
                <a id="belcms_mails_list_archive" href="Mails/SendArchive/<?=$_SESSION['MAIL_ID'];?>" data="<?=constant('ARCHIVES');?>" class="belcms_tooltip_top" class="belcms_btn">
                <i class="fa-solid fa-boxes-packing"></i>&nbsp;<?=constant('ARCHIVES');?>
                </a>
			</div>
		</div>
	</section>
<?php
endif;