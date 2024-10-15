<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.1.0 [PHP8.3]
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
    'YESTERDAY'           => 'Hier',
    'TODAY'               => 'Aujourd\'hui',
    'NOW'                 => 'Maintenant',
    'PAGE_VIEW'           => 'Page vues',
    'REGISTERED_MEMBERS'  => 'Membres enregistrés',
    'NEWS_PUBLISHED'      => 'News publiées',
    'PUBLISHED_ARTICLES'  => 'articles publiés',
    'COMMENTS_POSTED'     => 'Commentaires postés',
    'SAVED_LINKS'         => 'Liens enregistrés',
    'SAVED_FILES'         => 'Fichiers enregistrés',
    'RECCORD_IMAGES'      => 'Images enregistrées',
    'ACTIVE'              => 'Activer',
    'DISABLE'             => 'Désactiver',
    'THE_VIEW_NO_REFLECT' => 'La vue ici, ne reflète pas le même style sur le site.',
    'ARRANGEMENT'         => 'Disposition',

));