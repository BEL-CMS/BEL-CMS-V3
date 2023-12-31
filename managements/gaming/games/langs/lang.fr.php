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

if (!defined('CHECK_INDEX')) {
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
}

use BelCMS\Requires\Common;

Common::constant(array(
	#####################################
	# Fichier lang en français - Pages game
	#####################################
	'ADMIN_NAMEPAGE'          => 'Administration de la page jeux',
	'DEL_GAME_SUCCESS'        => 'Effacement du jeu avec succès',
	'DEL_GAME_ERROR'          => 'Erreur lors de l\'éfacement du jeu',
	'DEL_CONFIRM_GAME'        => 'Confirmer la suppression du jeu',
	'ADD_GAMES'               => 'Ajouter un jeu',
	'EDIT_GAMES'              => 'Editer le jeu',
	'TITLE_GAME'              => 'Titre du jeu',
	'BANNER'                  => 'Bannière',
	'ICON'                    => 'Icône',
	'GAMES_ACTIVE'            => 'Activer la page Gaming',
	'NB_GAME'                 => 'Nombre de jeux à afficher par page',
	'EDIT_GAME_PARAM_SUCCESS' => 'Édition des paramètres effectués avec succès',
));