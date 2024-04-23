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
                        <?=$reply->message;?>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
        <div class="p-6">
			<div class="overflow-x-auto">
				<div class="border rounded-lg overflow-hidden dark:border-gray-700 p-2">
                    <div style="display: flex;">
                        <table>
                            <tr>
                                <td width="100"><strong>Nom</strong></td>
                                <td><?=$reply->author;?></td>
                            </tr>
                            <tr>
                                <td width="100"><strong>Sujet</strong></td>
                                <td><?=$reply->subject;?></td>
                            </tr>
                            <tr>
                                <td width="100"><strong>Téléphone</strong></td>
                                <td><?=$reply->tel;?></td>
                            </tr>
                            <tr>
                                <td width="100"><strong>E-mail</strong></td>
                                <td><?=$reply->mail;?></td>
                            </tr>
                            <tr>
                                <td width="100"><strong>Date</strong></td>
                                <td><?=Common::TransformDate($reply->datecreate, 'FULL', 'MEDIUM');?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="card">
		<div class="card-header">
			<div class="flex justify-between items-center">
				<h4 class="card-title"><?=constant('LIST_OF_SORTING_MAIL');?></h4>
			</div>
		</div>
        <?php
        foreach ($reply->reply as $key => $value):
        ?>
            <div class="p-6">
			<div class="overflow-x-auto">
				<div class="border rounded-lg overflow-hidden dark:border-gray-700 p-2">
                    <div class="p-6">
                        <div>
                        <?=$value->message;?>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
        <?php
        endforeach;
        ?>
    </div>
</div>