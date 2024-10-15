<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.9 [PHP8.3]
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
<div id="belcms_tickets">
    <form action="Tickets/Send" method="post">
        <div id="belcms_tickets_subject">
            <span>Sujet<i>*</i></span>
            <span>E-mail<i>*</i></span>
            <span>Catégories</span>
        </div>
        <div id="belcms_tickets_value">
            <input type="text" name="subject" placeholder="Enter le sujet" required>
            <input type="email" name="mail" placeholder="Entrer votre e-mail" required>
            <select name="cat">
                <option value="0"><?=constant('UNKNOW_CAT');?></option>
                <?php
                foreach ($cat as $key => $value):
                ?>
                <option value="<?=$value->id_cat;?>"><?=$value->name_cat;?></option>
                <?php
                endforeach;
                ?>
            </select>
        </div>
        <div class="clear"></div>
        <textarea name="message" class="bel_cms_textarea_simple"></textarea>
        <input class="belcms_btn belcms_bg_grey" type="submit" value="Envoyer">
    </form>
</div>