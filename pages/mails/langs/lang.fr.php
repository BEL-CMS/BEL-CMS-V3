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
	# Fichier lang en français - Mail
	#####################################
	'NEW_MSG'    	          => 'Nouveau message',
	'MAILBOX'    	          => 'Boîte de réception',
	'SENT_MSG'   	          => 'Messages envoyés',
	'CLOSE_MSG'               => 'Conversations supprimé',
	'NO_MESSAGE_CLOS'         => 'Aucune conversations clos',
	'MSG_CLOSE_ALL'           => 'Les conversations sont automatiquement supprimées de la boite, quand les deux auront mis clos au sujet.', 
	'ARCHIVES'   	          => 'archives',
	'READ'       	          => 'Lire',
	'NO_MESSAGE' 	          => 'Aucun message',
	'NO_SUBJECT' 	          => 'Pas de sujet',
	'MESSAGE_SUBJECT'         => 'Sujet du message',
	'RECIPIENT'               => 'Destinataire',
	'MESSAGE'                 => 'Message',
	'USER_FALSE'              => 'Membre inconnu !',
	'MESSAGE_SUCCESS'         => 'Message envoyé avec succès',
	'ERROR_INSERT_BDD'        => 'Erreur lors d\'envoi a la base de donnée',
	'ERROR_NO_DATA'           => 'Aucune donnée transmise',
	'REPLY'                   => 'Répondre',
	'NO_ARCHIVE_MESSAGE'      => 'Aucun message archiver',
	'MESSAGE_ARCHIVE_SUCCESS' => 'Message archiver',
	'MESSAGE_READ'            => 'Message lu',
	'UNREAD_MESSAGE'          => 'Message non lu',
	'MESSAGE_DELETE_SUCCESS'  => 'Message mis dans la boite supprimé',
	'MESSAGE_REPLY_CLOS'      => 'Impossible de répondre au sujet, la destinataire a fermé le message.<br>Retour dans votre boite de réception dans 3s',
	'SUBCRIBE_OK'             => 'Abonnement au site enregistré',
	'SUBCRIBE_REMOVE'         => 'Désactivation de l\'abonnement au site enregistré',
));