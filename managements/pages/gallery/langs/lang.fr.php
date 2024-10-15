<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.7 [PHP8.2]
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
	# Fichier lang en français - Pages gallery
	#####################################
	'EDIT_DL_PARAM_SUCCESS' => 'Edition des parametres effecté avec succès',
	'EDIT_DL_PARAM_ERROR'   => 'Error lors de la sauvegarde des parametre',
	'ERROR_NO_DATA'         => 'Erreur de transfert de données',
	'ADD_FILE_SUCCESS'      => 'Ajouté avec succès',
	'DESCRITPION'           => 'Description',
	'GALLERY'               => 'Galerie d\'images',
	'SCREEN'                => 'Images',
	'GALLERY_CAT'           => 'Gallerie - Catégories',
	'NO_CATEGORY'           => 'Aucune catégorie',
	'CATEGORY'              => 'Catégorie',
	'GALLERY_ACTIVE'        => 'Activer la gallerie',
	'MAX_IMG'               => 'Maximum d\'images à afficher',
	'UNKNOW_IMG'            => 'Aucune image trouver',
	'SUB_CAT'               => 'Sous-Catégories',
	'PLEASE_ADD_MAIN_CAT'   => 'Veuillez ajouter une catégorie principal',
	'CHOIS_MAIN_CAT'        => 'Choisir la catégorie principal',
	'COLOR_TEXT'            => 'Couleur du texte',
	'BACK_COLOR'            => 'Couleur du fond',
	'PLEASE_ADD_NAME'       => 'Il manque le nom de la catégorie',
	'ALERT_ADMIN'           => 'les administrateurs sont automatiquement mis, même en décochant.',
	'A_VALID'               => 'A validé',
	'EMPTY_ALL'             => 'Vider tout',
	'SENT_BY'               => 'Envoyé par',
	'IMAGES'                => 'Images',
	'ACCEPT_ALL'            => 'Accepter tout',
	'ACTIONS'               => 'Actions',
	'DELETE_SUCCESS'        => 'Tous les éléments sont effacés',
	'ACCEPTE'               => 'Accepter l\'image',
	'CHOIS_CAT'             => 'Chosir la catégorie',
	'DEPLACE_ACTIF'         => 'Déplacement en actif',
));