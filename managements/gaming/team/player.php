<?php
/**
 * Bel-CMS [Content management system]
 * @version 2.1.0
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2022 Bel-CMS
 * @author as Stive - stive@determe.be
 */

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
if (isset($_SESSION['LOGIN_MANAGEMENT']) && $_SESSION['LOGIN_MANAGEMENT'] === true):
?>
<div class="col-sm-12">
	<div class="block">
	    <div class="block-title">
	        <h2><strong>Selectionner le ou les joueurs qui feront partie de la team :</strong> <?=$team->name?></h2>
	    </div>
	    <form action="/Team/playeredit?management&gaming=true" method="post" class="form-horizontal form-bordered">
	        <div class="form-group">
				<?php
				foreach ($user as $k => $v):
					$checked = in_array($v->hash_key, $userTeam) ? 'checked="checked"' : '';
					?>
		                <div class="input-group">
		                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
		                    <input type="text" id="example-input<?=$checked?>" name="example-input<?=$checked?>" class="form-control" value="<?=$v->username?>" disabled>
		                    <span class="input-group-addon"><input <?=$checked?> type="checkbox" name="team[]" value="<?=$v->hash_key?>" class="flat"></span>
		                </div>
					<?php
				endforeach;
				?>
	        </div>
	        <div class="form-group form-actions">
	            <div class="col-xs-12">
	            	<input type="hidden" name="id" value="<?=$team->id?>">
	                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Submit</button>
	            </div>
	        </div>
	    </form>
	</div>
</div>
<?php
endif;