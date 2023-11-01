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
	'EDIT_MAIL_PASS'               => 'Edition de e-mail & password',
	'ERROR_API_KEY'                => 'Erreur PASS API',
	'EMPTY_DATA'                   => 'Aucune données transmise',
	'UNKNOW_USER_MAIL_PASS'        => 'Les champs nom d\'utilisateur & e-mail & mot de passe doivent être rempli',
	'NO_MAIL_ALLOWED'              => 'Les emails jetables ne sont pas autorisés',
	'SECURE_CODE_FAIL'             => 'Le code de sécurité est incorrect',
	'MIN_THREE_CARACTER'           => 'Le nom d\'utilisateur est trop court, minimum 3 caractères',
	'MAX_CARACTER'                 => 'Le nom d\'utilisateur est trop long, maximum 32 caractères',
	'PASS_CONFIRM_NOT_SAME'        => 'Le mot de passe et la confirmation ne sont pas identiques',
	'CURRENT_RECORD'               => 'Enregistrement en cours,...',
	'THIS_NAME_OR_PSEUDO_RESERVED' => 'Ce nom d\'utilisateur est déjà réservé.',
	'THIS_MAIL_IS_ALREADY_RESERVED'=> 'Ce courriel est déjà réservé.',
	'MODIFY_SOCIAL_SUCCESS'        => 'Liens sociaux modifier avec succès',
	'SEND_PASS_IS_OK'              => 'Le mot de passe a été enregistré',
	'OLD_PASS_FALSE'               => 'L\'ancien mot de passe de conrespond pas',
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