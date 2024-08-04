<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.8 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<form action="pricing/sendadd?management&option=pages" method="post">
	<div class="grid lg:grid-cols-2 gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('PRICING');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('NAME');?></label>
						<input name="name" type="text" class="form-input" id="input-name" required="required">
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('ORDER');?></label>
						<input name="sort_asc" type="number" min="1" class="form-input" id="input-name" value="" required>
					</div>
					<div>
						<div class="relative">
							<input type="number" id="input-with-leading-and-trailing-icon" name="price" class="form-input ps-11 pe-14" placeholder="0.00" value="0">
							<div class="absolute inset-y-0 start-4 flex items-center pointer-events-none z-20">
								<span class="text-gray-500">€</span>
							</div>
							<div class="absolute inset-y-0 end-4 flex items-center pointer-events-none z-20">
								<span class="text-gray-500">EUR</span>
							</div>
						</div>
					</div>
					<div class="flex">
						<div class="mt-2 mb-2 inline-flex items-center whitespace-nowrap px-3 rounded-s border border-e-0 border-gray-200 bg-gray-50 text-gray-500 dark:bg-gray-700 dark:border-gray-700 dark:text-gray-400">description</div>
						<textarea name="description" rows="4" class="form-textarea ltr:rounded-s-none rtl:rounded-e-none mt-2 mb-2"></textarea>
					</div>
					<div>
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">Par jour / mois / année</label>
						<select class="form-select" name="per">
							<option value="day">Jour</option>
							<option value="month">Mois</option>
							<option value="year">Année</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('LISTING');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div>
					<div class="flex flex-col gap-2">
						<?php
						foreach ($list as $k => $n):
						?>
						<div class="form-check">
							<input type="radio" class="form-radio text-primary" name="list" value="<?=$n->id;?>" id="id_<?=$k;?>" checked="<?=$n->id;?>">
							<label class="ms-1.5" for="id_<?=$k;?>"><?=$n->name;?></label>
						</div>
						<?php
						endforeach;
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="mt-2 mb-2 p-6">
			<button type="submit" class="btn bg-violet-500 border-violet-500 text-white">
				<i class="fa fa-dot-circle-o"></i><?=constant('SUBMIT');?>
			</button>
		</div>
	</div>
</form>