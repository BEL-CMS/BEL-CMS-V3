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

use BelCMS\Core\Secures as Secures;
use BelCMS\Requires\Common;
use BELCMS\User\User as UserInfos;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

if (UserInfos::isLogged() === true):
	require_once 'nav.php';
?>
<form action="User/sendGames" method="post">
	<table id="belcms_games_table">
		<caption id="belcms_games_table_caption">
			<?=constant('CHOICE_OF_GAMES');?>
		</caption>
		<tbody>
		<?php
		foreach ($games as $key => $value):
			$banner = is_file($value->banner) ? $value->banner : '/assets/img/no_img_available_728.90.png';
			$user = UserInfos::getInfosUserAll($_SESSION['USER']->user->hash_key);
			$checked = in_array($value->id, $user->games->name_game) ?'checked':'';
		?>
		<tr>
			<td class="belcms_games_img">
				<img src="<?=$banner;?>" alt="banner_<?=$value->name;?>">
			</td>
			<td class="belcms_games_label">
				<label for="<?=$key;?>"><?=$value->name;?></label>
			</td>
			<td class="belcms_games_checkbox">
				<input name="game[]" value="<?=$value->id;?>" type="checkbox" id="<?=$key;?>" <?=$checked;?>>
			</td>
		</tr>
		<?php
		endforeach;
		?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="3">
					<button class="belcms_btn belcms_bg_grey" type="submit"><?=constant('SEND');?></button>
				</td>
			</tr>
	</table>
</form>
<?php 
endif;
?>
