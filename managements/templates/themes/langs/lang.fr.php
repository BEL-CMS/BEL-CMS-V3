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
	# Fichier lang en français - Pages thèmes
	#####################################
	'NAME_TPL'          => 'Nom du thème',
	'CREATOR'           => 'Créateur',
	'DESCRIPTION'       => 'Description',
	'VERSION'           => 'Version',
	'DATE'              => 'Date',
	'PAGE_FULL_WIDE'    => 'Page sans widgets à gauche et à droite',
	'LISTE_OF_TEMPLATE' => 'Liste des thèmes',
	'ENABLE'            => 'Activer',
	'ALREADY_ACTIVE'    => 'Déjà actif',
	'DIMENSION'         => 'Dimension',
));