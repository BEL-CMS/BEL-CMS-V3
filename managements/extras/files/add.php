<?php
use BelCMS\Requires\Common;
?>
<form action="files/sendimg?management&option=extras" enctype="multipart/form-data" method="post">
	<div class="grid lg:grid-cols-4 gap-6">
		<div class="col-span-1 flex flex-col gap-6">
			<div class="card p-6">
				<div class="flex justify-between items-center mb-4">
					<h4 class="card-title">Ajouter</h4>
					<div class="inline-flex items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-700 w-9 h-9">
						<i class="mgc_add_line"></i>
					</div>
				</div>

				<div class="image-upload">
					<label for="file-input">
						<img src="/managements/extras/files/upload_img.png">
					</label>
					<input required id="file-input" name="file" type="file" style="display: none;" accept="image/*,.pdf, .doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document, zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed, audio/*">
				</div>
				<div class="mt-2 mb-2">
					<div class="bg-secondary text-sm text-white rounded-md p-4" role="alert">
						<span class="font-bold">Max taille upload</span> <?=Common::ConvertSize(Common::GetMaximumFileUploadSize())?>
					</div>
				</div>
			</div>
		</div>

		<div class="lg:col-span-3 space-y-6">
			<div class="card p-6">
				<div class="flex justify-between items-center mb-4">
					<p class="card-title">Description</p>
					<div class="inline-flex items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-700 w-9 h-9">
						<i class="mgc_transfer_line"></i>
					</div>
				</div>

				<div class="flex flex-col gap-3">
					<div class="">
						<label for="project-name" class="mb-2 block">Nom<span class="text-red-500">*</span></label>
						<input name="name" type="text" id="project-name" class="form-input" placeholder="Entrez le titre" required>
					</div>

					<div class="">
						<label for="project-description" class="mb-2 block">Description</label>
						<textarea name="description" id="project-description" class="form-input" rows="8" data-lt-tmp-id="lt-644175" spellcheck="true" data-gramm="false"></textarea>
					</div>
					<div class="lg:col-span-4 mt-5">
						<div class="flex gap-3">
							<button type="submit" class="inline-flex items-center rounded-md border border-transparent bg-green-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none">Sauvegarder</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>