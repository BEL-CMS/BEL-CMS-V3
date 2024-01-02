<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
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
include ROOT.DS.'pages'.DS.'user'.DS.'country.php';
debug($data, false);
?>
<form action="calendar/sendedit?management&option=pages" enctype="multipart/form-data" method="post" class="form-horizontal">
	<div class="grid lg:grid-cols-1 gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('EVENT');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mb-2">Titre <span class="required">*</span></label>
						<input type="text" name="name" value="<?=$data->name;?>" class="form-input" required>
					</div>
					<div class="mt-2 mb-2">
					    <label class="text-gray-800 text-sm font-medium inline-block mb-2">date de début</label>
						<input type="date" name="start_date" value="<?=$data->start_date;?>" class="form-input" required>
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mb-2">Date de fin<span class="required">*²</span></label>
						<input type="date" name="end_date" value="<?=$data->end_date;?>" class="form-input">
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mb-2">debût de l'événement</label>
						<input type="time" name="start_time" value="<?=$data->start_time;?>" class="form-input">
					</div>
					<div class="mt-2 mb-2">
					<label class="text-gray-800 text-sm font-medium inline-block mb-2">Fin de l'événement</label>
						<div class="col-sm-12">
							<div class="input-group">
								<input type="time" name="end_time" value="<?=$data->end_time;?>" class="form-input">
							</div>
						</div>
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mb-2">Couleur</label>
						<select id="color" name="color" required>
							<option><?=constant('CHOOSE_OPTION');?></option>
                            <?php
                            switch ($data->color) {
                                case '0':
                                    echo '<option>'.constant('CHOOSE_OPTION').'</option>';
                                break;

                                case '1':
                                    echo '<option selected value="1" style="background:#ffd15c; color:#FFF;"><span>Couleur #ffd15c</span></option>';
                                break;

                                case '2':
                                    echo '<option selected value="2" style="background:#f21e4e; color:#FFF;"><span>Couleur #f21e4e</span></option>';
                                break;

                                case '3':
                                    echo '<option selected value="3" style="background:#6c6ce5; color:#FFF;"><span>Couleur #6c6ce5</span></option>';
                                break;
                                
                                case '4':
                                    echo '<option selected value="4" style="background:#1da1f3; color:#FFF;"><span>Couleur #1da1f3</span></option>';
                                break;

                                case '5':
                                    echo '<option selected value="5" style="background:#be31a1; color:#FFF;"><span>Couleur #be31a1</span></option>';
                                break;
                            }
                            ?>
							<option value="1" style="background:#ffd15c; color:#FFF;"><span>Couleur #ffd15c</span></option>
							<option value="2" style="background:#f21e4e; color:#FFF;"><span>Couleur #f21e4e</span></option>
							<option value="3" style="background:#6c6ce5; color:#FFF;"><span>Couleur #6c6ce5</span></option>
							<option value="4" style="background:#1da1f3; color:#FFF;"><span>Couleur #1da1f3</span></option>
							<option value="5" style="background:#be31a1; color:#FFF;"><span>Couleur #be31a1</span></option>
						</select>
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mb-2">Localisation</label>
						<select name="location" class="bel_cms_input">
							<?php
							foreach (contryList() as $v):
								if ($v == $data->location) {
									echo '<option selected value="'.$v.'">'.$v.'</option>';
								} else {
									echo '<option value="'.$v.'">'.$v.'</option>';
								}
							endforeach;
							?>
						</select>
					</div>
					<div class="mt-2 mb-2">
					<label class="text-gray-800 text-sm font-medium inline-block mb-2">Description</label>
						<textarea name="description" class="bel_cms_textarea_full" rows="5"><?=$data->description;?></textarea>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="mt-2 mb-2">
		<input type="hidden" name="id" value="<?=$data->id;?>">
		<button type="submit" class="btn bg-violet-500 border-violet-500 text-white">
			<i class="fa fa-dot-circle-o"></i><?=constant('EDIT');?>
		</button>
	</div>
</form>