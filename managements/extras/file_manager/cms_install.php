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

use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<div class="flex">
    <div id="default-offcanvas" class="lg:block hidden top-0 left-0 transform h-full min-w-[16rem] me-6 card rounded-none lg:rounded-md fc-offcanvas-open:translate-x-0 lg:z-0 z-50 fixed lg:static lg:translate-x-0 -translate-x-full transition-all duration-300" tabindex="-1">
        <div class="p-5">
            <div class="relative">
                <a href="javascript:void(0)" data-fc-type="dropdown" data-fc-placement="bottom" type="button" class="btn inline-flex justify-center items-center bg-primary text-white w-full">
                    <i class="mgc_add_line text-lg me-2"></i> <?=constant('NAME_UPLOAD');?>
                </a>
                <div class="fc-dropdown fc-dropdown-open:opacity-100 opacity-0 w-full z-50 transition-all duration-300 bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 rounded-lg p-2 hidden">
                    <a class="flex items-center py-2 px-4 text-sm rounded text-gray-500 hover:bg-slate-100 hover:text-slate-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="file_manager/uploadCMS?management&option=extras">
                        <i data-feather="folder" class="me-2 w-4"></i>
                        <span><?=constant('CMS');?></span>
                    </a>
                    <a class="flex items-center py-2 px-4 text-sm rounded text-gray-500 hover:bg-slate-100 hover:text-slate-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="file_manager/uploadTPL?management&option=extras">
                        <i data-feather="file" class="me-2 w-4"></i>
                        <span><?=constant('TEMPLATES');?></span>
                    </a>
                    <a class="flex items-center py-2 px-4 text-sm rounded text-gray-500 hover:bg-slate-100 hover:text-slate-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="file_manager/uploadPAGE?management&option=extras">
                        <i data-feather="upload" class="me-2 w-4"></i>
                        <span>Pages</span>
                    </a>
                </div>
            </div>

            <div class="space-y-2 mt-4">
                <a href="file_manager?management&option=extras" class="flex items-center py-2 px-4 text-sm rounded text-gray-500 hover:bg-slate-100 hover:text-slate-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" id="headingOne">
                    <i data-feather="home" class="me-3.5 w-4"></i>
                    <span>Home</span>
                </a>
                <a href="file_manager/cms?management&option=extras" class="flex items-center py-2 px-4 text-sm rounded text-gray-500 bg-slate-100 hover:text-slate-700 dark:text-gray-400 dark:bg-gray-700 dark:hover:text-gray-300" id="headingOne">
                    <i data-feather="file-text" class="me-3.5 w-4"></i>
                    <span><?=constant('CMS');?></span>
                </a>
                <a href="file_manager/backup?management&option=extras" class="flex items-center py-2 px-4 text-sm rounded text-gray-500 hover:bg-slate-100 hover:text-slate-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" id="headingOne">
                    <i data-feather="download" class="me-3.5 w-4"></i>
                    <span><?=constant('BACKUP');?></span>
                </a>
            </div>

            <div class="mt-6">
                <h6 class="text-uppercase mt-3"><?=constant('STORAGE');?></h6>
                <?=progressBarHDD($percent_free);?>
                <p class="text-gray-500 mt-4 text-xs"><?=$space_free;?> (<?=$percent_free;?>%) <?=constant('OF');?> <?=$space_total;?> <?=constant('USED');?></p>
            </div>
        </div>
    </div>
    <div class="w-full">
        <div class="2xl:col-span-4 sm:col-span-2">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-300"><?=constant('BACKUP');?></h4>
                </div>
                <ul class="flex flex-col sm:flex-row p-5">
                    <li class="inline-flex items-center gap-x-2.5 py-2.5 px-4 text-sm font-medium bg-white border text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg sm:-ms-px sm:mt-0 sm:first:rounded-tr-none sm:first:rounded-bl-lg sm:last:rounded-bl-none sm:last:rounded-tr-lg dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                    <i class="msr">download</i>
                        <a class="backup_cms" href="file_manager/backupcms?management&option=extras"><?=constant('BACKUP_CMS');?></a>
                    </li>
                    <li class="inline-flex items-center gap-x-2.5 py-2.5 px-4 text-sm font-medium bg-white border text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg sm:-ms-px sm:mt-0 sm:first:rounded-tr-none sm:first:rounded-bl-lg sm:last:rounded-bl-none sm:last:rounded-tr-lg dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                        <i class="msr">table_rows</i>
                        <a class="backup_cms" href="file_manager/saveBDD?management&option=extras"><?=constant('BACKUP_SQL');?></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="w-full mt-5">
            <div class="2xl:col-span-4 sm:col-span-2">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-300"><?=constant('BACKUP');?></h4>
                    </div>
                    <div class="flex flex-col">
                        <div class="overflow-x-auto">
                            <div class="inline-block min-w-full align-middle">
                                <div class="overflow-hidden">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                        <thead class="bg-gray-50 dark:bg-gray-700">
                                            <tr class="text-gray-800 dark:text-gray-300">
                                                <th scope="col" class="p-3.5 text-sm text-start font-semibold min-w-[10rem]"><?=constant('FILE_NAME');?></th>
                                                <th scope="col" class="p-3.5 text-sm text-start font-semibold min-w-[2rem]"><?=constant('SIZE');?></th>
                                                <th scope="col" class="p-3.5 text-sm text-start font-semibold min-w-[2rem]"><?=constant('ACTION');?></th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                            <?php
                                            $i = 0;
                                            foreach ($data as $value):
                                                $size = Common::size(filesize($value));
                                                $i = $i + filesize($value);
                                                $dl = str_replace(ROOT, '', $value);
                                            ?>
                                            <tr>
                                                <td class="p-3.5 text-sm text-gray-700 dark:text-gray-400">
                                                    <a href="javascript: void(0);" class="font-medium"><?=$dl;?></a>
                                                </td>
                                                <td class="p-3.5 text-sm text-gray-700 dark:text-gray-400">
                                                    <?=$size;?>
                                                <td class="p-3.5">
                                                    <div>
                                                        <button data-fc-type="dropdown" data-fc-placement="bottom-end" class="inline-flex text-slate-700 hover:bg-slate-100 dark:hover:bg-gray-700 dark:text-gray-300 rounded-full p-2">
                                                            <i data-feather="more-vertical" class="w-4 h-4"></i>
                                                        </button>

                                                        <div class="fc-dropdown hidden fc-dropdown-open:opacity-100 opacity-0 w-40 z-50 mt-2 transition-all duration-300 bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 rounded-lg p-2">
                                                            <a target="_blank" class="flex items-center py-2 px-4 text-sm rounded text-gray-500  hover:bg-slate-100 hover:text-slate-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="<?=$dl;?>">
                                                                <i data-feather="download" class="w-4 h-4 me-3"></i>
                                                                Télécharger
                                                            </a>
                                                            <a class="delete_file_backup flex items-center py-2 px-4 text-sm rounded text-gray-500  hover:bg-slate-100 hover:text-slate-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="file_manager/deleteBackup?url=<?=$value;?>&management&option=extras">
                                                                <i data-feather="trash-2" class="w-4 h-4 me-3"></i>
                                                                Supprimer
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                            endforeach;
                                            ?>
                                        </tbody>
                                        <tfoot class="bg-gray-50 dark:bg-gray-700">
                                            <tr class="text-gray-800 dark:text-gray-300">
                                                <th scope="col" class="p-3.5 text-sm text-start font-semibold min-w-[10rem]"><?=constant('SIZE_ALL');?></th>
                                                <th colspan="2" scope="col" class="p-3.5 text-sm text-start font-semibold min-w-[2rem]"><?=Common::size($i);?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
