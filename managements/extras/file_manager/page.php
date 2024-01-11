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

use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<div class="mt-2 mb-2">
    <div class="bg-secondary text-sm text-white rounded-md p-4" role="alert">
        <span class="font-bold"><?=constant('MAX_UPLOADS');?></span> <?=Common::ConvertSize(Common::GetMaximumFileUploadSize())?>
    </div>
</div>
<form action="file_manager/sendPage?management&option=extras" enctype="multipart/form-data" class="dropzone">
    <div class="fallback">
        <input name="file" accept=".zip" type="file" multiple="multiple">
    </div>
    <div class="dz-message needsclick w-full">
        <div class="mb-3">
            <i class="mgc_upload_3_line text-4xl text-gray-300 dark:text-gray-200"></i>
        </div>
        <h5 class="text-xl text-gray-600 dark:text-gray-200"><?=constant('ADD');?></h5>
    </div>
</form>