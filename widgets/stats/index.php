<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.5 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Core\Visitors;
use BelCMS\Requires\Common;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
$countPage = number_format($page, 0, ',', '.');
?>
<div id="bel_cms_widgets_connected" class="widget">
	<p>Pages vues <b><i><?=$countPage;?></i></b>  depuis le <br><?=Common::TransformDate($_SESSION['CONFIG_CMS']['CMS_DATE_INSTALL'], 'FULL', 'MEDIUM');?></p>
	<?php if ($active['users'] == true or $active['news']  == true or $active['news']  == true or $active['articles']  == true or $active['comments']   == true or $active['files']  == true or $active['files']  == true or $active['links']  == true or $active['images']): ?>
	<ul id="widgets_users">
		<?=$active['users']    == true ? '<li>Membres<span>'.$users.'</span></li>'        : ''; ?>
		<?=$active['news']     == true ? '<li>News<span>'.$news.'</span></li>'            : ''; ?>
		<?=$active['articles'] == true ? '<li>Articles<span>'.$articles.'</span></li>'    : ''; ?>
		<?=$active['comments'] == true ? '<li>Commentaire<span>'.$comments.'</span></li>' : ''; ?>
		<?=$active['files']    == true ? '<li>Fichiers<span>'.$files.'</span></li>'      : ''; ?>
		<?=$active['links']    == true ? '<li>Liens<span>'.$links.'</span></li>'          : ''; ?>
		<?=$active['images']   == true ? '<li>Images<span>'.$img.'</span></li>'           : ''; ?>
	</ul>
	<?php endif; ?>
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
					if (User::ifUserExist($v->visitor_user)) {
						if (User::getInfosUserAll($v->visitor_user)) {
							$visitor = User::getInfosUserAll($v->visitor_user)->user->username;
						}
					} else {
						if ($visitor != null) {
							$visitor = strtolower($v->visitor_user);
							$pos = strpos($visitor, 'bot') or Common::isBot($visitor) === false ? true : false; 
							if ($pos !== false) {
								$visitor = constant('VISITOR');
							} else {
								$visitor = constant('BOT');
							}
						} else {
							$visitor = strtolower($v->visitor_user);
						}
					}
					$page = defined(strtoupper($v->visitor_page)) ? constant(strtoupper($v->visitor_page)) : $v->visitor_page;
					?>
					<li>
						<span><?=$visitor;?></span>
						<span><?=$page?></span>
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
<?php
?>