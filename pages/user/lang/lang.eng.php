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
	# File lang in english - Users
	#####################################
	'ADD_YOUR_AVATAR'    => 'Add your avatar',
	'PROFIL'             => 'Profil',
	'INFO_PERSO'         => 'Infos générales',
	'EDIT_PROFIL'        => 'Edit your profile',
	'EDIT_PROFIL_SOCIAL' => 'Edit your profile social',
	'EDIT_MAIL_PASS'     => 'Edit your password & mail',
	'MANAGE_AVATAR'      => 'Manage your avatar',
	'ENTER_NAME_PSEUDO'  => 'Enter your name / pseudo',
	'YOUR_WEBSITE'       => 'Your website url',
));
