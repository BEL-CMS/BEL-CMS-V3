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

namespace BELCMS\LANG;
use BelCMS\Requires\Common as Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

Common::constant(array(
	#####################################
	# Fichier lang en français - Dons
	#####################################
    'DONATIONS'             => 'Dons',
    'CUSTOM_AMOUNT'         => 'Montant personnalisé',
    'SELECT_PAYMENT_METHOD' => 'Sélectionnez le mode de paiement',
    'REDEEM_BY_PAYPAL'      => 'Gerer par PayPal',
    'PAYMENT'               => 'Virement',
    'FIRST_NAME_PSEUDO'     => 'Pseudo / Prénom',
    'LAST_NAME'             => 'Nom de famille',
    'EMAIL_ADRESS'          => 'Adresse e-mail',
    'AGREE_TO_TERMS'        => 'Accepter les conditions ?',
    'DONATE_NOW'            => 'faire un don maintennant',
    'TERMS'                 => 'Une fois le don effectué, il sera impossible de le rembourser.',
    'DONOR'                 => 'Donneur',
    'TOTAL_DONATION'        => 'Don total',
    'PAYMENT_METHOD'        => 'Mode de paiement',
    'PAYPAL'                => 'Paypal',
    'DONATION_DESC'         => 'Dons pour ',
    'THANK_YOU_FOR_DONATE'  => 'Merci, pour votre don',
    'PAYMENT_IN_PROGRESS'   => 'Don en progression',
    'BIC'                   => 'BIC',
    'ACCOUNT_NUMBER'        => 'N° de Compte',
    'COMMUNICATION'         => 'Communication',
    'MSG_PAIE'              => 'Remplissez simplement un virement avec le montant de votre choix et nos coordonnées bancaires',
    'DONATION_BY_TRANSFERT' => 'Le don par virement',
    'ADRESS_POSTAL'         => 'Adresse postal',
    'DONATION_PLEDGE'       => 'Promesse de don',
    'I_PROMISE'             => 'Je promets',
    'THX_DONATE'            => 'Merci pour votre promesse de don<br>Il sera visible dans votre profil, une fois reçus',
    'PAYPAL_ERROR'          => 'Le paiement n\'a pas pu s\'effectue avec succès, aucun retrait n\'est fait',

));