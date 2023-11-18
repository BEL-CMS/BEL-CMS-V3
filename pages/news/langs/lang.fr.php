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

namespace BELCMS\LANG;
use BelCMS\Requires\Common as Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

Common::constant(array(
	#####################################
	# Fichier lang en français - Blog
	#####################################
	'NO_POST'               => 'No Posts Found',
	'TAGS'                  => 'Tags',
	'READ_MORE'             => 'Lire la suite',
	'NAME_OF_THE_UNKNOW'    => 'Nom ou ID de la page inconnu',
	#####################################
	# Fichier lang en français - Admin
	#####################################
	'NEW_BLOG_ERROR'        => 'Une erreur est survenue durant l\'enregistrement en BDD.',
	'NEW_BLOG_SUCCESS'      => 'Ajout de l\'article ajouter avec succès.',
	'DEL_BLOG_SUCCESS'      => 'Suppression du blog avec succès',
	'DEL_BLOG_ERROR'        => 'Erreur lors de la suppresion du blog',
	'EDIT_BLOG_SUCCESS'     => 'Edition du blog avec succès',
	'EDIT_BLOG_ERROR'       => 'Erreur durant l\'edition de l\'article',
	'NB_BLOG'               => 'Maximum d\'article à afficher',
	'NB_BLOG_ADMIN'         => 'Maximum d\'article à afficher (Admin)',
	'SEEN'                  => 'Vu',
	'POST_BY'               => 'Postée par'
));
