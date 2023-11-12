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

use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

Common::constant(array(
	#####################################
	# Fichier lang en français - Pages
	#####################################
	'ADDED_AN_ARTICLE' => 'Ajouté un article',
	'ADD_DOWNLOADS'    => 'Ajouté un téléchargement',
	'CONFIRM_DELETE'   => 'Confirmer la suppression : ',
	'DEL_CONFIRM'      => 'Confirmer la suppression',
	'ACCESS_TO_ADMIN'  => 'Accès aux administrateurs',
	'ACCESS_TO_GROUPS' => 'Accès aux groupes',
	'TO_REGISTER'      => 'Enregistrer',
));