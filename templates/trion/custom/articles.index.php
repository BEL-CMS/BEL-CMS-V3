
<?php
foreach ($articles as $k => $v):
    $countComment = Comment::countComments('articles', $v->id);
        if ($countComment == 0) {
            $comment = NO_COMMENT;
        } else if($countComment == 1) {
            $comment = '1 '.COMMENT;
        } else {
            $comment = $countComment.' '.COMMENTS;
        }
    ?>

                                        <div class="section-title fl-wrap">
                                            <h2><span><?=$v->name;?></span></h2>
                                        </div>
                                        <div class="project-detail-wrap fl-wrap">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <p style="text-align: justify;"><?=$v->content?></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <ul class="dec-list">
                                                        <li><span>Rubrique </span> : News</li>
                                                        <li><span>Date </span> : <?=Common::transformDate($v->date_create, 'FULL', 'NONE')?> </li>
                                                        <li><span>Vu </span> : <?=$v->view;?></li>
                                                        <li><span>Commentaire </span> : 
                                                            <span><?=$comment;?></span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="page-nav bl-nav">
                                                <a href="https://bel-cms.dev/<?=$v->link;?>" class="appn ajax"><span>Posté un commentaire</span> <i class="fas fa-plus"></i></a>
                                            </div>
                                        </div>
<?php
endforeach;
?>