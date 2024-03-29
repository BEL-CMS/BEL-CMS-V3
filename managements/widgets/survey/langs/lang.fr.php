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
	# Fichier lang en français - Pages Shoutbox
	#####################################
	'SURVEY'                      => 'Sondage',
	'ADD_SONDAGE_SUCCESS'         => 'Ajout du sondage avec succès',
	'JS'                          => 'JavaScript',
	'CSS'                         => 'Cascading Style Sheets',
	'EDIT_SURVEY_PARAM_SUCCESS'   => 'les paramètres du widgets shoutbox sont sauvegarder avec succès',
	'EDIT_SURVEY_PARAM_ERROR'     => 'Erreur durant la sauvegarde des paramètres du widgets : shoutbox',
	'ERROR_NO_DATA'               => 'Erreur de transfert de données',
	'DATE_OF_PUBLICATION'         => 'Date du vote',
	'NB'                          => 'Nombre de vote',
	'QUESTION'					  => 'Question',
	'END_VOTE'                    => 'Fin du vote',
	'NUMBER_OF_RESPONSES'         => 'Nombre de réponses',
	'PLEASE_CHOOSE_OPTION'        => '--Veuillez choisir une option--',
	'UNLIMITED'                   => 'Illimité',
	'REPLY'                       => 'Réponses'
));