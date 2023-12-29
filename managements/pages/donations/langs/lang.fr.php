<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2023 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Requires\Common;
include ROOT.DS.'pages'.DS.'donation'.DS.'langs'.DS.'lang.fr.php';

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

Common::constant(array(
	#####################################
	# Fichier lang en français - Dons
	#####################################
	'NO_DONATIONS'         => 'Aucun don, pour le moment.',
	'DATE_OF_DONATION'     => 'Date du don',
	'VALID'                => 'Validé',
	'NO_VALID'             => 'Pas validé',
	'PAIE_OK'              => 'Paiement validé',
	'INFOS_USER_DONATIONS' => 'Information du doneur',
	'PAY_BY'               => 'Payer par',
	'ID_DONATION'          => 'ID du don',
	'EDIT_DON_SUCCESS'     => 'Changement éffectué avec succès',
	'EDIT_DON_WARNING'     => 'Aucun changement en base de donnée',
	'DEL_DON_SUCCESS'      => 'éffacement du don avec succès',
	'DEL_DON_WARNING'      => 'L\'effacement n\'a pas pu s\'effectue !',
	'CONFIG_ADRESS'        => 'Virement Config',
	'FIRST_NAME'           => 'Prénom',
	'SEND_ADRESS_SUCCESS'  => 'Changement éffectué avec succès',
	'SEND_ADRESS_WARNING'  => 'Erreur lors de la mise à jour...',
	'DONATION_ACTIVE'      => 'Activer la page de don',
	'DONS_PAGE_ACTIVE'     => 'Don Activer',
));