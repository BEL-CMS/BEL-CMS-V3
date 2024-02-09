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
	# Fichier lang en français - Page Newsletter
	#####################################
	'SEND_TEMPLATE_SUCCESS' => 'Ajout du template newsletter avec succès',
	'SEND_TEMPLATE_ERROR'   => 'Erreur lors de l\'ajout du template newsletter',
	'DEL_TEMPLATE_SUCCESS'  => 'Effacement du template éffectué avec succès',
	'DEL_TEMPLATE_ERROR'    => 'Erreur lors de la suppression du templates',
	'LIST_OF_NEWSLETTER'    => 'Liste des membres de la newletter',
	'REGISTERED'            => 'Date d\'inscription',
	'TPL'                   => 'Templates',
	'LIST_OF_TPL'           => 'Liste des templates',
	'ADD_TPL_OK'            => 'Ajout du template avec succès',
	'ADD_TPL_ERROR'         => 'Une erreur, c\'est produite durant la sauvegarde en base de donnée',
	'ADD_TPL_ERROR_ARRAY'   => 'Un tableau associatif array est attendu ?',
	'TITLE_EDIT'            => 'Edition d\'un template',
	'EDIT_TPL_OK'           => 'Edition du template avec succès',
	'EDIT_TPL_ERROR'        => 'Erreur lors de l\'édition du template ou rien à changer',
	'DEL_TPL_OK'            => 'Suppression du template avec succès',
	'DEL_TPL_ERROR'         => 'Une erreur s\'est produite lors de la suppression',
	'VIEW_TPL'              => 'Voir le template',
	'PREPA'                 => 'Préparation',
	'PLANNING'              => 'Préparation',
	'ALLMAIL'               => 'Tout les e-mails',
	'ALL_NEWS'              => 'Aux inscrits à la Newsletter',
	'PREPA_TPL_OK'          => 'Préparation du mail avec succès',
	'PREPA_TPL_ERROR'       => 'Une erreur, c\'est produit lors de l\'enregistrement en BDD',
	'NAME_OF_TPL'           => 'Nom du template',
	'HOME_NEWSLETTER'       => 'Accueil newsletter',
	'LIST_OF_VARIABLE'      => 'Liste des variables prédéfinie',
	'MAIL_SEND_OK'          => 'Les e-mails ont bien été envoyés',
	'MAIL_SEND_NOK'         => 'Il y a un souci lors de l\'envoi des mails',

));