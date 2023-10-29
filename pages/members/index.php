<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.2]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2023 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Requires\Common as Common;
include ROOT.DS.'pages'.DS.'user'.DS.'country.php';

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<section id="belcms_section_members_main">
	<span class="bel-cms-pages_title"><?=constant('MEMBERS')?></span>
	<div class="bel_cms_table">
		<div class="bel_cms_table_row_title">
			<span class="bel_cms_table_row_title_col"><?=constant('USERNAME');?></span>
			<span class="bel_cms_table_row_title_col"><?=constant('LOCATION');?></span>
			<span class="bel_cms_table_row_title_col"><?=constant('GENDER');?></span>
			<span class="bel_cms_table_row_title_col"><?=constant('WEBSITE');?></span>
		</div>
	</div>


<section class="bel_cms_index">
	<div id="bel_cms_index_title">
		<?=constant('MEMBERS')?>
	</div>
	<div id="bel_cms_index_padding">
		<div class="bel_cms_index_table">
			<div class="bel_cms_index_table_row bel_cms_index_table_row_dotted">
				<div class="bel_cms_index_table_th bel_cms_index_table_row_dotted">
					<?=constant('USERNAME');?>
				</div>
				<div class="bel_cms_index_table_th bel_cms_index_table_row_dotted">
					<?=constant('LOCATION');?>
				</div>
				<div class="bel_cms_index_table_th bel_cms_index_table_row_dotted">
					<?=constant('GENDER');?>
				</div>
				<div class="bel_cms_index_table_th belcms_center bel_cms_index_table_row_dotted">
					<?=constant('WEBSITE');?>
				</div>
			</div>
			<?php
			if (empty($members)):
				?>
				<div class="bel_cms_index_table_row bel_cms_index_table_row_dotted">
					<div class="bel_cms_index_table_td full" ><?=constant('NO_USER');?></td>
				</tr>
				<?php
			else:
				foreach ($members as $k => $v):
					if (!empty($v->profils)):
						if ($v->profils->gender == 'male') {
							$gender = constant('MALE');
						} else if ($v->profils->gender == 'female') {
							$gender = constant('FEMALE');
						} else {
							$gender = constant('UNISEXUAL');
						}
						$country  = $v->profils->country;
						$websites = empty($v->profils->websites) ? '<i class="fa fa-link"></i>' : '<a href="'.$v->profils->websites.'"><i class="fa fa-link"></i></a>';
						$flag = array_search($country, contryList());
						$flag = 'flag-icon flag-icon-'.strtolower($flag);
					else:
						$gender   = '-';
						$country  = '-';
						$websites = '<i class="fa fa-link"></i>';
						$flag     = '';
					endif;
					?>
					<div class="bel_cms_index_table_row">
						<div class="bel_cms_index_table_td"><a href="Members/View/<?=$v->username?>"><?=$v->username?></a></div>
						<div class="bel_cms_index_table_td"><span class="<?=$flag?>"></span><span style="padding-left: 10px;"><?=$country?></span></div>
						<div class="bel_cms_index_table_td"><?=$gender?></div>
						<div class="bel_cms_index_table_td belcms_center"><?=$websites?></div>
					</div>
				<?php
				endforeach;
			endif;
			?>
		</div>
	</div>
	<?php
	if (!empty($pagination)):
	?>
		<div class="bel_cms_index_footer">
			<?=$pagination?>
		</div>
	<?php
	endif;
	?>
</section>
