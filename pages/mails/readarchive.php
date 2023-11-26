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
			<div class="belcms_grid_12" style="display: block;">
                <div id="belcms_mails_list_read">
                    <?php
                    foreach ($inbox['read'] as $value):
                            $clock = Common::TransformDate($value->date_send, 'FULL', 'MEDIUM');
                            $user  = User::getInfosUserAll($value->author_send);
                        ?>
                        <div class="belcms_mails_list_read">
                            <div class="belcms_mails_list_read_infos">
                                <ul>
                                    <li><i class="fa-solid fa-user-pen"></i>&nbsp;<?=$user->user->username;?>
                                    <li><i class="fa-regular fa-clock"></i>&nbsp;<?=$clock;?></li>
                                </ul>
                            </div>
                            <div class="belcms_mails_list_read_msg">
                                <?=Common::decrypt($value->message, $value->mail_id);?>
								<?php
								if (!empty($value->upload)):
								?>
									<div class="attachment">
										<a href="<?=$value->upload?>" target="_blank"><i class="fa-regular fa-floppy-disk"></i>&ensp;<?=constant('FILE');?></a> (<?=Common::SizeFile(ROOT.$read->upload)?>)
									</div>
								<?php
								endif;
								?>
                            </div>
                        </div>
                    <?php 
                    endforeach;
                    ?>
                </div>
			</div>
		</div>
	</section>
<?php
endif;