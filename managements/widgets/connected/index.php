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

use BelCMS\Core\Visitors;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<div class="col-span-1">
    <div class="card mb-6">
        <div class="px-6 py-5 flex justify-between items-center">
            <h4 class="header-title"><?=$data->name;?></h4>
        </div>
        <div class="px-4 py-2 bg-warning/20 text-warning" role="alert">
            <i class="mgc_folder_star_line me-1 text-lg align-baseline"></i> <?=constant('THE_VIEW_NO_REFLECT');?>
        </div>

        <div class="p-6 space-y-3">
            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-grow">
                    <h5 class="font-semibold mb-1"><?=constant('YESTERDAY');?></h5>
                    <p class="text-gray-400"><?=Visitors::getVisitorYesterday()->count?></p>
                </div>
                <div>
                    <?php
                    if ($active['yesterday'] === true):
                        echo '<a href="connected/disabled?management&option=widgets" data-id="yesterday" data-disable="0" class="jqueryDisabled inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-danger/25 text-danger">'.constant('DISABLE').'</a>&ensp;&ensp;<div class="inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-success/90 text-white">'.constant('ACTIVE').'</div>';
                    else:
                        echo '<a href="connected/disabled?management&option=widgets" data-id="yesterday" data-disable="1" class="jqueryDisabled inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-success/90 text-white">'.constant('ACTIVE').'</a>&ensp;&ensp;<div class="inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-danger/25 text-danger">'.constant('DISABLE').'</div>';
                    endif;
                    ?>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0"><?=constant('TODAY');?></h5>
                    <p><?=Visitors::getVisitorDay()->count?></p>
                </div>
                <div>
                <?php
                    if ($active['today'] === true):
                        echo '<a href="connected/disabled?management&option=widgets" data-id="today" data-disable="1" class="jqueryDisabled inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-danger/25 text-danger">'.constant('DISABLE').'</a>&ensp;&ensp;<div class="inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-success/90 text-white">'.constant('ACTIVE').'</div>';
                    else:
                        echo '<a href="connected/disabled?management&option=widgets" data-id="today" data-disable="1" class="jqueryDisabled inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-success/90 text-white">'.constant('ACTIVE').'</a>&ensp;&ensp;<div class="inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-danger/25 text-danger">'.constant('DISABLE').'</div>';
                    endif;
                    ?>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0"><?=constant('NOW');?></h5>
                    <p><?=Visitors::getVisitorConnected()->count?></p>
                </div>
                <div>
                <?php
                    if ($active['now'] === true):
                        echo '<a href="connected/disabled?management&option=widgets" data-id="now" data-disable="1" class="jqueryDisabled inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-danger/25 text-danger">'.constant('DISABLE').'</a>&ensp;&ensp;<div class="inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-success/90 text-white">'.constant('ACTIVE').'</div>';
                    else:
                        echo '<a href="connected/disabled?management&option=widgets" data-id="now" data-disable="1" class="jqueryDisabled inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-success/90 text-white">'.constant('ACTIVE').'</a>&ensp;&ensp;<div class="inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-danger/25 text-danger">'.constant('DISABLE').'</div>';
                    endif;
                    ?>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0"><?=constant('PAGE_VIEW');?></h5>
                    <p><?=$page;?></p>
                </div>
                <div>
                <?php
                    if ($active['page_view'] === true):
                        echo '<a href="connected/disabled?management&option=widgets" data-id="page_view" data-disable="1" class="jqueryDisabled inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-danger/25 text-danger">'.constant('DISABLE').'</a>&ensp;&ensp;<div class="inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-success/90 text-white">'.constant('ACTIVE').'</div>';
                    else:
                        echo '<a href="connected/disabled?management&option=widgets" data-id="page_view" data-disable="1" class="jqueryDisabled inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-success/90 text-white">'.constant('ACTIVE').'</a>&ensp;&ensp;<div class="inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-danger/25 text-danger">'.constant('DISABLE').'</div>';
                    endif;
                    ?>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0"><?=constant('REGISTERED_MEMBERS');?></h5>
                    <p><?=$users;?></p>
                </div>
                <div>
                <?php
                    if ($active['users'] === true):
                        echo '<a href="connected/disabled?management&option=widgets" data-id="users" data-disable="1" class="jqueryDisabled inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-danger/25 text-danger">'.constant('DISABLE').'</a>&ensp;&ensp;<div class="inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-success/90 text-white">'.constant('ACTIVE').'</div>';
                    else:
                        echo '<a href="connected/disabled?management&option=widgets" data-id="users" data-disable="1" class="jqueryDisabled inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-success/90 text-white">'.constant('ACTIVE').'</a>&ensp;&ensp;<div class="inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-danger/25 text-danger">'.constant('DISABLE').'</div>';
                    endif;
                    ?>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0"><?=constant('NEWS_PUBLISHED');?></h5>
                    <p><?=$news;?></p>
                </div>
                <div>
                <?php
                    if ($active['news'] === true):
                        echo '<a href="connected/disabled?management&option=widgets" data-id="news" data-disable="1" class="jqueryDisabled inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-danger/25 text-danger">'.constant('DISABLE').'</a>&ensp;&ensp;<div class="inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-success/90 text-white">'.constant('ACTIVE').'</div>';
                    else:
                        echo '<a href="connected/disabled?management&option=widgets" data-id="news" data-disable="1" class="jqueryDisabled inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-success/90 text-white">'.constant('ACTIVE').'</a>&ensp;&ensp;<div class="inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-danger/25 text-danger">'.constant('DISABLE').'</div>';
                    endif;
                    ?>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0"><?=constant('PUBLISHED_ARTICLES');?></h5>
                    <p><?=$articles;?></p>
                </div>
                <div>
                <?php
                    if ($active['articles'] === true):
                        echo '<a href="connected/disabled?management&option=widgets" data-id="articles" data-disable="1" class="jqueryDisabled inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-danger/25 text-danger">'.constant('DISABLE').'</a>&ensp;&ensp;<div class="inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-success/90 text-white">'.constant('ACTIVE').'</div>';
                    else:
                        echo '<a href="connected/disabled?management&option=widgets" data-id="articles" data-disable="1" class="jqueryDisabled inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-success/90 text-white">'.constant('ACTIVE').'</a>&ensp;&ensp;<div class="inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-danger/25 text-danger">'.constant('DISABLE').'</div>';
                    endif;
                    ?>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0"><?=constant('COMMENTS_POSTED');?></h5>
                    <p><?=$comments;?></p>
                </div>
                <div>
                <?php
                    if ($active['comments'] === true):
                        echo '<a href="connected/disabled?management&option=widgets" data-id="comments" data-disable="1" class="jqueryDisabled inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-danger/25 text-danger">'.constant('DISABLE').'</a>&ensp;&ensp;<div class="inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-success/90 text-white">'.constant('ACTIVE').'</div>';
                    else:
                        echo '<a href="connected/disabled?management&option=widgets" data-id="comments" data-disable="1" class="jqueryDisabled inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-success/90 text-white">'.constant('ACTIVE').'</a>&ensp;&ensp;<div class="inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-danger/25 text-danger">'.constant('DISABLE').'</div>';
                    endif;
                    ?>
                </div>
            </div>
            
            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0"><?=constant('SAVED_LINKS');?></h5>
                    <p><?=$links;?></p>
                </div>
                <div>
                <?php
                    if ($active['yesterday'] === true):
                        echo '<a href="connected/disabled?management&option=widgets" data-id="links" data-disable="1" class="jqueryDisabled inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-danger/25 text-danger">'.constant('DISABLE').'</a>&ensp;&ensp;<div class="inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-success/90 text-white">'.constant('ACTIVE').'</div>';
                    else:
                        echo '<a href="connected/disabled?management&option=widgets" data-id="links" data-disable="1" class="jqueryDisabled inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-success/90 text-white">'.constant('ACTIVE').'</a>&ensp;&ensp;<div class="inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-danger/25 text-danger">'.constant('DISABLE').'</div>';
                    endif;
                    ?>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0"><?=constant('SAVED_FILES');?></h5>
                    <p><?=$files;?></p>
                </div>
                <div>
                <?php
                    if ($active['files'] === true):
                        echo '<a href="connected/disabled?management&option=widgets" data-id="files" data-disable="1" class="jqueryDisabled inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-danger/25 text-danger">'.constant('DISABLE').'</a>&ensp;&ensp;<div class="inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-success/90 text-white">'.constant('ACTIVE').'</div>';
                    else:
                        echo '<a href="connected/disabled?management&option=widgets" data-id="files" data-disable="1" class="jqueryDisabled inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-success/90 text-white">'.constant('ACTIVE').'</a>&ensp;&ensp;<div class="inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-danger/25 text-danger">'.constant('DISABLE').'</div>';
                    endif;
                    ?>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0"><?=constant('RECCORD_IMAGES');?></h5>
                    <p><?=$img;?></p>
                </div>
                <div>
                <?php
                    if ($active['images'] === true):
                        echo '<a href="connected/disabled?management&option=widgets" data-id="images" data-disable="1" class="jqueryDisabled inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-danger/25 text-danger">'.constant('DISABLE').'</a>&ensp;&ensp;<div class="inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-success/90 text-white">'.constant('ACTIVE').'</div>';
                    else:
                        echo '<a href="connected/disabled?management&option=widgets" data-id="images" data-disable="1" class="jqueryDisabled inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-success/90 text-white">'.constant('ACTIVE').'</a>&ensp;&ensp;<div class="inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-danger/25 text-danger">'.constant('DISABLE').'</div>';
                    endif;
                    ?>
                </div>
            </div>

        </div>
    </div>
 </div>
 <script type="text/javascript">
    $('.jqueryDisabled').each(function() {
        $(this).on( "click", function(event) {
            event.preventDefault();
            var name     = $(this).data("id");
            var disabled = $(this).data("disable");
            var href     = $(this).attr('href');
            $.ajax({
                url: href,
                type: 'POST',
                data: {id: name, status: disabled},
                timeout: 4000,
                success: function () {
                    location.reload();
                },
                error: function() {
                   alert('ERROR jQuery');
                }
            });
        });
    });
 </script>