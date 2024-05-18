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
	# Fichier lang en français - Pages Blog
	#####################################
	'EDIT_BLOG_SUCCESS'       => 'News éditer avec succès',
	'EDIT_BLOG_ERROR'         => 'Erreur d\'edition',
	'ERROR_NO_DATA'           => 'Erreur de transfert de données',
	'ARTICLE'                 => 'Article',
	'COMPLEMENT'              => 'Complément',
	'NB_BLOG'                 => 'Nombre de news',
	'ERROR_NO_NUM'            => 'Erreur le texte rentrer n\'est pas du numerique',
	'EDIT_BLOG_PARAM_SUCCESS' => 'les paramètres de des news sont sauvegarder avec succès',
	'EDIT_BLOG_PARAM_ERROR'   => 'Erreur durant la sauvegarde des paramètres de la news',
	'SEND_BLOG_SUCCESS'       => 'La news été ajouté avec succès à votre site',
	'SEND_BLOG_ERROR'         => 'La page n\'a pas pu etre ajouté : erreur BDD',
	'DEL_BLOG_SUCCESS'        => 'La page de la news à été supprimé avec succès',
	'DEL_BLOG_ERROR'          => 'Erreur durant la suppression de le la news',
	'ADD_BLOG_EMPTY'          => 'Le nom ne peux-être vide',
	'ADD_BLOG_EMPTY_CONTENT'  => 'Le contenue ne peux-être vide',
	'LIST_OF_ARTICLES'        => 'Liste des news',
	'CREATION_DATE'           => 'Date de création',
	'NEW'                     => 'Nouveau',
	'READMORE_ADMIN'          => 'La suite de l\'article',
	'LIST_OF_CAT'             => 'Liste des catégories',
	'NAME_OF_CAT'             => 'Nom de la catégorie',
	'EXISTING_DATA'           => 'Le nom de la catégorie existe déjà',
	'INSERT_CAT_OK'           => 'Insertion de la catégorie avec succès',
	'EDIT_CAT_OK'             => 'Edition de la catégorie avec succès',
));