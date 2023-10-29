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

use BelCMS\Core\Visitors as Visitors;
use BelCMS\User\User as User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<div id="bel_cms_widgets_connected" class="widget">
	<ul>
		<li>
			<span>Hier</span>
			<span><strong><?=Visitors::getVisitorYesterday()->count?></strong></span>
		</li>
		<li>
			<span>Aujourd'hui</span>
			<span><strong><?=Visitors::getVisitorDay()->count?></strong></span>
		</li>
		<li>
			<span>Maintennant</span>
			<span><strong><?=Visitors::getVisitorConnected()->count?></strong></span>
		</li>
		<li>
			<ul id="getVisitorConnected">
				<?php
				$i = 0;
				$visitor = null;
				foreach (Visitors::getVisitorConnected()->data as $k => $v):
					if (User::getInfosUserAll($v->visitor_user)) {
						$visitor = User::getInfosUserAll($v->visitor_user)->user->username;
					} else {
						$visitor = constant('VISITOR');
					}
					?>
					<li>
						<span><?=$visitor;?></span>
						<span><?=$v->visitor_page?></span>
					</li>
					<?php
					if ($i++ == 5) {
						break;
					}
				endforeach;
				?>
			</ul>
		</li>
	</ul>
</div>
