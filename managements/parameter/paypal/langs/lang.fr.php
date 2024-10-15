<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.1.0 [PHP8.3]
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
    'MANAGEMENT_TITLE_NAME' => 'Configuration de PayPal',
    'LOGO_PAYPAL'           => 'Logo de vente Paypal',
    'GENERAL_INFOS_SANBOX'  => 'Général information de PayPal (Sanbox - test)',
    'GENERAL_INFOS'         => 'Général information de PayPal',
    'SANBOX_CLIENT_ID'      => 'PayPal : Sanbox client ID',
    'SANBOX_CLIENT_SECRET'  => 'PayPal : Sanbox client ID Secret',
    'CLIENT_ID'             => 'PayPal : client ID',
    'CLIENT_SECRET'         => 'PayPal : client ID Secret',
    'CURRENCY'              => 'Devise',
    'SANBOX'                => 'Sanbox (Test)',
    'COUNTRY'               => 'Localisation',
    'STREET'                => 'Rue',
    'NUMBER'                => 'Numéro',
    'POSTAL_CODE'           => 'Code postal', 
    'LOCALITY'              => 'localité',
    'SUBMIT'                => 'Soumettre',
));