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
<section id="section_guestbook">
    <h2><?=constant('GUEST_BOOK');?></h2>
    <a href="guestbook/new" title=""><?=constant('SIGN_THE_GUESTBOOK');?></a>
    <div id="list_guestbook">
        <ul>
            <li>
                <div class="list_guestbook_row title">
                    <div><?=constant('AUTHOR');?></div>
                    <div><?=constant('COMMENT');?></div>
                </div>
            </li>
            <?php
            foreach ($user as $value):
            ?>
            <li>
                <div class="list_guestbook_row">
                    <div class="list_guestbook_avatar"><img src="<?=$value->avatar;?>" alt="avatar_<?=$value->author;?>"></div>
                    <div class="list_guestbook_author"><b><?=$value->author;?></b></div>
                    <div class="list_guestbook_message">
                        <span><i class="fa-regular fa-calendar-days"></i> <?=$value->date_msg;?></span>
                        <span><?=$value->message;?></span>
                    </div>
                </div>
            </li>            
            <?php
            endforeach
            ?>
        </ul>
    </div>
    <?php
    if (!empty($pagination)):
    ?>
        <div class="bel_cms_index_footer">
            <?=$pagination?>
        </div>
    <?php
    endif;
    ?>
</section>