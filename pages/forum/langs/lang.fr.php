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

use BelCMS\Requires\Common as Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

Common::constant(array(
	#####################################
	# Fichier lang en français - Forum
	#####################################
	'FORUM'               => 'Forum',
	'SUBMIT_THREAD'       => 'Soumettre le sujet',
	'SUBMIT_POST'         => 'Soumettre une réponse',
	'TITLE_POST'          => 'Titre du sujet',
	'ADD_A_TITLE'         => 'Ajouter un titre',
	'WRITE_A_REPLY'       => 'Écrire une réponse',
	'ERROR_LOGIN'         => 'L\'enregistrement de la réponse n\'a pas pu s\'effectuer : <strong>Login requis</strong>',
	'ERROR_BDD'           => 'L\'enregistrement de la réponse n\'a pas pu s\'effectuer : <strong>Erreur BDD</strong>',
	'ERROR_ID'            => 'Erreur ID inconnu, veuillez réessayer.',
	'THREADS'             => 'Sujets',
	'THREAD'              => 'Sujet',
	'NEW_THREAD'          => 'Nouveau sujet',
	'NO_POST'             => 'Aucun sujet',
	'LOCK_THREAD'         => 'Fermer le sujet',
	'UNLOCK_THREAD'       => 'Ouvrir le sujet',
	'DEL_THRAD'           => 'Supprimer le sujet',
	'LIKE'                => 'Aimer',
	'REPORT_POST'         => 'Reporter ce sujet',
	'EDIT_POST'           => 'Editer ce post',
	'LAST_POST'           => 'Dernier message',
	'VIEW_THE_LATEST_POST'=> 'Regarder le dernier poste',
	'BY'                  => 'par',
	'CATEGORY'            => 'Catégories',
	'ICON'                => 'Icone',
	'SUBTITLE'            => 'Sous-titre',
	#####################################
	# Erreur - Forum
	#####################################
	'ERROR_NO_POST'       => 'Aucun sujet disponible dans la base de données',
	'NO_ACCESS_POST'      => 'Acces refusé vous n\'avez pas l\'autorisation',
	'DEL_POST_SUCCESS'    => 'Suppression du sujet effectué avec succès',
	'DEL_POST_ERROR'      => 'Erreur lors de la suppresion du sujet',
	#####################################
	# Management - Forum
	#####################################
	'NEW_THREADS_SUCCESS' => 'Ajout du forum avec succès.',
	'NEW_THREADS_ERROR'   => 'Une erreur est survenue durant l\'enregistrement en BDD.',
	'NEW_CAT_SUCCESS'     => 'Ajout de la catégorie avec succès',
	'NEW_CAT_ERROR'       => 'Une erreur est survenue durant l\'enregistrement en BDD.',
	'ERROR_TITLE_EMPTY'   => 'Erreur : titre absent',
	'ERROR_ID_EMPTY_INT'  => 'Erreur : ID vide ou n\'est pas un nombre entier !',
	'DEL_THREADS_SUCCESS' => 'Effacement effectué avec succès',
	'DEL_THREADS_ERROR'   => 'Une erreur est survenue durant l\'éffacement',
	'ERROR_NO_CAT'        => 'Veuillez créer une catégorie avant de créer le forum',
	'EDIT_CAT_SUCCESS'    => 'Edition de la catégorie avec succès',
	'EDIT_CAT_ERROR'      => 'Une erreur est survenue durant l\'édition',
	'DEL_CAT_SUCCESS'     => 'Effacement effectué avec succès',
	'DEL_CAT_ERROR'       => 'Une erreur est survenue durant l\'éffacement',
	'LOCK_SUCCESS'        => 'Sujet fermer avec succès',
	'ERROR_LOCK_BDD'      => 'Erreur BDD: impossible de fermer le sujet',
	'UNLOCK_SUCCESS'      => 'Sujet ouvert avec succès',
	'ERROR_UNLOCK_BDD'    => 'Erreur BDD: impossible d\'ouvrir le sujet',
	'NO_OPEN_POST'        => 'Vous ne pouvez pas ouvrir ce sujet',
	'NO_CLOSE_POST'       => 'Vous ne pouvez pas fermer ce sujet',
	'EDIT_REPLY'          => 'Edition du post',
	'EDIT_SUCCESS'        => 'Edition du post avec succès',
	'EDIT_FALSE'          => 'Erreur durant le processus de sauvegarde',
	'LOCK_POST_ERROR'     => 'Impossible de fermer le post',
	'LOCK_POST_ERROR_NO'  => 'Impossible de fermer le sujet d\'un autre',
));
