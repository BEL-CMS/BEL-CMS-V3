<?php
use BelCMS\Requires\Common;
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
?>
<section id="belcms_section_market_main">
	<?php if (isset($cat) and !empty($cat)): ?>
	<div id="belcms_section_market_cat">
		<ul>
			<?php
			foreach ($cat as $cat_id => $cat_value):
			?>
				<li><a data="<?=$cat_value->name;?>" class="belcms_tooltip_bottom" href="Market/category/<?=$cat_value->id;?>"><img src="<?=$cat_value->img;?>" alt=""></a></li>
			<?php
			endforeach;
			?>
		</ul>
	</div>
	<?php endif; ?>
	<div id="belcms_section_market_content">
		<?php
		foreach ($buy as $buy_id => $buy_value):
			$countImg = count($buy_value->img);
			if ($countImg == 1) {
				if (isset($buy_value->img[0]->img)) {
					$img = $buy_value->img[0]->img;
				} else {
					$img = $buy_value->img[0];
				}
			} else {
				$countImg = (int) rand(0, $countImg);
				$countImg = $countImg -1;
				if ($countImg == '-1') {
					$countImg = 0;
				}
				$img = $buy_value->img[$countImg]->img;
			}
			if ($buy_value->remaining == 0) {
				$buy_value->remaining = constant('UNLIMITED');
			}
		?>
		<div class="belcms_section_market_object">
			<a href="Market/Buy/<?=$buy_value->id;?>" title="<?=$buy_value->name;?>">
				<img src="<?=$img;?>" alt="img_<?=$buy_value->name;?>">
			</a>
			<div class="belcms_section_market_infos">
				<a href="Market/Buy/<?=$buy_value->id;?>" title="<?=$buy_value->name;?>"><?=$buy_value->name;?></a>
				<span><?=$buy_value->amount;?>&ensp;€</span>
			</div>
			<div class="belcms_section_market_date">
				<i><?=Common::TransformDate($buy_value->date_add, 'MEDIUM', 'NONE');?></i>
				<span><i><?=constant('REMAINING');?>&ensp;<?=$buy_value->remaining;?></i></span>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</section>
<?php
if (!empty($pagination)):
?>
	<div class="bel_cms_index_footer">
		<?=$pagination?>
	</div>
<?php
endif;
?>