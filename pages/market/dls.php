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
?>
<section id="belcms_billing">
	<h2><?=constant('MY_ORDERS');?></h2>
	<i><?=constant('LINK_UNIQUE');?>&ensp;<a href="javascript:window.location.reload(true)"><i class="fa-solid fa-arrows-rotate fa-spin-pulse"></i></a></i>
	<table id="belcms_billing_table">
		<thead>
			<tr>
				<th><?=constant('ID_BUY');?></th>
				<th class="align_center"><?=constant('NB_DOWNLOADS');?></th>
				<th><?=constant('LINK_DL');?></th>
			</tr>
		</thead>
		<tbody>
            <?php
            foreach ($dls as $value):
            ?>
            <tr>
                <td><?=$value->id_purchase;?></td>
                <td class="align_center"><?=$value->downloads;?></td>
                <td>
                    <a target="" href="Market/dlsLinks/<?=$value->key_dl;?>">
                        <i class="fa-solid fa-download"></i>&ensp;<?=constant('LINK_HERE');?>
                    </a>
                </td>
            </tr>
            <?php
            endforeach;
            ?>
        </tbody>
    </table>
</section>