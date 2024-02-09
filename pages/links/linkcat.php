<?php
use BelCMS\Requires\Common;
?>
<h2>Liens Web</h2>
    <a id="main_menu" href="Links"><i class="fa-solid fa-arrow-rotate-left"></i>&nbsp;Retourné à la page principale</a>
<div id="links_cat">
    <ul>
        <?php
        foreach ($data as $v):
        ?>
        <li>
            <a style="color: <?=$v->nameCat->color;?>" href="Links/View/<?=$v->id;?>"><h3><?=$v->name;?></h3><strong><?=$v->link;?></strong></a>
            <div class="links_cat_row_one">
                <span><i class="fa-solid fa-calendar-days"></i>&nbsp;<?=Common::TransformDate($v->date_insert, 'MEDIUM', 'NONE');?></span>
                <span><i class="fa-solid fa-group-arrows-rotate"></i>&nbsp;<?=$v->nameCat->name;?></span>
            </div>
            <div class="links_cat_row_two">
                <span><?=$v->view;?>&nbsp;<i class="fa-regular fa-eye"></i></span>
                <span><?=$v->click;?>&nbsp;<i class="fa-solid fa-link"></i><span>
            </div>
        </li>
        <?php
        endforeach;
        ?>
    </ul>
</div>