<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.1.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Core\Config;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
$maingroup = config::getGroupsForID($data->groups->user_group);
$name_group = defined($maingroup->name) ? constant($maingroup->name) : $maingroup->name;
if (empty($data->profils->avatar)) {
    $avatar = constant('DEFAULT_AVATAR');
} else {
    $avatar = $data->profils->avatar;
}
$groupsAll = array();
foreach ($data->groups->all_groups as $k => $id) {
    $id = (string) $id;
    $data->groups->all_groups[$k] = Config::getGroupsForID($id);
}
if (!empty($data->profils->gender)) {
    if (strtoupper($data->profils->gender) == 'MALE') {
        $gender = constant('MALE');
    } else if (strtoupper($data->profils->gender) == 'FEMALE') {
        $gender = constant('FEMALE');
    } else {
        $gender = constant('NOSPEC');
    }
} else {
    $gender = constant('NOSPEC');
}
$birthday = !empty($data->profils->birthday) ? Common::TransformDate($data->profils->birthday, 'LONG', 'NONE') : constant('NO_SPEC');
?>
<div id="belcms_members_index">
    <div id="belcms_members_index_header">
        <div id="belcms_members_index_avatar">
            <img src="<?=$avatar;?>">
        </div>
        <h2><?=$data->user->username;?></h2>
        <div id="belcms_members_index_header_infos">
            <span><b>Role</b> : <?=$name_group;?></span>
            <span><b>Dernière activité</b> : <?=Common::TransformDate($data->page->last_visit, 'LONG', 'MEDIUM');?></span>
            <span><b>Date anniversaire</b> : <?=$birthday;?></span>
        </div>
    </div>
    <div id="belcms_members_profil_infos">
        <ul>
            <li id="belcms_members_profil_infos_title">
                <span><i class="fa-solid fa-computer"></i>&ensp;<?=constant('GENERAL_INFORMATION');?></span>
            </li>
            <li>
                <div class="belcms_grid_6"><i class="fa-solid fa-user-tag fa-beat"></i></i>&ensp;<?=constant('USERNAME');?></div>
                <div class="belcms_grid_6"><?=$data->user->username;?></div>
            </li>
            <li>
                <div class="belcms_grid_6"><i class="fa-solid fa-mars-and-venus-burst"></i>&ensp;<?=constant('GENDER');?></div>
                <div class="belcms_grid_6"><?=$gender;?></div>
            </li>
            <li>
                <div class="belcms_grid_6"><i class="fa-solid fa-globe"></i>&ensp;<?=constant('COUNTRY');?></div>
                <div class="belcms_grid_6"><?=$data->profils->country;?></div>
            </li>
            <li>
                <div class="belcms_grid_6"><i class="fa-solid fa-at"></i>&ensp;<?=constant('MAIL');?></div>
                <div class="belcms_grid_6"><?=$data->profils->public_mail;?></div>
            </li>
            <li>
                <div class="belcms_grid_6"><i class="fa-solid fa-link"></i>&ensp;<?=constant('WEBSITE');?></div>
                <div class="belcms_grid_6"><a href="<?=$data->profils->websites;?>"><?=$data->profils->websites;?></a></div>
            </li>
        </ul>
    </div>
    <div id="belcms_members_profil_hardware">
        <ul>
            <li id="belcms_members_profil_hardware_title">
                <span><i class="fa-solid fa-computer"></i>&ensp;<?=constant('GENERAL_INFORMATION');?></span>
            </li>
            <li>
                <div class="belcms_grid_3"></i>&ensp;Connexion</div>
                <div class="belcms_grid_3"><?=$data->hardware->internet_connection;?></div>
                <div class="belcms_grid_3"></i>&ensp;Système d'exploitation</div>
                <div class="belcms_grid_3"><?=$data->hardware->OS;?></div>
            </li>
            <li>
                <div class="belcms_grid_3"></i>&ensp;Boitier ( tour )</div>
                <div class="belcms_grid_3"><?=$data->hardware->tower;?></div>
                <div class="belcms_grid_3"></i>&ensp;Modèle de boîtier </div>
                <div class="belcms_grid_3"><?=$data->hardware->model_tower;?></div>
            </li>
            <li>
                <div class="belcms_grid_3"></i>&ensp;Clavier</div>
                <div class="belcms_grid_3"><?=$data->hardware->mouse;?></div>
                <div class="belcms_grid_3"></i>&ensp;Souris</div>
                <div class="belcms_grid_3"><?=$data->hardware->mouse;?></div>
            </li>
            <li>
                <div class="belcms_grid_3"></i>&ensp;Refroidissement</div>
                <div class="belcms_grid_3"><?=$data->hardware->cooling;?></div>
                <div class="belcms_grid_3"></i>&ensp;Modèle de refroidissement</div>
                <div class="belcms_grid_3"><?=$data->hardware->model_cooling;?></div>
            </li>
            <li>
                <div class="belcms_grid_3"></i>&ensp; Carte mère</div>
                <div class="belcms_grid_3"><?=$data->hardware->motherboard;?></div>
                <div class="belcms_grid_3"></i>&ensp; Modèle carte mère</div>
                <div class="belcms_grid_3"><?=$data->hardware->model_motherboard;?></div>
            </li>
            <li>
                <div class="belcms_grid_3"></i>&ensp;Mémoire Ram</div>
                <div class="belcms_grid_3"><?=$data->hardware->ram;?></div>
                <div class="belcms_grid_3"></i>&ensp;Quantité RAM </div>
                <div class="belcms_grid_3"><?=$data->hardware->model_ram;?></div>
            </li>
            <li>
                <div class="belcms_grid_3"></i>&ensp;Carte graphique (GPU)</div>
                <div class="belcms_grid_3"><?=$data->hardware->graphics_card;?></div>
                <div class="belcms_grid_3"></i>&ensp;Modèle de carte graphique</div>
                <div class="belcms_grid_3"><?=$data->hardware->model_graphics_card;?></div>
            </li>
            <li>
                <div class="belcms_grid_3"></i>&ensp;Stockage</div>
                <div class="belcms_grid_3"><?=$data->hardware->ssd_m2;?></div>
                <div class="belcms_grid_3"></i>&ensp;Taille (SSD, HDD, M2)</div>
                <div class="belcms_grid_3"><?=$data->hardware->size_hdd;?></div>
            </li>
            <li>
                <div class="belcms_grid_3"></i>&ensp;Alimentation (PSU)</div>
                <div class="belcms_grid_3"><?=$data->hardware->psu;?></div>
                <div class="belcms_grid_3"></i>&ensp;Detail du PSU </div>
                <div class="belcms_grid_3"><?=$data->hardware->watt;?></div>
            </li>
            <li>
                <div class="belcms_grid_3"></i>&ensp;Marque de l'écran</div>
                <div class="belcms_grid_3"><?=$data->hardware->screen;?></div>
                <div class="belcms_grid_3"></i>&ensp;Résolution</div>
                <div class="belcms_grid_3"><?=$data->hardware->screen_resolution;?></div>
            </li>
        </ul>
    </div>
</div>