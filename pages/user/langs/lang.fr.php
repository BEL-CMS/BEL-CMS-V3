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
	'MODIFY_PROFILS_SUCCESS'       => 'Profils mise à jour',
	'MODIFY_PROFILS_ERROR'         => 'Une erreur, c\'est produit lors de la mise à jour',
	'SEND_PASS_IS_OK'              => 'Le mot de passe a été enregistré',
	'OLD_PASS_FALSE'               => 'L\'ancien mot de passe de conrespond pas',
	'CHOICE_OF_GAMES'              => 'Choix des jeux',
	'MODIFY_GAMES_SUCCESS'         => 'Liste des jeux, modifié avec succès',
	'VIDEO_GAMES'                  => 'Jeux vidéos',
	'SUBJECT_HTML'                 => 'Récupération du code à valider',
	'ACCOUNT_REGISTRATION'         => 'Enregistrement du compte',
	'SERIAL_ACTIVE'                => 'Clé d\'activation',
	'ACTIVE_TO_SERIAL'             => 'Voici la clé de sécurité pour activer votre compte.',
	'ERROR_CHANGE_GROUP'           => 'Tentative d\'usurpation de groupe, un administrateur a été prévenue',
	'ALERT'                        => 'Attention',
	'INTERACTION_ERROR_GROUP'      => 'L\'utilisateur a tenté de modifier manuellement sont groupe',
	'CHARTER_ERROR'                => 'Le règlement doit être approuvé avant de poursuivre l\'enregistrement',
	'CHOOSE_YOUR_CONNECTION'       => 'Choisir sa connexion',
	'CHOOSE_YOUR_CASE'             => 'Choisir son boitier',
	'CHOOSE_YOUR_KEYBOARD'         => 'Choisir son clavier',
	'COOLING'                      => 'Refroidissement',
	'CPU'                          => 'Processeur (CPU)',
	'MOTHERBOARD'                  => 'Carte mère',
	'RAM'                          => 'Ram',
	'GPU'                          => 'Carte graphique (GPU)',
	'STORAGE'                      => 'Stockage',
	'PSU'                          => 'Alimentation (PSU)',
	'SCREEN'                       => 'Marque de l\'écran',
	'OS'                           => 'Système d\'exploitation',
	'CASE_MODEL'                   => 'Modèle de boîtier',
	'COOLING_MODEL'                => 'Modèle de refroidissement',
	'MODEL_CPU'                    => 'Modèle processeur',
	'MOTHERBOARD_MODEL'            => 'Modèle carte mère',
	'RAM_QUANTITY'                 => 'Quantité RAM',
	'MODEL_GPU'                    => 'Modèle carte graphique',
	'SIZE_SSD'                     => 'Taille (SSD, HDD, M2)',
	'DETAIL_PSU'                   => 'Detail du PSU',
	'RESOLUTION'                   => 'Résolution',
	
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