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
	# Fichier lang en français - Pages
	#####################################
	'ADDED_AN_ARTICLE'            => 'Ajouté un article',
	'ADD_DOWNLOADS'               => 'Ajouté un téléchargement',
	'CONFIRM_DELETE'              => 'Confirmer la suppression : ',
	'DEL_CONFIRM'                 => 'Confirmer la suppression',
	'ACCESS_TO_ADMIN'             => 'Accès aux administrateurs',
	'ACCESS_TO_GROUPS'            => 'Accès aux groupes',
	'TO_REGISTER'                 => 'Enregistrer',
	'PARAMETER_EDITING_SUCCESS'   => 'Édition des paramètre avec succès',
	'EDIT_PARAM_ERROR'            => 'Erreur lors de la sauvegarde des paramètre',
	'ACTIVE_WIDGETS'              => 'Activer le widget',
	'EDIT_PARAM_SUCCESS'          => 'Édition des paramètres avec succès',
	'DROP_FILES_CLICK_OR_UPLOADS' => 'Déposez les fichiers ici ou cliquez pour télécharger.',
	'SEND_FILES'                  => 'Envoyer les fichiers',
	'DEL_BDD_ERROR'               => 'Erreur lors du transfert en base de données',
	'SEND_BDD_PARTIEL'            => 'Envoie en base de données partiellement',
	'NO_CATEGORY'                 => 'Aucune catégorie',
	'NO_ACCESS_ADMIN'             => 'La page demander n\'est accesible qu\'aux administrateur de niveau 1',
	'EDITING_SUCCESS'             => 'Édition effectue avec succès',
	'EDIT_ERROR'                  => 'Erreur lors de la sauvegarde ou rien à changer dans le formulaire.',
	'ID_ERROR'                    => 'ID Incorrecte, un message sera transmis aux administrateurs',
	'DEL_SUCCESS'                 => 'Effacement effectué avec succès.',
	'DEL_ERROR'                   => 'Erreur lors de la suppression',
	'ERROR_NO_DATA'               => 'Aucune donnée transmise',
	'CATEGORY'                    => 'Catégories',
	'SEND_EDIT_SUCCESS'           => 'Édition a été effectuée avec succès',
	'ACTIVE'                      => 'Activer',
	'CAT_IS_REQUIRED'             => 'Une catégorie est obligatoire.',
	'QUESTION'                    => 'Question',
	'SEND_SUCCESS'                => 'Insertion en base de donnée avec succès',
	'EMPTY_NAME'                  => 'Aucun nom transmis ?',
));