<?php
use BelCMS\Requires\Common;
use BelCMS\User\User;
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
                <a href="file_manager?management&option=extras" class="flex items-center py-2 px-4 text-sm rounded text-gray-500 bg-slate-100 hover:text-slate-700 dark:text-gray-400 dark:bg-gray-700 dark:hover:text-gray-300" id="headingOne">
                    <i data-feather="home" class="me-3.5 w-4"></i>
                    <span>Home</span>
                </a>
                <a href="file_manager/cms?management&option=extras" class="flex items-center py-2 px-4 text-sm rounded text-gray-500 hover:bg-slate-100 hover:text-slate-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" id="headingOne">
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
        <div class="grid 2xl:grid-cols-4 sm:grid-cols-2 grid-cols-1 gap-6">
            <div class="2xl:col-span-4 sm:col-span-2">
                <div class="flex items-center justify-between gap-4">
                    <div class="lg:hidden block">
                        <button data-fc-target="default-offcanvas" data-fc-type="offcanvas" class="inline-flex items-center justify-center text-gray-700 border border-gray-300 rounded shadow hover:bg-slate-100 dark:text-gray-400 hover:dark:bg-gray-800 dark:border-gray-700 transition h-9 w-9 duration-100">
                            <div class="mgc_menu_line text-lg"></div>
                        </button>
                    </div>
                    <h4 class="text-xl"><?=constant('FOLDER');?></h4>
                </div>
            </div>

            <div class="card">
                <div class="p-5">
                    <div class="space-y-4 text-gray-600 dark:text-gray-300">
                        <div class="flex items-start relative gap-5">
                            <div class="flex items-center gap-3">
                                <div class="h-14 w-14">
                                    <span class="flex h-full w-full items-center justify-center">
                                        <i data-feather="folder" class="h-full w-full fill-warning text-warning"></i>
                                    </span>
                                </div>
                                <div class="space-y-1">
                                    <p class="font-semibold text-base"><?=constant('UPLOADS');?></p>
                                    <p class="text-xs"><?=$uploads;?></p>
                                </div>
                            </div>
                            <div class="flex items-center absolute top-0 end-0">
                                <button data-fc-type="dropdown" data-fc-placement="bottom-end" class="inline-flex text-slate-700 hover:bg-slate-100 dark:hover:bg-gray-700 dark:text-gray-300 rounded-full p-2">
                                    <i data-feather="more-vertical" class="w-4 h-4"></i>
                                </button>

                                <div class="fc-dropdown hidden fc-dropdown-open:opacity-100 opacity-0 w-40 z-50 mt-2 transition-all duration-300 bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 rounded-lg p-2">
                                    <a class="saveUploads flex items-center py-2 px-4 text-sm rounded text-gray-500  hover:bg-slate-100 hover:text-slate-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="file_manager/saveUploads?management&option=extras">
                                        <i data-feather="download" class="w-4 h-4 me-3"></i>
                                        <?=constant('SAVE');?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="p-5">
                    <div class="space-y-4 text-gray-600 dark:text-gray-300">
                        <div class="flex items-start relative gap-5">
                            <div class="flex items-center gap-3">
                                <div class="h-14 w-14">
                                    <span class="flex h-full w-full items-center justify-center">
                                        <i data-feather="folder" class="h-full w-full fill-warning text-warning"></i>
                                    </span>
                                </div>
                                <div class="space-y-1">
                                    <p class="font-semibold text-base"><?=constant('USERS');?></p>
                                    <p class="text-xs"><?=$users;?></p>
                                </div>
                            </div>
                            <div class="flex items-center absolute top-0 end-0">
                                <button data-fc-type="dropdown" data-fc-placement="bottom-end" class="inline-flex text-slate-700 hover:bg-slate-100 dark:hover:bg-gray-700 dark:text-gray-300 rounded-full p-2">
                                    <i data-feather="more-vertical" class="w-4 h-4"></i>
                                </button>

                                <div class="fc-dropdown hidden fc-dropdown-open:opacity-100 opacity-0 w-40 z-50 mt-2 transition-all duration-300 bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 rounded-lg p-2">
                                    <a class="saveUploads flex items-center py-2 px-4 text-sm rounded text-gray-500  hover:bg-slate-100 hover:text-slate-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="file_manager/saveUsers?management&option=extras">
                                        <i data-feather="download" class="w-4 h-4 me-3"></i>
                                        <?=constant('SAVE');?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="p-5">
                    <div class="space-y-4 text-gray-600 dark:text-gray-300">
                        <div class="flex items-start relative gap-5">
                            <div class="flex items-center gap-3">
                                <div class="h-14 w-14">
                                    <span class="flex h-full w-full items-center justify-center">
                                        <i data-feather="folder" class="h-full w-full fill-warning text-warning"></i>
                                    </span>
                                </div>
                                <div class="space-y-1">
                                    <p class="font-semibold text-base"><?=constant('DOWNLOADS');?></p>
                                    <p class="text-xs"><?=$downloads;?></p>
                                </div>
                            </div>
                            <div class="flex items-center absolute top-0 end-0">
                                <button data-fc-type="dropdown" data-fc-placement="bottom-end" class="inline-flex text-slate-700 hover:bg-slate-100 dark:hover:bg-gray-700 dark:text-gray-300 rounded-full p-2">
                                    <i data-feather="more-vertical" class="w-4 h-4"></i>
                                </button>

                                <div class="fc-dropdown hidden fc-dropdown-open:opacity-100 opacity-0 w-40 z-50 mt-2 transition-all duration-300 bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 rounded-lg p-2">
                                    <a class="saveUploads flex items-center py-2 px-4 text-sm rounded text-gray-500  hover:bg-slate-100 hover:text-slate-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="file_manager/saveDownloads?management&option=extras">
                                        <i data-feather="download" class="w-4 h-4 me-3"></i>
                                        <?=constant('SAVE');?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="p-5">
                    <div class="space-y-4 text-gray-600 dark:text-gray-300">
                        <div class="flex items-start relative gap-5">
                            <div class="flex items-center gap-2">
                                <div class="h-14 w-14">
                                    <span class="flex h-full w-full items-center justify-center">
                                        <i data-feather="folder" class="h-full w-full fill-warning text-warning"></i>
                                    </span>
                                </div>
                                <div class="space-y-1">
                                    <p class="font-semibold text-base"><?=constant('GALLERY');?></p>
                                    <p class="text-xs"><?=$gallery;?></p>
                                </div>
                            </div>
                            <div class="flex items-center absolute top-0 end-0">
                                <button data-fc-type="dropdown" data-fc-placement="bottom-end" class="inline-flex text-slate-700 hover:bg-slate-100 dark:hover:bg-gray-700 dark:text-gray-300 rounded-full p-2">
                                    <i data-feather="more-vertical" class="w-4 h-4"></i>
                                </button>

                                <div class="fc-dropdown hidden fc-dropdown-open:opacity-100 opacity-0 w-40 z-50 mt-2 transition-all duration-300 bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 rounded-lg p-2">
                                    <a class="saveUploads flex items-center py-2 px-4 text-sm rounded text-gray-500  hover:bg-slate-100 hover:text-slate-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="file_manager/saveGallery?management&option=extras">
                                        <i data-feather="download" class="w-4 h-4 me-3"></i>
                                        <?=constant('SAVE');?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="p-5">
                    <div class="space-y-4 text-gray-600 dark:text-gray-300">
                        <div class="flex items-start relative gap-5">
                            <div class="flex items-center gap-3">
                                <div class="h-14 w-14">
                                    <span class="flex h-full w-full items-center justify-center">
                                        <i data-feather="folder" class="h-full w-full fill-warning text-warning"></i>
                                    </span>
                                </div>
                                <div class="space-y-1">
                                    <p class="font-semibold text-base"><?=constant('TEMPLATES');?></p>
                                    <p class="text-xs"><?=$templates;?></p>
                                </div>
                            </div>
                            <div class="flex items-center absolute top-0 end-0">
                                <button data-fc-type="dropdown" data-fc-placement="bottom-end" class="inline-flex text-slate-700 hover:bg-slate-100 dark:hover:bg-gray-700 dark:text-gray-300 rounded-full p-2">
                                    <i data-feather="more-vertical" class="w-4 h-4"></i>
                                </button>

                                <div class="fc-dropdown hidden fc-dropdown-open:opacity-100 opacity-0 w-40 z-50 mt-2 transition-all duration-300 bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 rounded-lg p-2">
                                    <a class="saveUploads flex items-center py-2 px-4 text-sm rounded text-gray-500  hover:bg-slate-100 hover:text-slate-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="file_manager/saveTpl?management&option=extras">
                                        <i data-feather="download" class="w-4 h-4 me-3"></i>
                                        <?=constant('SAVE');?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="p-5">
                    <div class="space-y-4 text-gray-600 dark:text-gray-300">
                        <div class="flex items-start relative gap-5">
                            <div class="flex items-center gap-3">
                                <div class="h-14 w-14">
                                    <span class="flex h-full w-full items-center justify-center">
                                        <i data-feather="folder" class="h-full w-full fill-warning text-warning"></i>
                                    </span>
                                </div>
                                <div class="space-y-1">
                                    <p class="font-semibold text-base"><?=constant('TMP');?></p>
                                    <p class="text-xs"><?=$tmp;?></p>
                                </div>
                            </div>
                            <div class="flex items-center absolute top-0 end-0">
                                <button data-fc-type="dropdown" data-fc-placement="bottom-end" class="inline-flex text-slate-700 hover:bg-slate-100 dark:hover:bg-gray-700 dark:text-gray-300 rounded-full p-2">
                                    <i data-feather="more-vertical" class="w-4 h-4"></i>
                                </button>

                                <div class="fc-dropdown hidden fc-dropdown-open:opacity-100 opacity-0 w-40 z-50 mt-2 transition-all duration-300 bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 rounded-lg p-2">
                                    <a class="saveUploads flex items-center py-2 px-4 text-sm rounded text-gray-500  hover:bg-slate-100 hover:text-slate-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="file_manager/saveTmp?management&option=extras">
                                        <i data-feather="download" class="w-4 h-4 me-3"></i>
                                        <?=constant('SAVE');?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="p-5">
                    <div class="space-y-4 text-gray-600 dark:text-gray-300">
                        <div class="flex items-start relative gap-5">
                            <div class="flex items-center gap-3">
                                <div class="h-14 w-14">
                                    <span class="flex h-full w-full items-center justify-center">
                                        <i data-feather="folder" class="h-full w-full fill-warning text-warning"></i>
                                    </span>
                                </div>
                                <div class="space-y-1">
                                    <p class="font-semibold text-base"><?=constant('FORUM');?></p>
                                    <p class="text-xs"><?=$forum;?></p>
                                </div>
                            </div>
                            <div class="flex items-center absolute top-0 end-0">
                                <button data-fc-type="dropdown" data-fc-placement="bottom-end" class="inline-flex text-slate-700 hover:bg-slate-100 dark:hover:bg-gray-700 dark:text-gray-300 rounded-full p-2">
                                    <i data-feather="more-vertical" class="w-4 h-4"></i>
                                </button>

                                <div class="fc-dropdown hidden fc-dropdown-open:opacity-100 opacity-0 w-40 z-50 mt-2 transition-all duration-300 bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 rounded-lg p-2">
                                    <a class="saveUploads flex items-center py-2 px-4 text-sm rounded text-gray-500  hover:bg-slate-100 hover:text-slate-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="file_manager/saveForum?management&option=extras">
                                        <i data-feather="download" class="w-4 h-4 me-3"></i>
                                        <?=constant('SAVE');?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="p-5">
                    <div class="space-y-4 text-gray-600 dark:text-gray-300">
                        <div class="flex items-start relative gap-5">
                            <div class="flex items-center gap-3">
                                <div class="h-14 w-14">
                                    <span class="flex h-full w-full items-center justify-center">
                                        <i data-feather="folder" class="h-full w-full fill-warning text-warning"></i>
                                    </span>
                                </div>
                                <div class="space-y-1">
                                    <p class="font-semibold text-base"><?=constant('ARTICLES');?></p>
                                    <p class="text-xs"><?=$articles;?></p>
                                </div>
                            </div>
                            <div class="flex items-center absolute top-0 end-0">
                                <button data-fc-type="dropdown" data-fc-placement="bottom-end" class="inline-flex text-slate-700 hover:bg-slate-100 dark:hover:bg-gray-700 dark:text-gray-300 rounded-full p-2">
                                    <i data-feather="more-vertical" class="w-4 h-4"></i>
                                </button>

                                <div class="fc-dropdown hidden fc-dropdown-open:opacity-100 opacity-0 w-40 z-50 mt-2 transition-all duration-300 bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 rounded-lg p-2">
                                    <a class="saveUploads flex items-center py-2 px-4 text-sm rounded text-gray-500  hover:bg-slate-100 hover:text-slate-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="file_manager/saveArticles?management&option=extras">
                                        <i data-feather="download" class="w-4 h-4 me-3"></i>
                                        <?=constant('SAVE');?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="2xl:col-span-4 sm:col-span-2">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-300"><?=constant('RECENT_UPLOADS');?></h4>
                    </div>

                    <div class="flex flex-col">
                        <div class="overflow-x-auto">
                            <div class="inline-block min-w-full align-middle">
                                <div class="overflow-hidden">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                        <thead class="bg-gray-50 dark:bg-gray-700">
                                            <tr class="text-gray-800 dark:text-gray-300">
                                                <th scope="col" class="p-3.5 text-sm text-start font-semibold min-w-[10rem]"><?=constant('FILE_NAME');?></th>
                                                <th scope="col" class="p-3.5 text-sm text-start font-semibold min-w-[10rem]"><?=constant('DATE');?></th>
                                                <th scope="col" class="p-3.5 text-sm text-start font-semibold min-w-[6rem]"><?=constant('FILE_SIZE');?></th>
                                                <th scope="col" class="p-3.5 text-sm text-start font-semibold min-w-[8rem]"><?=constant('UPLOADER');?></th>
                                                <th scope="col" class="p-3.5 text-sm text-start font-semibold min-w-[6rem]"><?=constant('CAT');?></th>
                                                <th scope="col" class="p-3.5 text-sm text-start font-semibold min-w-[4rem]"><?=constant('INSTALL');?></th>
                                                <th scope="col" class="p-3.5 text-sm text-start font-semibold min-w-[2rem]"><?=constant('ACTION');?></th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                            <?php
                                            foreach ($data as $value):
                                                $username = User::ifUserExist($value->author) ? User::getInfosUserAll($value->author)->user->username : constant('MEMBER_DELETE');
                                                $install  = $value->install == 1 ? '<i style="color:green" data-feather="check-circle" class="w-4 h-4 me-3"></i>' : '<i data-feather="slash" style="color:red" class="w-4 h-4 me-3"></i>';
                                                if ($value->category == 'templates') {
                                                    $url = 'install';
                                                } else if ($value->category == 'pages' or $value->category == 'cms') {
                                                    $url = 'installPage';
                                                }
                                            ?>
                                            <tr>
                                                <td class="p-3.5 text-sm text-gray-700 dark:text-gray-400">
                                                    <a href="javascript: void(0);" class="font-medium"><?=$value->name;?></a>
                                                </td>
                                                <td class="p-3.5 text-sm text-gray-700 dark:text-gray-400">
                                                    <span class="text-xs"><?=Common::TransformDate($value->date_insert, 'FULL', 'MEDIUM');?></span>
                                                </td>
                                                <td class="p-3.5 text-sm text-gray-700 dark:text-gray-400"><?=Common::ConvertSize($value->size);?></td>
                                                <td class="p-3.5 text-sm text-gray-700 dark:text-gray-400">
                                                    <?=$username;?>
                                                </td>
                                                <td class="p-3.5">
                                                    <?=$value->category;?>
                                                </td>
                                                <td class="p-3.5">
                                                    <?=$install;?>
                                                </td>
                                                <td class="p-3.5">
                                                    <div>
                                                        <button data-fc-type="dropdown" data-fc-placement="bottom-end" class="inline-flex text-slate-700 hover:bg-slate-100 dark:hover:bg-gray-700 dark:text-gray-300 rounded-full p-2">
                                                            <i data-feather="more-vertical" class="w-4 h-4"></i>
                                                        </button>

                                                        <div class="fc-dropdown hidden fc-dropdown-open:opacity-100 opacity-0 w-40 z-50 mt-2 transition-all duration-300 bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 rounded-lg p-2">
                                                            <a class="extract flex items-center py-2 px-4 text-sm rounded text-gray-500  hover:bg-slate-100 hover:text-slate-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="file_manager/<?=$url;?>/<?=$value->id;?>?management&option=extras">
                                                                <i data-feather="edit-3" class="w-4 h-4 me-3"></i>
                                                                Installer
                                                            </a>
                                                            <a target="_blank" class="flex items-center py-2 px-4 text-sm rounded text-gray-500  hover:bg-slate-100 hover:text-slate-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="<?=DS.'uploads'.DS.'tmp'.DS.$value->name;?>">
                                                                <i data-feather="download" class="w-4 h-4 me-3"></i>
                                                                Télécharger
                                                            </a>
                                                            <a class="delete_file flex items-center py-2 px-4 text-sm rounded text-gray-500  hover:bg-slate-100 hover:text-slate-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="file_manager/delete/<?=$value->id;?>?management&option=extras">
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