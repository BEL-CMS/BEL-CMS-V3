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

use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<div class="grid lg:grid-cols-2 gap-6">
	<div class="card">
		<div class="card-header">
			<div class="flex justify-between items-center">
				<h4 class="card-title"><?=constant('LIST_OF_NEWSLETTER');?></h4>
			</div>
		</div>
		<div class="p-6">
            <form action="newsletter/sendnewtpl?management&option=pages" method="post">
                <div class="mt-2 mb-2">
                    <label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('NAME');?></label>
                    <input name="name" type="text" class="form-input">
                </div>
                <div class="mt-2 mb-2">
					<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('TPL');?></label>
					<textarea class="bel_cms_textarea_full" name="tpl"></textarea>
				</div>
                <div class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">
					<button type="submit" class="btn bg-violet-500 border-violet-500 text-white"><i class="fa fa-dot-circle-o"></i> <?=constant('SAVE');?></button>
				</div>
            </form>
        </div>
    </div>
	<div class="card">
		<div class="card-header">
			<div class="flex justify-between items-center">
				<h4 class="card-title"><?=constant('LIST_OF_VARIABLE');?></h4>
			</div>
		</div>
		<div class="p-6">
            <table>
                <tr style="width:100%;">
                    <td style="display:block;margin-right:10px;font-weight: bold;"><b>{{user}}</b></td>
                    <td>&nbsp;Nom d'utilisateur</td>
                </tr>
                <tr>
                    <td style="display:block;margin-right:10px;font-weight: bold;"><b>{{lastvisit}}</b></td>
                    <td>&nbsp;Dernière visite</td>
                </tr>
                <tr>
                    <td style="display:block;margin-right:10px;font-weight: bold;"><b>{{maingroup}}</b></td>
                    <td>&nbsp;Groupe primaire</td>
                </tr>
            </table>
        </div>
    </div>
</div>