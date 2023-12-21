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

use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class ModelsPayPal
{
	public function getInfosPayPal () : array
	{
        $return = array();
        $sql = new BDD();
        $sql->table('TABLE_PAYPAL');
        $sql->queryAll();
        $data = $sql->data;
        foreach ($data as $key => $value) {
            $return[$value->name] = $value->value;
        }
        $return['PAYPAL_LOGO'] = file_exists(ROOT.$return['PAYPAL_LOGO']) ? $return['PAYPAL_LOGO'] : '#';
        return $return;
    }

    public function sendInfosPayPal ($data = null): array
    {
        $return = array();
        if ($data != null and is_array($data))
        {
            $update['PAYPAL_SANDBOX']               = $data['sanbox'] == 'true' ? 'true' : 'false';
            $update['PAYPAL_SANDBOX_CLIENT_ID']     = Common::VarSecure($data['paypal_sandbox_client_id'], null);
            $update['PAYPAL_SANDBOX_CLIENT_SECRET'] = Common::VarSecure($data['paypal_sandbox_client_secret'], null);
            $update['PAYPAL_PROD_CLIENT_ID']        = Common::VarSecure($data['prod_client_id'], null);
            $update['PAYPAL_PROD_CLIENT_SECRET ']   = Common::VarSecure($data['prod_client_secret'], null);
            $update['PAYPAL_CURRENCY']              = Common::VarSecure($data['currency'], null);
            $update['PAYPAL_COUNTRY']               = Common::VarSecure($data['country'], null);
            $update['PAYPAL_ADRESS']                = $data['street'].'|'.$data['cp'].', '.$data['locality'];

            if (!empty($_FILES['logo']['name'])) {
                $test = Common::Upload('logo', ROOT.DS.'uploads/paypal', false);
                if ($test = constant('UPLOAD_FILE_SUCCESS')) {
                    $update['PAYPAL_LOGO'] = '/uploads/paypal/'.$_FILES['logo']['name'];
                }
            }

            foreach ($update as $name => $value) {
                $where = array('name' => 'name', 'value' => $name);
                $sql = new BDD();
                $sql->table('TABLE_PAYPAL');
                $sql->where($where);
                $sql->update(array('value' => $value));
            }

            $return = array(
                'type' => 'success',
                'text' => constant('SAVE_BDD_SUCCESS')
            );

            return $return;
        }
    }
}