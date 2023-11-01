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

Common::constant(array(
	#####################################
	# Fichier lang en français - Pages Groupes
	#####################################
	'GROUP_SEND_SUCCESS'  => 'Groupe ajouté avec succès.',
	'GROUP_ERROR_SUCCESS' => 'Erreur lors de la création du groupe.',
	'GROUP_NAME_RESERVED' => 'Ce nom est déjà réserve.',
	'DEL_GROUP_SUCCESS'   => 'Groupe éffacé avec succès.',
	'DEL_GROUP_ERROR'     => 'Impossible d\'effacer le groupe, problème inconnu.',
	'EDIT_GROUP_SUCCESS'  => 'Edition du groupe avec succès',
	'EDIT_GROUP_ERROR'    => 'Erreur de l\'Edition',
	'GROUP_NAME_EMPTY'    => 'Le nom de peux-être vide',
));
