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
	# Fichier lang en français - Pages Téléchargements
	#####################################
	'SEND_NEWCAT_SUCCESS'   => 'Catégorie ajouter avec succès',
	'SEND_NEWCAT_ERROR'     => 'Erreur lors de l\'ajout de la Catégorie',
	'SEND_EDITCAT_SUCCESS'  => 'Catégorie editer avec succès',
	'SEND_EDITCAT_ERROR'    => 'Erreur lors de l\'édition de la Catégorie',
	'DEL_CAT_SUCCESS'       => 'Suppression de la catégorie effectué avec succès',
	'EDIT_DL_PARAM_SUCCESS' => 'Edition des parametres effectué avec succès',
	'EDIT_FILE_SUCCESS'     => 'Édition de l\'upload effectué avec succès',
	'EDIT_DL_PARAM_ERROR'   => 'Error lors de la sauvegarde des parametre',
	'DEL_CAT_ERROR'         => 'Erreur lors de la suppression de la catégorie',
	'DEL_FILE_SUCCESS'      => 'Fichier effacer avec succès',
	'DEL_FILE_ERROR'        => 'Erreur lors de la suppression du fichier',
	'ADD_FILE_SUCCESS'      => 'Ajout du fichier avec succès',
	'ERROR_NO_DATA'         => 'Erreur de transfert de données',
	'DATE_OF_PUBLICATION'   => 'Date de publication',
	'ADDCAT'                => 'Ajouter une Câtégorie',
	'SCREEN'                => 'Image',
	'DOWNLOAD'              => 'Téléchargement',
	'DOWNLOADS'             => 'Téléchargements',
	'DOWNLOAD_ACTIVE'       => 'Téléchargement actif',
	'DOWNLOAD_PAGE_ACTIVE'  => 'Activer la page téléchargements',
	'NB_DL'                 => 'Nombre de téléchargement',
));