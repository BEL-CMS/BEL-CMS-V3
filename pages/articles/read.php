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

use BelCMS\Core\Comment;
use BelCMS\Core\Notification;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
if (empty($data)):
	Notification::warning('Erreur dans la page, imposssible de l\'afficher');
else:
	$countComment = Comment::countComments('articles', $data->id);
?>
<div id="belcms_section_articles_read">
	<div id="belcms_section_articles_main_title"><h2><?=$data->name?></h2></div>
	<div id="belcms_section_articles_main_body">
		<?=$data->content?>
	</div>
	<div id="belcms_section_articles_main_footer">
		<p><?=constant('PUBLICATION_DATE').Common::TransformDate($data->publish, 'FULL', 'MEDIUM');?></p>
	</div>
</div>
<?php
endif;
