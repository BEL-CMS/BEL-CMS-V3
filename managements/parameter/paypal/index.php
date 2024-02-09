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
include_once ROOT.DS.'pages'.DS.'user'.DS.'country.php';
$currency = array (
    'EUR' => 'Euro',
    'AUD' => 'Australian dollar',
    'BRL' => 'Brazilian real',
    'CAD' => 'Canadian dollar',
    'CZK' => 'Czech koruna',
    'DKK' => 'Danish krone',
    'USD' => 'United States dollar',
    'CHF' => 'Swiss franc',
    'SGD' => 'Singapore dollar',
    'GBP' => 'Pound sterling',
    'PHP' => 'Philippine peso'
);
$sandbox  = $data['PAYPAL_SANDBOX'] == 'true' ? 'checked="checked"' : '';
$address = explode('|', $data['PAYPAL_ADRESS']);

// Vérifier si l'indice 1 existe avant de l'utiliser
$cp = isset($address[1]) ? explode(',', $address[1]) : ['', ''];
?>
<form action="PayPal/send?management&option=parameter" method="post" enctype="multipart/form-data">
    <div class="grid lg:grid-cols-4 gap-6">
        <div class="col-span-1 flex flex-col gap-6">
            <div class="card p-6">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="card-title"><?=constant('LOGO_PAYPAL');?></h4>
                    <div class="inline-flex items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-700 w-9 h-9">
                        <i class="mgc_add_line"></i>
                    </div>
                </div>
                <div class="dz-message needsclick w-full">
                    <img src="<?=$data['PAYPAL_LOGO'];?>">
                </div>
                <div class="mb-2 mt-2">
                    <input type="file" accept="image/*" name="logo" class="form-input">
                </div>
            </div>
            <div class="card p-6">
                <div>
                    <div class="flex items-center">
                        <input class="form-switch" type="checkbox" role="switch" name="sanbox" value="true" <?=$sandbox;?>>
                        <label class="ms-1.5"><?=constant('SANBOX');?></label>
                    </div>
                </div>
            </div>
            <div class="card p-6">
                <div>
                    <label for="select-label-catagory" class="mb-2 block"><?=constant('CURRENCY');?></label>
                
                    <select class="t-label-catagory" class="form-select" name="currency">
                        <?php
                        foreach ($currency as $key => $value):
                            if ($data['PAYPAL_CURRENCY'] == $key):
                                echo '<option selected="selected" value="'.$key.'">'.$value.'</option>';
                            else:
                                echo '<option value="'.$key.'">'.$value.'</option>';
                            endif;
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>
            <div class="card p-6">
                <div>
                    <label for="select-label-catagory" class="mb-2 block"><?=constant('COUNTRY');?></label>
                    <select id="select-label-catagory" class="form-select" name="country">
                        <?php
                        foreach (contryList() as $key => $value):
                            if ($data['PAYPAL_COUNTRY'] == $key):
                                echo '<option value="'.$key.'" selected="selected">'.$value.'</option>';
                            else:
                                echo '<option value="'.$key.'">'.$value.'</option>';
                            endif;
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>
            <div class="card p-6">
                <div class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">
                    <button type="submit" class="btn bg-violet-500 border-violet-500 text-white">
                        <i class="fa fa-dot-circle-o"></i><?=constant('SUBMIT');?>
                    </button>
                </div>
            </div>
        </div>
        <div class="lg:col-span-3 space-y-6">
            <div class="card p-6">
                <div class="flex justify-between items-center mb-4">
                    <p class="card-title"><?=constant('GENERAL_INFOS_SANBOX');?> <a href="https://www.sandbox.paypal.com/be/home"><i class="mgc_link_3_fill"></i></a></p>
                    <div class="inline-flex items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-700 w-9 h-9">
                        <i class="mgc_transfer_line"></i>
                    </div>
                </div>
                <div class="flex flex-col gap-3">
                    <div class="mb-2 mt-2">
                        <label class="mb-2 block"><?=constant('SANBOX_CLIENT_ID');?></label>
                        <input type="text" class="form-input" name="paypal_sandbox_client_id" value="<?=$data['PAYPAL_SANDBOX_CLIENT_ID'];?>">
                    </div>
                    <div class="mb-2 mt-2">
                        <label class="mb-2 block"><?=constant('SANBOX_CLIENT_SECRET');?></label>
                        <input type="text" class="form-input" name="paypal_sandbox_client_secret" value="<?=$data['PAYPAL_SANDBOX_CLIENT_SECRET'];?>">
                    </div>
                </div>
            </div>
            <div class="card p-6">
                <div class="flex justify-between items-center mb-4">
                    <p class="card-title"><?=constant('GENERAL_INFOS');?></p>
                    <div class="inline-flex items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-700 w-9 h-9">
                        <i class="mgc_transfer_line"></i>
                    </div>
                </div>
                <div class="flex flex-col gap-3">
                    <div class="mb-2 mt-2">
                        <label class="mb-2 block"><?=constant('CLIENT_ID');?></label>
                        <input type="text" class="form-input" name="prod_client_id" value="<?=$data['PAYPAL_PROD_CLIENT_ID'];?>">
                    </div>
                    <div class="mb-2 mt-2">
                        <label class="mb-2 block"><?=constant('CLIENT_SECRET');?></label>
                        <input type="text" class="form-input" name="prod_client_secret" value="<?=$data['PAYPAL_PROD_CLIENT_SECRET'];?>">
                    </div>
                </div>
            </div>
            <div class="card p-6">
                <div class="flex justify-between items-center mb-4">
                    <p class="card-title"><?=constant('GENERAL_INFOS');?></p>
                    <div class="inline-flex items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-700 w-9 h-9">
                        <i class="mgc_transfer_line"></i>
                    </div>
                </div>
                <div class="flex flex-col gap-3">
                    <div class="mb-2 mt-2">
                        <label class="mb-2 block"><?=constant('STREET');?> & <?=constant('NUMBER');?> </label>
                        <input type="text" class="form-input" name="street" value="<?=$address[0] ?? ''; ?>">
                    </div>
                    <div class="mb-2 mt-2">
                        <label class="mb-2 block"><?=constant('POSTAL_CODE');?></label>
                        <input type="number" min="1" class="form-input" name="cp" value="<?=$cp[0] ?? ''; ?>">
                    </div>
                    <div class="mb-2 mt-2">
                        <label class="mb-2 block"><?=constant('LOCALITY');?></label>
                        <input type="text" class="form-input" name="locality" value="<?=$cp[1] ?? ''; ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>