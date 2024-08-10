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

use BelCMS\Core\Config;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
if (User::isLogged() === true):
    $nameGroup = defined(strtoupper(Config::getGroupsForID($main)->name)) ? constant(strtoupper(Config::getGroupsForID($main)->name)) : Config::getGroupsForID($main)->name;
?>
<section id="section_user">
	<?php require 'menu.php'; ?>
	<div id="section_user_profil">
		<h2>Choisissez votre groupe principal</h2>
		<div class="section_user_profil_avatar">
            <form action="user/ChangeGroup" method="post">
                <select name="id">
                    <?php
                    foreach ($all as $key => $value):
                        $name = defined(strtoupper(Config::getGroupsForID($value)->name)) ? constant(strtoupper(Config::getGroupsForID($value)->name)) : Config::getGroupsForID($value)->name;
                    ?>
                    <option value="<?=Config::getGroupsForID($value)->id_group;?>"><?=$name;?></option>
                    <?php
                    endforeach;
                    ?>
                </select>
                <div class="section_user_profil_avatar_list">
                    <input type="submit" value="Enregistrer" class="belcms_bg_grey">
                </div>
            </form>
        </div>
    </div>
	<div id="section_user_profil_right">
		<h2>Groupe Principal</h2>
        <span style="color: <?=Config::getGroupsForID($main)->color;?>;"><?=$nameGroup;?></span>
    </div>
</section>
<?php
endif;
?>