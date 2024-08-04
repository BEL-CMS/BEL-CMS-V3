<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.8 [PHP8.3]
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
<div class="card">
    <div class="relative overflow-x-auto">
        <table class="w-full divide-y divide-gray-300 dark:divide-gray-700">
            <thead class="bg-slate-300 bg-opacity-20 border-t dark:bg-slate-800 divide-gray-300 dark:border-gray-700">
                <tr>
                    <th scope="col" class="py-3.5 ps-4 pe-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-200"># ID</th>
                    <th scope="col" class="py-3.5 ps-4 pe-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-200"><?=constant('NAME');?></th>
                    <th scope="col" class="py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200"><?=constant('CAT_1');?></th>
                    <th scope="col" class="py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200"><?=constant('CAT_2');?></th>
                    <th scope="col" class="py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200"><?=constant('CAT_3');?></th>
                    <th scope="col" class="py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200"><?=constant('CAT_4');?></th>
                    <th scope="col" class="py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200"><?=constant('CAT_5');?></th>
                    <th scope="col" class="py-3.5 text-center text-sm font-semibold text-gray-900 dark:text-gray-200">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 ">
                <?php
                foreach ($list as $v):
                    $cat_1 = $v->actif_1 == true ? 'green' : 'red';
                    $cat_2 = $v->actif_2 == true ? 'green' : 'red';
                    $cat_3 = $v->actif_3 == true ? 'green' : 'red';
                    $cat_4 = $v->actif_4 == true ? 'green' : 'red';
                    $cat_5 = $v->actif_5 == true ? 'green' : 'red';
                ?>
                <tr>
                    <td class="whitespace-nowrap text-left py-4 ps-4 pe-3 text-sm font-medium text-gray-900 dark:text-gray-200"><b># <?=$v->id;?></b></td>
                    <td class="whitespace-nowrap text-left py-4 ps-4 pe-3 text-sm font-medium text-gray-900 dark:text-gray-200"><?=$v->name;?></td>
                    <td class="whitespace-nowrap text-left py-4 pe-3 text-sm font-medium text-gray-900 dark:text-gray-200" style="color: <?=$cat_1;?>"><?=$v->cat_1;?></td>
                    <td class="whitespace-nowrap text-left py-4 pe-3 text-sm font-medium text-gray-900 dark:text-gray-200" style="color: <?=$cat_2;?>"><?=$v->cat_2;?></td>
                    <td class="whitespace-nowrap text-left py-4 pe-3 text-sm font-medium text-gray-900 dark:text-gray-200" style="color: <?=$cat_3;?>"><?=$v->cat_3;?></td>
                    <td class="whitespace-nowrap text-left py-4 pe-3 text-sm font-medium text-gray-900 dark:text-gray-200" style="color: <?=$cat_4;?>"><?=$v->cat_4;?></td>
                    <td class="whitespace-nowrap text-left py-4 pe-3 text-sm font-medium text-gray-900 dark:text-gray-200" style="color: <?=$cat_5;?>"><?=$v->cat_5;?></td>
                    <td class="whitespace-nowrap text-left py-4 px-3 text-center text-sm font-medium">
                        <a href="pricing/delListing/<?=$v->id;?>?management&option=pages" class="ms-0.5"> <i class="mgc_delete_line text-xl"></i> </a>
                    </td>
                </tr>
                <?php
                endforeach;
                ?>
            </tbody>
        </table>
    </div>
</div>