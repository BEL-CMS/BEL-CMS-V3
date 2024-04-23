<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.1 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

Common::constant(array(
    'LIST_OF_CONFIG'       => 'Liste d\'mail reçus',  
    'SUBJECT'              => 'Sujet',
    'REPLY_CONTACT'        => 'Répondre au e-mail',
    'SEND_REPLY_SUCCESS'   => 'Réponse effectuée avec succès',
    'SEND_REPLY_ERROR'     => 'Erreur lors de la réponse au mail.',
    'LIST_OF_SORTING_MAIL' => 'Mail sortant',
));