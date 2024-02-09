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

use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

debug($data, false);
?>
<section id="belcms_team">
    <?php
    foreach ($data as $key => $value):
        ?>
        <div class="belcms_team_separate">
            <div class="belcms_team_row">
                <h3>Battlefield 2042</h3>
                <span class="belcms_team_game">Game</span>
                <ul class="belcms_team_ul">
                    <li><a class="belcms_tooltip_top" data="pseudo" href="#"><img src="http://themes.pixiesquad.com/pixiefreak/twisting-nether/wp-content/uploads/2018/10/img.jpg"></a></li>
                    <li><a class="belcms_tooltip_top" data="pseudo" href="#"><img src="http://themes.pixiesquad.com/pixiefreak/twisting-nether/wp-content/uploads/2018/10/player_89.jpg"></a></li>
                </ul>
                <div class="belcms_team_left">
                    <p>Chef de section</p>
                    <p><a class="belcms_tooltip_top" data="Chef Stive" href="#">Stive</a></p>
                </div>
                <div class="belcms_team_right">
                    <a href="Team">Team Page</a>
                </div>
            </div>
        </div>
        <?php
    endforeach;
    ?>
</section>