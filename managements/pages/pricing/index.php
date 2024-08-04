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

use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<div class="card">
    <div class="flex flex-wrap justify-between items-center gap-2 p-6">
        <a href="pricing/add?management&option=pages" class="external-event bg-success px-3 py-2 rounded text-white text-base text-start w-full mb-2"><i class="mgc_add_circle_line me-3"></i>Ajouter un plan</a>
        <a href="pricing/listing?management&option=pages" class="external-event bg-warning px-3 py-2 rounded text-white text-base text-start w-full mb-2"><i class="mgc_add_circle_line me-3"></i>Ajouter une liste</a>
    </div>
    <div class="relative overflow-x-auto">
        <table class="w-full divide-y divide-gray-300 dark:divide-gray-700">
            <thead class="bg-slate-300 bg-opacity-20 border-t dark:bg-slate-800 divide-gray-300 dark:border-gray-700">
                <tr>
                    <th scope="col" class="py-3.5 ps-4 pe-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-200"># <?=constant('ID');?></th>
                    <th scope="col" class="py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200"><?=constant('ORDER');?></th>
                    <th scope="col" class="py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200"><?=constant('NAME');?></th>
                    <th scope="col" class="py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200"><?=constant('PRICE');?></th>
                    <th scope="col" class="py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200"><?=constant('PER');?></th>
                    <th scope="col" class="py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200"><?=constant('LISTING');?></th>
                    <th scope="col" class="py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200"><?=constant('CREATED_DATE');?></th>
                    <th scope="col" class="py-3.5 text-center text-sm font-semibold text-gray-900 dark:text-gray-200"><?=constant('ACTION');?></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 ">
                <?php
                foreach ($plan as $k => $n):
                    $per = strtoupper($n->per);
                    $per = defined($per) ? constant($per) : $per;
                    $date = Common::TransformDate($n->created_date, 'FULL', 'MEDIUM');
                ?>
                <tr>
                    <td class="whitespace-nowrap text-left py-4 ps-4 pe-3 text-sm font-medium text-gray-900 dark:text-gray-200"><b># <?=$n->id;?></b></td>
                    <td class="whitespace-nowrap text-left py-4 ps-4 pe-3 text-sm font-medium text-gray-900 dark:text-gray-200"><?=$n->sort_asc;?></td>
                    <td class="whitespace-nowrap text-left py-4 ps-4 pe-3 text-sm font-medium text-gray-900 dark:text-gray-200"><?=$n->name;?></td>
                    <td class="whitespace-nowrap text-left py-4 pe-3 text-sm font-medium text-gray-900 dark:text-gray-200"><?=$n->price;?></td>
                    <td class="whitespace-nowrap text-left py-4 pe-3 text-sm font-medium text-gray-900 dark:text-gray-200"><?=$per;?></td>
                    <td class="whitespace-nowrap text-left py-4 pe-3 text-sm font-medium text-gray-900 dark:text-gray-200"><?=$n->listing;?></td>
                    <td class="whitespace-nowrap text-left py-4 pe-3 text-sm font-medium text-gray-900 dark:text-gray-200"><?=$date;?></td>
                    <td class="whitespace-nowrap text-left py-4 px-3 text-center text-sm font-medium">
                        <a href="pricing/EditPlan/<?=$n->id;?>?management&option=pages" class="me-0.5"> <i class="mgc_edit_line text-lg"></i> </a>
                        <a href="pricing/delPlan/<?=$n->id;?>?management&option=pages" class="ms-0.5"> <i class="mgc_delete_line text-xl"></i> </a>
                    </td>
                </tr>
                <?php
                endforeach;
                ?>
            </tbody>
        </table>
    </div>
</div>