<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.2 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
*/

namespace BelCMS\Core;
use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

################################################
# Class du CMS Captcha
################################################
final class Captcha
{
    public static function createCaptcha ()
    {
        $numberOneRand = rand(1, 9);
        $numberTwoRand = rand(1, 9);
        $OVERALL = $numberOneRand + $numberTwoRand;

        $insert['IP']         = Common::GetIp();
        $insert['code']       = $OVERALL;
        $insert['timelast']   = time();

        self::removeAllCaptcha();

        $cryptTime = Common::encryptDecrypt($insert['timelast'], $_SESSION['CONFIG_CMS']['KEY_ADMIN']);

        setcookie(
            'BELCMS_CAPTCHA_'.$_SESSION['CONFIG_CMS']['COOKIES'],
            $cryptTime,
            time()+60*60*24*30,
            "/",
            $_SERVER['HTTP_HOST'],
            true,
            true
        );

        $sql = new BDD;
        $sql->table('TABLE_CAPTCHA');
        $sql->insert($insert);
        return array('NB_ONE' => $numberOneRand, 'NB_TWO' => $numberTwoRand);
    }

    public static function removeAllCaptcha ()
    {
        $where = array('name' => 'IP', 'value' => Common::GetIp()); 
        $sql = new BDD;
        $sql->table('TABLE_CAPTCHA');
        $sql->where($where);
        $sql->delete();
		setcookie('BELCMS_CAPTCHA_'.$_SESSION['CONFIG_CMS']['COOKIES'], '', time()-60*60*24*365, '/', $_SERVER['HTTP_HOST'], false);
    }
    public static function verifCaptcha ($code)
    {
        if ($_SESSION['CONFIG_CMS']['CAPTCHA'] != 1) { 
            if (isset($_REQUEST['captcha']) and !empty($_REQUEST['captcha'])) {
                return false;
            }
            $code = Common::VarSecure($code, null);
            $where[] = array('name' => 'IP', 'value' => Common::GetIp());
            $where[] = array('name' => 'code', 'value' => $code);
            $sql = new BDD;
            $sql->table('TABLE_CAPTCHA');
            $sql->where($where);
            $sql->queryOne();
            if (!empty($sql->data)) {
                $timeCurrent = time();
                $testingTime = $timeCurrent - $sql->data->timelast;
                if ($testingTime >= $_SESSION['CONFIG_CMS']['CAPTCHA']) {
                    $del = new BDD;
                    $del->table('TABLE_CAPTCHA');
                    $del->where(array('name' => 'IP', 'value' => Common::GetIp()));
                    $del->delete();
                    setcookie('BELCMS_CAPTCHA_'.$_SESSION['CONFIG_CMS']['COOKIES'], 'data', time()-60*60*24*365, '/', $_SERVER['HTTP_HOST'], false);
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return true;
        }
    }

    public static function getActiveCaptcha ()
    {
        if ($_SESSION['CONFIG_CMS']['CAPTCHA'] == '1') {
            return true;
        } else {
            return false;
        }
    }

    public static function getTimeCaptcha ()
    {
        if (isset($_COOKIE['BELCMS_CAPTCHA_'.$_SESSION['CONFIG_CMS']['COOKIES']])) {
            $decrypt = Common::encryptDecrypt($_COOKIE['BELCMS_CAPTCHA_'.$_SESSION['CONFIG_CMS']['COOKIES']], $_SESSION['CONFIG_CMS']['KEY_ADMIN'], false);
            $testingTime = time() - $decrypt;
            if ($testingTime < $_SESSION['CONFIG_CMS']['TIME_CAPTCHA'] or empty($testingTime)) {
                return array('type' => 'warning', 'msg' => constant('CODE_CAPTCHA_TIME'), 'ìnfos' => constant('INFO'));
            }
        }
    }
}