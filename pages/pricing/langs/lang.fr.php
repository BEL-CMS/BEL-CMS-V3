<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.8 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

namespace BELCMS\LANG;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

Common::constant(array(
	#####################################
	# Fichier lang en français - Pricing
	#####################################
	'PRICE'                 => 'Prix',
    'BIC'                   => 'BIC',
    'ACCOUNT_NUMBER'        => 'N° de Compte',
    'COMMUNICATION'         => 'Communication',
	'FIRST_NAME_PSEUDO'     => 'Pseudo / Prénom',
    'LAST_NAME'             => 'Nom de famille',
    'EMAIL_ADRESS'          => 'Adresse e-mail',
	'ADRESS_POSTAL'         => 'Adresse postal',
    'PREORDER_SUCCESS'      => 'PréCommande éffectué avec succès',
    'PREORDER_ERROR'        => 'PreCommande annulé, contacté un administrateur',
    'THANK_YOU_FOR_BUY'     => 'Merci de votre achat',
    'PAYMENT_IN_PROGRESS'   => 'Payement en progression',

)); 