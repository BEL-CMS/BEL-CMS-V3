<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.7 [PHP8.3]
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
<section id="section_gallery">
    <h2><?=constant('GALLERY');?></h2>
    <div id="section_opt">[ <a href="Gallery">Index</a> | <a href="Gallery/New">Nouveaux</a> | <a href="Gallery/popular">Populaire</a> ]</div>
    <form action="Gallery/SendPropose" method="post" id="section_gallery_form" enctype="multipart/form-data">
        <div>
			<label><?=constant('NAME');?></label>
			<input name="name" type="text" required="required">
        </div>
        <div>
            <textarea name="text" class="bel_cms_textarea_simple"></textarea>
        </div>
        <div>
            <p><i style="color:red">*</i> image de maximum de (<?=Common::ConvertSize(Common::GetMaximumFileUploadSize())?> max)</p>  
            <input type="file" name="file" required="required" accept="image/*">
        </div>
        <div id="div_captcha">
            <label><?=$captcha['NB_ONE']?> + <?=$captcha['NB_TWO']?></label>
            <input name="query_register" type="number" min="1" max="18" class="form-control" id="security-password" placeholder="<?=constant('YOUR_ANSWER');?>" autocomplete="off">
        </div>
        <div>
            <input type="hidden" name="captcha" value="">
            <input type="submit" value="<?=constant('SEND');?>">
        </div>
    </form>
</section>