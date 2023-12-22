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

use BelCMS\Core\Comment;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
if ($buy->remaining == 0) {
	$buy->remaining = constant('UNLIMITED');
} else {
	$buy->remaining = $buy->remaining - $buy->buy;
}
if ($buy->remaining <= 0) {
	$buy->remaining = '0'.constant('FINISH_BUY');
}
$link = empty($buy->unit) ? 'market/buyConfirm/'.$buy->id.'?add=true' : 'market/buyConfirm/'.$buy->id.'?add=true&f=true';
?>
<section id="belcms_section_market_buy">
	<div id="belcms_section_market_infos">
		<div id="belcms_section_market_img">
			<div id="gallery-wrapper" class="flex justify-center">
			<?php
			foreach ($buy->img as $key => $img):
				if (is_object($img)) {
					$screen = $img->img;
				} else {
					$screen = $img;
				}
			?>
				<div class="belcms_section_market_img_block">
					<a class="image-popup" href="<?=$screen;?>">
						<img src="<?=$screen;?>">
					</a>
				</div>
			<?php
			endforeach;
			?>
			</div>
		</div>
		<div id="belcms_section_market_description">
			<?=$buy->description;?>
		</div>
	</div>
	<div id="belcms_section_market_content">
		<ul>
			<li><span><?=constant('NAME');?></span><i><?=$buy->name;?></i></li>
			<li><span><?=constant('PRICE');?></span><i><?=$buy->amount;?> €</i></li>
			<li><span><?=constant('REMAINING');?></span><i><?=$buy->remaining;?></i></li>
			<li><span><?=constant('VIEW_BUY');?></span><i><?=$buy->view;?> Vu</i></li>
			<li><span><?=constant('NB_BUY');?></span><i><?=$buy->buy;?> <?=constant('NB_BUY_OBJECT');?></i></li>
			<li><span><?=constant('ADD_DATE');?></span><i><?=Common::TransformDate($buy->date_add, 'FULL', 'FULL');?></i></li>
		</ul>
		<div id="belcms_section_market_buy">
			<a href="<?=$link;?>" class="belcms_btn belcms_bg_grey"><?=constant('ADDED_TO_CART');?></a>
		</div>
	</div>
</section>
<?php
$comments = new Comment;
$comments->html();

