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
	# Fichier lang en français - Inbox
	#####################################
	'INBOX'                  => 'Boîte de réception',
	'TO_WRITE'               => 'Écrire',
	'ALL_MESSAGE'            => 'Tous les messages',
	'NEW_MESSAGE'            => 'Nouveau message',
	'ENTER_USERNAME'         => 'Saisir un nom d\'utilisateur',
	'ENTER_MESSAGE'          => 'Saisir votre message',
	'TO_SEND'                => 'Envoyer',
	'DELETE_TO_MSG'          => 'Effacer le message',
	'MESSAGE_SUCCESS'        => 'Message enregistré avec succès.',
	'ERROR_BE_SAME'          => 'Vous ne pouvez pas envoyer un message à vous-même.',
	'ERROR_EMPTY_MSG'        => 'Vous ne pouvez pas envoyer un message vide',
	'ERROR_HASH_KEY_MSG'     => 'Vous ne pouvez pas lire ce message !',
	'ERROR_NO_MESSAGE_EXIST' => 'Ce message n\'existe pas.',
	'REPLY'                  => 'Répondre',
));
