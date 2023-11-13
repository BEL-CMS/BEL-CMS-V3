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
	# Fichier lang en français - Pages Blog
	#####################################
	'CATEGORY'                 => 'Catégorie',
	'ICON'                     => 'Icône',
	'ICONS'                    => 'Icônes',
	'SUBTITLE'                 => 'Sous-titre',
	'NB_MSG'                   => 'Nombre de message',
	'ERROR_NO_CAT'             => 'Erreur : pas de catégorie',
	'NEW_CAT_SUCCESS'          => 'Catégorie ajouté avec succès',
	'NEW_CAT_ERROR'            => 'Erreur lors de l\'ajout de la catégorie',
	'ERROR_NO_DATA'            => 'Erreur de l\'envoie de données',
	'CAT_IF_EXIST'             => 'La catégorie existe déjà !',
	'NEW_THREADS_SUCCESS'      => 'Ajout du sous forum avec succès',
	'NEW_THREADS_ERROR'        => 'Erreur lors de la création du sous-forum',
	'ERROR_TITLE_EMPTY'        => 'Erreur titre vide',
	'EDIT_THREADS_SUCCESS'     => 'Edition du sous-forum éffectué avec succès',
	'EDIT_THREADS_ERROR'       => 'Erreur lors de l\'édition du thread',
	'DEL_THREADS_SUCCESS'      => 'Effacement du sous-forum éffectué avec succès',
	'DEL_THREADS_ERROR'        => 'Erreur lors de la suppression du sous-forum',
	'ERROR_ID_EMPTY_INT'       => 'Erreur ID Vide !',
	'EDIT_CAT_SUCCESS'         => 'Edition de la catégorie avec succès',
	'EDIT_CAT_ERROR'           => 'Erreur durant l\'edition de la catégorie',
	'NO_ACCESS_CAT'            => 'Vous n\'avez pas accès à cette catégorie.',
	'DEL_CAT_SUCCESS'          => 'Suppresion de la catégorie avec succès',
	'DEL_CAT_ERROR'            => 'Erreur lors de la suppression de la catégorie',
	'NB_MSG_FORUM'             => 'Nombre de message dans la page forum',
	'EDIT_FORUM_PARAM_SUCCESS' => 'Édition des paramètres avec succès',
	'EDIT_FORUM_PARAM_ERROR'   => 'Erreur lors de l\'édition des parametres',
	'ALL_MSG'                  => 'Tout les messages',
	'EDIT_SUCCESS'             => 'Edition du post avec succès',
	'EDIT_FALSE'               => 'Erreur durant le processus de sauvegarde',
	'SUPP_SUCCESS'             => 'Supression du message avec succès',
	'SUPP_FALSE'               => 'Erreur lors de la suppression du message',
	'ADD_CAT'                  => 'Ajouter une catégorie',
	'FORUM_SUB_CAT_ACTIVE'     => 'Activer la sous-catégorie',
	'FORUM_ACTIVE'             => 'Forum actif',
	'NB_POST'                  => 'Nombre de message',
));