function progressBarHDD($percent_free)
{
    $return = '';
    if ($percent_free <= '20') {
        $return = '<div class="bg-green-600 h-4 rounded-full w-2/12 animate-strip" style="background-image:linear-gradient(45deg,hsla(0,0%,100%,.15) 25%,transparent 0,transparent 50%,hsla(0,0%,100%,.15) 0,hsla(0,0%,100%,.15) 75%,transparent 0,transparent);background-size:1rem 1rem"></div>';
    } else if ($percent_free >= '20' and $percent_free < '40') {
        $return = '<div class="bg-blue-600 h-4 rounded-full w-4/12 animate-strip" style="background-image:linear-gradient(45deg,hsla(0,0%,100%,.15) 25%,transparent 0,transparent 50%,hsla(0,0%,100%,.15) 0,hsla(0,0%,100%,.15) 75%,transparent 0,transparent);background-size:1rem 1rem"></div>';
    } elseif ($percent_free >= '41' and $percent_free <= '60') {
        $return = '<div class="bg-purple-600 h-4 rounded-full w-6/12 animate-strip" style="background-image:linear-gradient(45deg,(0,0%,100%,.15) 25%,transparent 0,transparent 50%,hsla(0,0%,100%,.15) 0,hsla(0,0%,100%,.15) 75%,transparent 0,transparent);background-size:1rem 1rem"></div>';
    } elseif ($percent_free >= '61' and $percent_free <= '90') {
        $return ='<div class="bg-yellow-600 h-4 rounded-full w-8/12 animate-strip" style="background-image:linear-gradient(45deg,hsla(0,0%,100%,.15) 25%,transparent 0,transparent 50%,hsla(0,0%,100%,.15) 0,hsla(0,0%,100%,.15) 75%,transparent 0,transparent);background-size:1rem 1rem"></div>';
    } elseif ($percent_free >= '90') {
        $return = '<div class="bg-red-600 h-4 rounded-full w-9/12 animate-strip" style="background-image:linear-gradient(45deg,hsla(0,0%,100%,.15) 25%,transparent 0,transparent 50%,hsla(0,0%,100%,.15) 0,hsla(0,0%,100%,.15) 75%,transparent 0,transparent);background-size:1rem 1rem"></div>';
    }
    return $return;
}