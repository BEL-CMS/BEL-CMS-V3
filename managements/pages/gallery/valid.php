<?php
use BelCMS\Requires\Common;
?>
<div class="mt-6">
	<div class="card">
		<div class="flex flex-wrap justify-between items-center gap-2 p-6">
			<div class="flex flex-wrap gap-2">
			<a href="gallery/DeleteAll?management&option=pages" class="btn bg-danger/20 text-sm font-medium text-danger hover:text-white hover:bg-danger"><i class="mgc_add_circle_line me-3"></i><?=constant('EMPTY_ALL');?></a>
			</div>
		</div>
		<div class="relative overflow-x-auto">
			<table class="w-full divide-y divide-gray-300 dark:divide-gray-700">
				<thead class="bg-slate-300 bg-opacity-20 border-t dark:bg-slate-800 divide-gray-300 dark:border-gray-700">
					<tr>
						<th scope="col" class="py-3.5 ps-4 pe-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">ID</th>
						<th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200"><?=constant('NAME');?></th>
						<th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200"><?=constant('IMAGES');?></th>
						<th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200"><?=constant('SENT_BY');?></th>
						<th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200"><?=constant('DATE');?></th>
						<th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900 dark:text-gray-200"><?=constant('ACTIONS');?></th>
					</tr>
				</thead>
				<tbody class="divide-y divide-gray-200 dark:divide-gray-700 ">
					<?php
					foreach ($data as $v):
					?>
					<tr>
						<td class="whitespace-nowrap py-4 ps-4 pe-3 text-sm font-medium text-gray-900 dark:text-gray-200"><b># <?=$v->id;?></b></td>
						<td class="whitespace-nowrap py-4 ps-4 pe-3 text-sm font-medium text-gray-900 dark:text-gray-200"><b><?=$v->name;?></b></td>
						<td class="whitespace-nowrap py-4 px-3 text-sm">
							<a href="<?=$v->image;?>" class="glightbox"><img class="h-20 w-20" src="<?=$v->image;?>"></a>
						</td>
						<td class="whitespace-nowrap py-4 pe-3 text-sm">
							<div class="flex items-center">
								<div class="font-medium text-gray-900 dark:text-gray-200 ms-4"><?=$v->author;?></div>
							</div>
						</td>
						<td class="whitespace-nowrap py-4 pe-3 text-sm font-medium text-gray-900 dark:text-gray-200"><?=Common::TransformDate($v->date_insert, 'FULL', 'MEDIUM');?></td>
						<td class="whitespace-nowrap py-4 px-3 text-center text-sm font-medium">
							<a href="gallery/tmpEdit/<?=$v->id?>?management&option=pages" class="me-0.5"> <i class="mgc_edit_line text-lg"></i> </a>
							<a href="javascript:void(0);" class="ms-0.5"> <i class="mgc_delete_line text-xl"></i> </a>
						</td>
					</tr>
					<?php
					endforeach;
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>