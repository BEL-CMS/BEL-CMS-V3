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

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

Common::constant(array(
	#####################################
	# Fichier lang en français - Users
	#####################################
	'ADD_YOUR_AVATAR'              => 'Ajouter votre avatar',
	'PROFIL'                       => 'Profil',
	'INFO_PERSO'                   => 'Infos générales',
	'EDIT_PROFIL'                  => 'Editer le profil',
	'EDIT_PROFIL_SOCIAL'           => 'Editer le profil social',
	'EDIT_MAIL_PASS'               => 'Editer le mot de passe & e-mail',
	'MANAGE_AVATAR'                => 'Vos avatars',
	'SIGNED_UP'                    => '',
	'FRIENDS'                      => 'Amis',
	'FRIEND'                       => 'Ami',
	'DATE_INSCRIPTION'             => 'Date d\'inscription',
	'ENTER_NAME_PSEUDO'            => 'Enter votre nom / pseudo',
	'YOUR_WEBSITE'                 => 'Votre site web (url)',
	'ENTER_YOUR'                   => 'Entrer votre',
	#####################################
	# Fichier lang en français - Admin
	#####################################
	'LAST_VISIT'                   => 'Dernière visite',
	'NB_USER'                      => 'Maximum d\'utilisateur à afficher',
	'NB_USER_ADMIN'                => 'Maximum d\'utilisateur à afficher (Admin)',
	'DEL_USER_SUCCESS'             => 'Suppression de l\'utilisateur avec succès',
	'DEL_USER_ERROR'               => 'Erreur lors de la suppresion de l\'utilisateur',
	'MAIN_GROUP'                   => 'Groupe principal',
	'GROUPS'                       => 'Groups',
	'PRIVATE'                      => 'Priver',
	'SOCIAL'                       => 'Social',
));