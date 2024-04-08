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

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

use BelCMS\Requires\Common;

Common::constant(array(
	#####################################
	# Fichier lang en français - Pages Shoutbox
	#####################################
	'EDIT_SHOUTBOX_SUCCESS'       => 'Message éditer avec succès',
	'EDIT_SHOUTBOX_ERROR'         => 'Erreur durant l\'édition',
	'EDIT_SHOUTBOX_PARAM_SUCCESS' => 'les paramètres du widgets shoutbox sont sauvegarder avec succès',
	'EDIT_SHOUTBOX_PARAM_ERROR'   => 'Erreur durant la sauvegarde des paramètres du widgets : shoutbox',
	'ERROR_NO_DATA'               => 'Erreur de transfert de données',
	'DEL_SHOUTBOX_SUCCESS'        => 'Message supprimer avec succès',
	'DEL_SHOUTBOX_ERROR'          => 'Erreur lors de la suppression du message',
	'DEL_ALL_SHOUTBOX_SUCCESS'    => 'Suppression de tout les message avec succès',
	'DEL_ALL_SHOUTBOX_ERROR'      => 'Erreur lors de la suppression de tout les messages',
	'DEL_EMOTICON_SUCCESS'        => 'Suppression de l\'émoticône avec succès',
	'DEL_EMOTICON_ERROR'          => 'Erreur lors de la suppression de l\'émoticône',
	'JS'                          => 'Javascript',
	'CSS'                         => 'Cascading Style Sheets',
	'MAX_MSG'                     => 'Nombre de message',
	'EMOTICONS'                   => 'Émoticônes',
	'DELETE_ALL_MSG'              => 'Supprimer tous les messages',
	'LIST_EMOTICONS'              => 'Lise des émoticônes',
	'ADD_EMOTICON'                => 'Ajouter une émoticône',
	'NAME_EMOTICONE'              => 'Nom de l\'émoticône',
	'CODE'                        => 'Code',
	'DEL_EMOTICONE'               => 'Supprime l\'émoticône',
	'LOCATIONS'                   => 'Emplacements',
	'YESTERDAY'                   => 'Hier',
));
