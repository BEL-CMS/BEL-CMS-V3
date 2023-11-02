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
	'EDIT_BLOG_SUCCESS'       => 'Blog éditer avec succès',
	'EDIT_BLOG_ERROR'         => 'Erreur d\'edition',
	'ERROR_NO_DATA'           => 'Erreur de transfert de données',
	'ARTICLE'                 => 'Article',
	'COMPLEMENT'              => 'Complément',
	'NB_BLOG'                 => 'Nombre d\'articles',
	'ERROR_NO_NUM'            => 'Erreur le texte rentrer n\'est pas du numerique',
	'EDIT_BLOG_PARAM_SUCCESS' => 'les paramètres de l\'article sont sauvegarder avec succès',
	'EDIT_BLOG_PARAM_ERROR'   => 'Erreur durant la sauvegarde des paramètres de l\'articles',
	'SEND_BLOG_SUCCESS'       => 'La page été ajouté avec succès à votre articles',
	'SEND_BLOG_ERROR'         => 'La page n\'a pas pu etre ajouté : erreur BDD',
	'DEL_BLOG_SUCCESS'        => 'La page de l\'article à été supprimé avec succès',
	'DEL_BLOG_ERROR'          => 'Erreur durant la suppression de l\'article',
	'ADD_BLOG_EMPTY'          => 'Le nom ne peux-être vide',
	'ADD_BLOG_EMPTY_CONTENT'  => 'Le contenue ne peux-être vide',
	'DEL_CONFIRM'             => 'Confirmer la suppression',
	'LIST_OF_ARTICLES'        => 'Liste des articles',
	'CREATION_DATE'           => 'Date de création',
	'NEW'                     => 'Nouveau',
));