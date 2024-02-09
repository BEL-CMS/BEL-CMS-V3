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

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<form id="form_links" method="post" action="links/sendForm">
    <div class="form_row">
        <label for="form_name">Nom</label>
        <input id="form_name" type="text" value="" name="name" required>
    </div>
    <div class="form_row">
        <label for="form_url">URL</label>
        <input id="form_url" type="url" value="" name="url" required>
    </div>
    <div class="form_row">
        <label for="form_description">Description</label>
        <textarea id="form_description" name="description" class="bel_cms_textarea_simple"></textarea>
    </div>
    <div class="form_row">
        <label for="form_description">Captcha <span><?=$_SESSION['TMP_QUERY_REGISTER']['NUMBER_1'];?> + <?=$_SESSION['TMP_QUERY_REGISTER']['NUMBER_2'];?></span></label>
        <input id="form_url" type="number" name="query" value="0">
    </div>
    <div class="form_submit">
        <input type="hidden" value="" name="captcha" value="">
        <button type="submit" class="belcms_bg_grey"><i class="fa-solid fa-link"></i>&nbsp;&nbsp;<?=constant('ADD')?></button>
    </div>
</form>