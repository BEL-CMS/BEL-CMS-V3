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

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
$link_current  = $this->vars['current'];
$link_user     = null;
$link_safety   = null;
$link_security = null;
$link_social   = null;
switch ($link_current) {
	case 'user':
		$link_user     = 'class="belcms_btn belcms_bg_blue"';
	break;
	case 'safety':
		$link_safety   = 'class="belcms_btn belcms_bg_blue"';
	break;
	case 'security':
		$link_security = 'class="belcms_btn belcms_bg_blue"';
	break;
	case 'social':
		$link_social   = 'class="belcms_btn belcms_bg_blue"';
	break;
	default:
	break;
}
?>

                                <nav id="belcms_section_user_nav">
                                	<ul>
                                		<li>
                                			<a <?=$link_user?> href="User">Infos Personnel</a>
										</li>
										<li>
											<a <?=$link_safety?> href="User/safety">Confidentialité</a>
										</li>
										<li>
											<a <?=$link_security?> href="User/security">Sécurité</a>
										</li>
										<li>
											<a <?=$link_social?> href="User/social">Liens Social</a>
										</li>
										<li>
											<a class="belcms_bg_red" href="User/logout">Déconnexion</a>
										</li>	
									</ul>
								</nav>
