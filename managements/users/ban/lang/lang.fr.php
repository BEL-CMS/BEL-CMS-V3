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
    # Fichier lang en français
    #####################################
    'UNABLE_TO_DELETE'      => 'Impossible de supprimer un Admin suprême de niveau 1 (compte crée à l\'installation)',
    'NO_EXIST_USER_IP'      => 'Utilisateur & IP : inexistant',
    'NO_EXIST_USER_IP_MAIL' => 'Utilisateur & IP & email : inexistant',
    'NO_EXIST_IP_MAIL'      => 'IP & email : inexistant',
    'NO_IP_ERROR_ADMIN'     => 'Minimum l\'IP pour bannir.',
    'REQUIRE_ADMIN_MAX'     => 'Requis un numéro de série fourni à l\'installation pour bannir un Admin de niveau 1',
    'CHOSE_USER'            => '-- Choisir un utilisateur --',
    'REASON'                => 'Raison',
    'BANNED_SUCCESSFULLY'   => 'banni avec succès',
    'USER_WITH_IP'          => 'Utilisateur avec IP',
    'BAN_DURATION_OF'       => 'Pour une duree de : ',
    'FONFIRM _BAN_REMOVAL'  => 'Confirmer la suppression du ban de : ',
    'BANNED_BY'             => 'Banni par',
    'UNKNOWN_ERROR_ID'      => 'Erreur ID',
));