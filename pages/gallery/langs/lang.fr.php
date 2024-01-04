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

namespace BELCMS\LANG;
use BelCMS\Requires\Common as Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

Common::constant(array(
	#####################################
	# Fichier lang en français - Pages gallery
	#####################################
    'NO_IMAGES_IN_DATABASE' => 'Aucune image dans la base de données',
	'ADD_FILE_SUCCESS'      => 'Ajouté avec succès',
	'DESCRITPION'           => 'Description',
	'GALLERY'               => 'Gallerie d\'images',
	'SCREEN'                => 'Images',
	'GALLERY_CAT'           => 'Gallerie - Catégories',
	'NO_CATEGORY'           => 'Aucune catégorie',
	'CATEGORY'              => 'Catégorie',
	'GALLERY_ACTIVE'        => 'Activer la gallerie',
	'MAX_IMG'               => 'Maximum d\'images à afficher',
	'UNKNOW_IMG'            => 'Aucune image trouver',
));