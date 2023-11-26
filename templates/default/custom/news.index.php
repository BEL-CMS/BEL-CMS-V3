<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2023 Bel-CMS
 * @author as Stive - stive@determe.be
 */

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

use BelCMS\User\User;
use BelCMS\Requires\Common;
use BelCMS\Core\Comment;
?>
<?php
	foreach ($news as $k => $v):
        $countComment = Comment::countComments('news', $v->id);
        if ($countComment == 0) {
            $comment = constant('NO_COMMENT');
        } else if($countComment == 1) {
            $comment = '1 '.constant('COMMENT');
        } else {
            $comment = $countComment.' '.constant('COMMENTS');
        }

		$countComment = Comment::countComments('news', $v->id);
        $authorname   = User::getInfosUserAll($v->author);

        if ($authorname == false) {
            $authorname = constant('VISITOR');
        } else {
            $authorname = $authorname->user->username;
        }
	?>
    <div class="post row-fluid clearfix">
        <h3 class="post-title"> <i class="icon-pencil"></i><a href="<?=$v->link; ?>"><?=$v->name?></a> </h3>
        <?=$v->content?>
        <div class="meta">
            <span> <i class="icon-user mi"></i> <?=constant('BY');?> : <?=$authorname;?></span>
            <span> <i class="icon-time mi"></i><?=constant('DATE')?> : <?=Common::transformDate($v->date_create, 'FULL', 'NONE')?></span>
            <span> <a href="#"><i class="icon-comments-alt"></i> <?=$comment;?></a> </span>
        </div>
        <div>
            <a href="<?=$v->link?>" class="Rmore tbutton small"><span><?=constant('READ_MORE')?></span></a>
        </div>
    </div>
    <?php
    endforeach;
    ?>