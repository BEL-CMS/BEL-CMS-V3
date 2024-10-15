<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.1.0 [PHP8.3]
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

Common::constant(array(
	#####################################
	# Fichier lang en français - Pages Téléchargements
	#####################################
	'DATE_OF_PUBLICATION'  => 'Date de publication',
	'THE_CONTENT_QUESTION' => 'Le contenu de la question.',
	'CATEGORY_NAME'        => 'Nom de la catégorie',
	'EMPTY_NAME_OR_ID'     => 'L\'ID ou le nom est incorrecte',
	'FAQ_PAGE_ACTIVE'      => 'Activer la page FAQ',
	'FAQ_ACTIVE'           => 'Paramètre activation',
));