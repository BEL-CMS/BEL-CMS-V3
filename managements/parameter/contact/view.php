<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.1 [PHP8.3]
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
<div class="flex flex-col gap-6">
	<div class="card">
		<div class="card-header">
			<div class="flex justify-between items-center">
				<h4 class="card-title"><?=constant('LIST_OF_CONFIG');?></h4>
			</div>
		</div>
		<div class="p-6">
			<div class="overflow-x-auto">
				<div class="border rounded-lg overflow-hidden dark:border-gray-700 p-2">
                    <div class="p-6">
                        <div>
                        <?php
                        echo $mail->message;
                        ?>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="flex justify-between items-center">
                <h5 class="card-title"><?=constant('INFOS');?></h5>
            </div>
        </div>
        <div class="p-6">
			<div class="overflow-x-auto">
				<div class="border rounded-lg overflow-hidden dark:border-gray-700 p-2">
                    <div style="display: flex;">
                        <table>
                            <tr>
                                <td width="100"><strong>Nom</strong></td>
                                <td><?=$mail->author;?></td>
                            </tr>
                            <tr>
                                <td width="100"><strong>Sujet</strong></td>
                                <td><?=$mail->subject;?></td>
                            </tr>
                            <tr>
                                <td width="100"><strong>Téléphone</strong></td>
                                <td><?=$mail->tel;?></td>
                            </tr>
                            <tr>
                                <td width="100"><strong>E-mail</strong></td>
                                <td><?=$mail->mail;?></td>
                            </tr>
                            <tr>
                                <td width="100"><strong>Date</strong></td>
                                <td><?=Common::TransformDate($mail->datecreate, 'FULL', 'MEDIUM');?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="Contact/replySend?management&option=parameter" method="post">
        <div class="card">
            <div class="card-header">
                <div class="flex justify-between items-center">
                <h4 class="card-title"><?=constant('REPLY_CONTACT');?></h4>
                </div>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <div class="border rounded-lg overflow-hidden dark:border-gray-700 p-2">
                        <textarea class="bel_cms_textarea_full" name="content"></textarea>
                    </div>
                    <div>
                        <div class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">
                            <input type="hidden" value="<?=$mail->id;?>" name="id">
                            <button type="submit" class="btn bg-violet-500 border-violet-500 text-white"><i class="fa fa-dot-circle-o"></i> <?=constant('SEND');?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
