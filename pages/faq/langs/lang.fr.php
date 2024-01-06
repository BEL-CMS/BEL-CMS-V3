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

namespace BELCMS\LANG;
use BelCMS\Requires\Common as Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

Common::constant(array(
	#####################################
	# Fichier lang en français - FAQ
	#####################################
    'GET_YOU_QUESTION'       => 'Obtenez des réponses à vos questions',
    'FIND_ANSWERS_SEARCH'    => 'Trouvez ci-dessous les réponses aux questions les plus fréquemment posées.',
    'SEARCH_AND_PRESS_ENTER' => 'Rechercher et appuyer sur enter, laisser le champ vide pour revenir au début',
    'NO_INFO_LOOKING'        => 'Aucune information à votre recherche',
));