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

if (!defined('CHECK_INDEX')) {
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
}

use BelCMS\Requires\Common;

Common::constant(array(
	'USED'           => 'Utilisé',
    'STORAGE'        => 'Stockage',
    'CMS'            => 'C.M.S',
    'FOLDER'         => 'Dossiers',
    'UPLOADS'        => 'uploads',
    'FILE_NAME'      => 'Nom du fichier',
    'FILE_SIZE'      => 'Taille du fichier',
    'UPLOADER'       => 'Uploader',
    'ACTION'         => 'Action',
    'RECENT_UPLOADS' => 'Récent Upload',
    'INSTALL'        => 'Installation',
    'TMP'            => 'Fichiers temporaires',
    'ERROR_UPLOAD'   => 'Erreur lors du transfert',
    'MAX_UPLOADS'    => 'Maximum upload',
    'NAME_UPLOAD'    => 'Uploader',
    'BACKUP'         => 'Backup',
    'SIZE_ALL'       => 'Taille totale des fichiers backup',
    'BACKUP_CMS'     => 'Backup FTP Complet',
    'BACKUP_SQL'     => 'Backup BDD',
    'ALERT_CMS'      => 'Sauvegarder le FTP/SQL avant la mise a jour du C.M.S, ont est jamais trop prudent<br><a style="border-bottom: 2px dashed;" href="file_manager/cms?management&option=extras">Par ici pour sauvegarder le C.M.S et les Table SQL</a>'
));