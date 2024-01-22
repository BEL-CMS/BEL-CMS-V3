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
	# Fichier lang en français - Pages
	#####################################
	'SAVE'                  => 'Enregistrer',
	'ID'                    => 'ID',
	'BAN'                   => 'Gestion ban',
	'HOME'                  => 'Accueil',
	'BLOG'                  => 'Blog',
	'COMMENTS'              => 'Commentaires',
	'CALENDAR'              => 'Calendrier',
	'COLOR'                 => 'Couleur',
	'COLORS'                => 'Couleurs',
	'DOWNLOADS'             => 'Téléchargements',
	'FORUM'                 => 'Forum',
	'SHOUTBOX'              => 'T\'chat',
	'USER'                  => 'Utilisateurs',
	'TEAM'                  => 'Équipes',
	'PARAMETERS'            => 'Paramètres',
	'PAGE'                  => 'Page',
	'PAGES'                 => 'Pages',
	'MAINTENANCE'           => 'Maintenance',
	'REGISTRATION'          => 'Gestions des membres',
	'THEMES'                => 'Gestions des Thèmes',
	'TEMPLATES'             => 'Thèmes',
	'NEWSLETTER'            => 'Newsletter',
	'SURVEY'                => 'Sondage',
	'MONITORING'            => 'Monitoring',
	'GROUPS'                => 'Gestion des groupes',
	'CONNECTED'             => 'Connecté',
	'LASTCONNECTED'         => 'Dernier connecté',
	'DONATES'               => 'Paypal',
	'GALLERY'               => 'Galerie',
	'ACTIVITY'              => 'Activité',
	'DOWNLOADS_IS_PROGRESS' => 'Chargement de la page en cours...',
	'BACK_TO_WEBSITE'       => 'Retour au site',
	'WIDGETS'               => 'Widgets',
	'GAMING'                => 'Jeu',
	'GAMINGS'               => 'Jeux',
	'MARKET'                => 'Market',
	'CAT'                   => 'Câtégorie',
	'MISCELLANEOUS'         => 'Divers',
	'EXTRAS'                => 'Extras',
	'SERVER'                => 'Serveur',
	'UNAVAILABLE'           => 'Maintenance',
	'EVENTS'                => 'Evénements',
	#####################################
	# Fichier lang en français
	#####################################
	'SEND_NEWCAT_SUCCESS'   => 'Catégorie ajouter avec succès',
	'SEND_NEWCAT_ERROR'     => 'Erreur lors de l\'ajout de la Catégorie',
	'SEND_EDITCAT_SUCCESS'  => 'Catégorie editer avec succès',
	'SEND_EDIT_ERROR'       => 'Erreur lors de l\'édition',
	'SEND_EDITCAT_ERROR'    => 'Erreur lors de l\'édition',
	'SAVE_BDD_SUCCESS'      => 'La sauvegarde a été effectuée avec succès.',
	'SEND_EDIT_SUCCESS'     => 'Enregistrement effectuée avec succès',
	'ERROR_ID'              => 'Erreur de ID',
	'SEND_ERROR'            => 'Error BDD',
	'DEL_SUCCESS'           => 'Supprimé avec succès',
	'DEL_ERROR'             => 'Erreur durant l\'effacement',
	'CATEGORIES'            => 'Câtégories',
	'DESCRIPITON'           => 'Description',
	'ADD_CAT_SUCCESS'       => 'Ajout de la Catégorie avec succès',
	'SEND_SUCCESS'          => 'Ajout avec succès',
));