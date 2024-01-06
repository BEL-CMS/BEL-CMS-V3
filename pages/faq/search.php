<?php
use BelCMS\Core\Notification;
?>
<div id="bel_cms_accordion_search">
    <?php
    foreach ($search as $data):
    ?>
        <div id="bel_cms_accordion_search_row">
            <div id="bel_cms_accordion_search_title"><?=$data->name;?></div>
            <div>
                <?=$data->content;?>
            </div>
        </div>
    <?php    
    endforeach;
    if (empty($search)) {
        Notification::alert(constant('NO_INFO_LOOKING'));
    }
    ?>
</div>