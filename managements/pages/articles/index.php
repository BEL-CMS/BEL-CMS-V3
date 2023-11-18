<?php
use BelCMS\Core\Notification;
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
<div class="card">
    <div class="card-header">
        <div class="flex justify-between items-center">
            <h4 class="card-title">Pages</h4>
        </div>
    </div>
	<div class="p-6">
		<div class="flex flex-wrap gap-x-7 gap-y-3">
			<?php
			if (empty($data)) {
				Notification::alert('Aucune Page', 'warning');
			}
			foreach ($data as $key => $value):
			?>
				<a class="relative py-2.5 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-primary text-white hover:bg-primary focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800" href="Articles/getpage/<?=$value->id?>?management&option=pages">
				<?=$value->name;?>
					<span class="inline-flex items-center py-0.5 px-1.5 rounded-full text-xs font-medium bg-indigo-800 text-white">
						<?=$value->count;?>
					</span>
				</a>
			<?php
			endforeach;
			?>
		</div>
	</div>
</div>