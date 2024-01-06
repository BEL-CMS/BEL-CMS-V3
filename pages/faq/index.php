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

use BelCMS\Core\Notification;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<section id="belcms_section_faq">
    <h2><?=constant('GET_YOU_QUESTION');?></h2>
    <i><?=constant('FIND_ANSWERS_SEARCH');?></i>
    <input type="search" id="site_search" placeholder="<?=constant('SEARCH_AND_PRESS_ENTER');?>">
    <div id="belcms_section_faq_cat">
        <ul>
            <?php
            $i = 0;
            foreach ($cat as $value):
                $i++;
                $active = $i == 1 ? 'class="active"' : '';
                if ($value->faq !== false):
                ?>
                    <li <?=$active;?>><a class="faq_answer" id="faq_<?=$value->id;?>"><i class="fa-solid fa-circle-question"></i>&ensp;<?=$value->name;?></a></li>
                <?php
                endif;
            endforeach;
            ?>
        </ul>
        <?php 
        ?>
        <div id="belcms_section_faq_content">
            <?php
            $e = 0;
            foreach ($cat as $value):
                $e++;
                $active = $e == 1 ? 'class="active"' : '';
                if ($value->faq !== false):
            ?>
                <div <?=$active;?> id="faq_<?=$value->id;?>_active">
                    <div class="bel_cms_accordion">
                        <?php
                        foreach ($value->faq as $data):
                        ?>
                            <h3><?=$data->name;?></h3>
                            <div>
                                <?=$data->content;?>
                            </div>
                        <?php    
                        endforeach;
                        ?>
                    </div>
                </div>
                <?php 
                endif;
            endforeach;
            ?>
        </div>
    </div>
</section>