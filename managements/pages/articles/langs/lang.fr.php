<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2023 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

Common::constant(array(
	#####################################
	# Fichier lang en français - Page
	#####################################
	'SEND_PAGE_SUCCESS'         => 'Page ajouté avec succès',
	'SEND_PAGE_ERROR'           => 'Erreur lors de l\'ajout de la page',
	'ERROR_NO_DATA'             => 'Erreur de transfert de données',
	'EDIT_PAGE_SUCCESS'         => 'Edition de la page effectué avec succès',
	'EDIT_PAGE_ERROR'           => 'Erreur lors de l\'edition de la page',
	'DEL_SUBPAGE_SUCCESS'       => 'Suppression de la sous-page effectué avec succès',
	'DEL_SUBPAGE_ERROR'         => 'Erreur lors de la suppression de la page',
	'DEL_PAGE_SUCCESS'          => 'Suppression de la pageet sous page effectué avec succès',
	'PAGE_NUMBER' 			    => 'Numéro de la page',
	'DATE_OF_PUBLISH'           => 'Date de publication',
	'DEL_ALL'                   => 'Tout effacer',
	'CODE_HTML'                 => 'Code HTML',
	'NAME_PAGE'                 => 'Nom de la page',
	'PRIO'                      => '<!> Si du code est utilisé, il sera prioritaire !',
	'CONFIRM_DEL'               => 'Confirmer la suppression de la page :',
	'ARTICLES_PAGE_ACTIVE'      => 'Activer la page articles',
	'ARTICLES_ACTIVE'          => 'Articles actif',
));