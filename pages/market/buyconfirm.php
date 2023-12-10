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

use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
debug($data, false);
?>
<section id="belcms_market_buy_confirm">
	<div id="belcms_section_market_confirm_content">
		<div id="belcms_market_buy_confirm_infos">
			<div id="belcms_market_buy_confirm_title"><h2><?=constant('SHOPPING_CART');?></h2></div>
			<ul>
				<?php
				foreach ($data as $value):
					$img = current($value->img)->img;
				?>
				<li>
					<div class="belcms_market_buy_confirm_infos_img">
						<a class="image-popup" href="<?=$img;?>">
							<img src="<?=$img;?>" alt="img_cart_<?=$value->id;?>">
						</a>
					</div>
					<div>
						<h3><?=$value->name;?></h3>
					</div>
				</li>
				<?php
				endforeach;
				?>
			</ul>
		</div>
		<div id="belcms_market_buy_confirm_detailed">
            <div id="belcms_cart_totals">
                <h3><?=constant('CART_TOTALS');?></h3>
                <table>
                    <tr><td><?=constant('NUMBER_OF_PURCHASES');?><td><td>0</td></tr>
                    <tr><td><?=constant('CART_SUBTOTAL');?><td><td>0 €</td></tr>
                    <tr><td><?=constant('SHIPPING_TOTAL');?><td><td>0 €</td></tr>
					<tr><td><?=constant('TAXE_TOTAL');?><td><td>0 €</td></tr>
                    <tr><td><?=constant('TOTAL');?><td><td>0 €</td></tr>
                </table>
                <button class="belcms_bg_grey"><?=constant('PROCEED_TO_CHECKOUT');?></button>
            </div>
		</div>
	</div>
</section>
