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

namespace BelCMS\Requires;
use \DateTime as DateTime;
use \IntlDateFormatter as IntlDateFormatter;
use BelCMS\PDO\BDD as BDD;
use BelCMS\Core\Secure as Secure;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class Common
{
	#########################################
	# define constant array or simple name
	#########################################
	public static function Constant ($data = false, $value = false)
	{
		if ($data) {
			if (is_array($data)) {
				foreach ($data as $constant => $tableName) {
					if (!defined(strtoupper($constant))) {
						$constant = trim($constant);
						define(strtoupper($constant), $tableName);
					}
				}
			} else {
				if ($value || $data) {
					if (!defined(strtoupper($data))) {
						$data = trim($data);
						define(strtoupper($data), $value);
					}
				}
			}
		}
	}
	#########################################
	# Injecte des Nom dans la $_SESSION[]
	# en array ou simple nom.
	#########################################
	public static function _SESSION ($name = false, $value = false)
	{
		if ($name !== false AND $value !== false) {
			if (is_array($name) and count($name) != 0) {
				foreach ($name as $session => $v) {
					if (isset($_SESSION[$session])) {
						unset($_SESSION[$session]);
					}
					$_SESSION[strtoupper($session)] = self::VarSecure($value, null);
				}
			} else {
				if (!empty($name) or !empty($value)) {
					if (isset($_SESSION[$name])) {
						unset($_SESSION[$name]);
					}
					$name = trim($name);
					if (empty($value)) {
						if (isset($_SESSION[strtoupper($name)])) {
							$_SESSION[strtoupper($name)] = null;
						} else {
							$_SESSION[strtoupper($name)] = self::VarSecure($value, null);
						}
					}
				}
			}
		}
	}
	#########################################
	# Test Empty Var
	#########################################
	public static function IsEmpty($var)
	{
		return (is_array($var) && !count($var)) || (is_string($var) && $var == '') || is_null($var);
	}
	#########################################
	# clear url and constant name
	#########################################
	public static function MakeConstant ($d, $c = false) {
		$chr = array(
			'À' => 'a', 'Á' => 'a', 'Â' => 'a', 'Ä' => 'a', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ä' => 'a', '@' => 'a',
			'È' => 'e', 'É' => 'e', 'Ê' => 'e', 'Ë' => 'e', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', '€' => 'e',
			'Ì' => 'i', 'Í' => 'i', 'Î' => 'i', 'Ï' => 'i', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
			'Ò' => 'o', 'Ó' => 'o', 'Ô' => 'o', 'Ö' => 'o', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'ö' => 'o',
			'Ù' => 'u', 'Ú' => 'u', 'Û' => 'u', 'Ü' => 'u', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'µ' => 'u',
			'Œ' => 'oe', 'œ' => 'oe',
			'$' => 's', '&' => '_AND_', '?' => '%3F', ' ' => '_');
		$return = strtr($d, $chr);
		$return = preg_replace('#[^A-Za-z0-9]+#', '_', $return);
		$return = trim($return, '-');
		if ($c == 'upper') {
			$return = strtoupper($return);
		} else if ($c == 'lower'){
			$return = strtolower($return);
		}
		return $return;
	}

	public static function RemoveAccents ($chaine = '')
	{
		return strtr($chaine, "ÀÁÂàÄÅàáâàäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏ" ."ìíîïÙÚÛÜùúûüÿÑñ", "aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
	}
	#########################################
	# Redirect
	#########################################
	public static function Redirect ($url = null, $time = null)
	{
		$scriptName = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
		$fullUrl    = ($_SERVER['HTTP_HOST'].$scriptName);
		if (!strpos($_SERVER['HTTP_HOST'], $scriptName)) {
			$fullUrl = $_SERVER['HTTP_HOST'].$scriptName.$url;
		}
		if (!strpos($fullUrl, 'http://')) {
			if ($_SERVER['SERVER_PORT'] == 80) {
				$url = 'http://'.$fullUrl;
			} else if ($_SERVER['SERVER_PORT'] == 443) {
				$url = 'https://'.$fullUrl;
			} else {
				$url = 'http://'.$fullUrl;
			}
		}
		$time = (empty($time)) ? 0 : (int) $time * 1000;
		?>
		<script>
		window.setTimeout(function() {
			window.location = '<?php echo $url; ?>';
		}, <?php echo $time; ?>);
		</script>
		<?php
	}
	#########################################
	# Scan directory
	#########################################
	public static function ScanDirectory ($dir = false) {
		$return = array();
		if ($dir) {
			if (is_dir($dir)) {
				$myDirectory = @opendir($dir);
				while($entry = @readdir($myDirectory)) {
					if ($entry != '.' && $entry != '..' && @is_dir($dir.DS.$entry)) {
						$return[] = ($entry);
					}
				}
				@closedir($myDirectory);
			}
		}
		return $return;
	}
	#########################################
	# Scan file
	#########################################
	public static function ScanFiles ($dir, $ext = false, $full_access = false, $Rext = false) {

		$return = array();

		if (is_dir($dir)) {
			if ($dh = opendir($dir)) {
				while (($file = readdir($dh)) !== false) {
					if ($file != '.' && $file != '..') {
						if ($ext) {
							$fileExt = substr ($file, -4);
							if (is_array($ext)) {
								if (array_search($fileExt, $ext)) {
									$return[] = ($full_access) ? $dir.$file : $file;
								}
							} else {
								if ($fileExt == $ext) {
									$return[] = ($full_access) ? $dir.$file : $file;
								}
							}
						} else {
							$return[] = ($full_access) ? $dir.$file : $file;
						}
					}
				}
				closedir($dh);
			}
		}
		if ($Rext === true && !empty($ext)) {
			foreach ($return as $k => $v) {
				$remove = '.'.$ext;
				$return[$k] = basename($v, $remove);
			}
		}
		return $return;
	}
	#########################################
	# Get IP
	#########################################
	public static function GetIp ()
	{
		if (isset($_SERVER['HTTP_CLIENT_IP']) and !empty($_SERVER['HTTP_CLIENT_IP'])) {
			$return = $_SERVER['HTTP_CLIENT_IP'];
		} else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) and !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$return = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$return = (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : $_SERVER['HTTP_CLIENT_IP']);
		}
		// IP Local
		if ($return == '::1') {
			$return = '127.0.0.1';
		}
		return $return;
	}
	#########################################
	# Localisation géographique par IP
	#########################################
	/*
	public static function GeoIP ($ip)
	{
		if (function_exists('\geoip_country_name_by_name')) {
			$country = \geoip_country_name_by_name($ip);
				if ($country) {
					$return = $country;
				} else {
				$return = (bool) false;
			}
			$return = false;
		} else {
			return false;
		}
		return $return;
	}
	#########################################
	# Module [...] Apache disponible ou non
	# Return true or false
	#########################################
	/*
	public static function getModuleApache ($name)
	{
		if (!empty($name)) {
			$mods = apache_get_modules();
			if (array_search($name,$mods)){
				$return = (bool) true;
			} else {
				$return = (bool) false;
			}
		} else {
			$return = (bool) false;
		}
		return $return;
	}
	*/
	#########################################
	# Date & DATETIME SQL
	#########################################
	public static function DatetimeSQL ($date, $time = false, $custom = false)
	{

		if ($date == '31-11-0001' or $date == '0000-00-00' or $date == '30-11-0001') {
			return date('Y-m-d');
		}

		$date = str_replace(' ', '', $date);
		$date = str_replace('/', '-', $date);

		if (!empty($custom)) {
			$date = new DateTime($date);
			$return = $date->format($custom);
		} else {
			if ($time) {
				$date = new DateTime($date);
				$return = $date->format('d/m/Y H:i:s');
			} else {
				$date = new DateTime($date);
				$return = $date->format('d/m/Y');
			}
		}

		return $return;
	}
	#########################################
	# Date return date(..-..-....);
	#########################################
	public static function DatetimeReverse ($date)
	{
		if ($date == '31-11-0001' or $date == '0000-00-00' or $date == '30-11-0001') {
			return date('Y-m-d');
		}
		$date = str_replace(' ', '', $date);
		$date = str_replace('/', '-', $date);
		return $date;
	}
	#########################################
	# Transform date
	# Le format à utiliser pour les dates:
	#	IntlDateFormatter::NONE (masque la date)
	#	IntlDateFormatter::SHORT (14/07/2017)
	#	IntlDateFormatter::MEDIUM (14 juil. 2017)
	#	IntlDateFormatter::LONG (14 juillet 2017)
	#	IntlDateFormatter::FULL (vendredi 14 juillet 2017)
	# Le format à utiliser pour l'heure:
	#	IntlDateFormatter::NONE (masque l'heure)
	#	IntlDateFormatter::SHORT (00:00)
	#	IntlDateFormatter::MEDIUM (à 00:00:00)
	#	IntlDateFormatter::LONG (à 00:00:00 UTC+2)
	#	IntlDateFormatter::FULL (à 00:00:00 heure d’été d’Europe centrale)
	#########################################
	public static function TransformDate ($date, $d = 'NONE', $t = 'NONE')
	{
		# fix empty date - 30-11-0001
		if ($date == '31-11-0001' or $date == '0000-00-00' or $date == '30-11--0001') {
			return date('Y-m-d');
		}

		if (constant('CMS_WEBSITE_LANG') == constant('FRENCH')) {
			$lg = 'fr_FR';
		} else if (constant('CMS_WEBSITE_LANG') == constant('ENGLISH')) {
			$lg = 'en_US';
		} else if (constant('CMS_WEBSITE_LANG') == constant('NETHERLANDS')) {
			$lg = 'nl_NL';
		} else if (constant('CMS_WEBSITE_LANG') == constant('DEUTCH')) {
			$lg = 'de_DE';
		}

		$d    = strtoupper($d); $t = strtoupper($t);
		$date = str_replace('/', '-', $date);
		$date = new DateTime($date);

		if ($d == 'NONE' && $t == 'NONE') {
			$return = new IntlDateFormatter($lg, IntlDateFormatter::NONE, IntlDateFormatter::NONE);
		} else if ($d == 'SHORT' && $t == 'NONE') {
			$return = new IntlDateFormatter($lg, IntlDateFormatter::SHORT, IntlDateFormatter::NONE);
		} else if ($d == 'MEDIUM' && $t == 'NONE') {
			$return = new IntlDateFormatter($lg, IntlDateFormatter::MEDIUM, IntlDateFormatter::NONE);
		} else if ($d == 'LONG' && $t == 'NONE') {
			$return = new IntlDateFormatter($lg, IntlDateFormatter::LONG, IntlDateFormatter::NONE);
		} else if ($d == 'FULL' && $t == 'NONE') {
			$return = new IntlDateFormatter($lg, IntlDateFormatter::FULL, IntlDateFormatter::NONE);
		}
		else if ($d == 'NONE' && $t == 'SHORT') {
			$return = new IntlDateFormatter($lg, IntlDateFormatter::NONE, IntlDateFormatter::SHORT);
		} else if ($d == 'SHORT' && $t == 'SHORT') {
			$return = new IntlDateFormatter($lg, IntlDateFormatter::SHORT, IntlDateFormatter::SHORT);
		} else if ($d == 'MEDIUM' && $t == 'SHORT') {
			$return = new IntlDateFormatter($lg, IntlDateFormatter::MEDIUM, IntlDateFormatter::SHORT);
		} else if ($d == 'LONG' && $t == 'SHORT') {
			$return = new IntlDateFormatter($lg, IntlDateFormatter::LONG, IntlDateFormatter::SHORT);
		} else if ($d == 'FULL' && $t == 'SHORT') {
			$return = new IntlDateFormatter($lg, IntlDateFormatter::FULL, IntlDateFormatter::SHORT);
		}
		else if ($d == 'NONE' && $t == 'MEDIUM') {
			$return = new IntlDateFormatter($lg, IntlDateFormatter::NONE, IntlDateFormatter::MEDIUM);
		} else if ($d == 'SHORT' && $t == 'MEDIUM') {
			$return = new IntlDateFormatter($lg, IntlDateFormatter::SHORT, IntlDateFormatter::MEDIUM);
		} else if ($d == 'MEDIUM' && $t == 'MEDIUM') {
			$return = new IntlDateFormatter($lg, IntlDateFormatter::MEDIUM, IntlDateFormatter::MEDIUM);
		} else if ($d == 'LONG' && $t == 'MEDIUM') {
			$return = new IntlDateFormatter($lg, IntlDateFormatter::LONG, IntlDateFormatter::MEDIUM);
		} else if ($d == 'FULL' && $t == 'MEDIUM') {
			$return = new IntlDateFormatter($lg, IntlDateFormatter::FULL, IntlDateFormatter::MEDIUM);
		}
		else if ($d == 'NONE' && $t == 'LONG') {
			$return = new IntlDateFormatter($lg, IntlDateFormatter::NONE, IntlDateFormatter::LONG);
		} else if ($d == 'SHORT' && $t == 'LONG') {
			$return = new IntlDateFormatter($lg, IntlDateFormatter::SHORT, IntlDateFormatter::LONG);
		} else if ($d == 'MEDIUM' && $t == 'LONG') {
			$return = new IntlDateFormatter($lg, IntlDateFormatter::MEDIUM, IntlDateFormatter::LONG);
		} else if ($d == 'LONG' && $t == 'LONG') {
			$return = new IntlDateFormatter($lg, IntlDateFormatter::LONG, IntlDateFormatter::LONG);
		} else if ($d == 'FULL' && $t == 'LONG') {
			$return = new IntlDateFormatter($lg, IntlDateFormatter::FULL, IntlDateFormatter::LONG);
		}
		else if ($d == 'NONE' && $t == 'FULL') {
			$return = new IntlDateFormatter($lg, IntlDateFormatter::NONE, IntlDateFormatter::FULL);
		} else if ($d == 'SHORT' && $t == 'FULL') {
			$return = new IntlDateFormatter($lg, IntlDateFormatter::SHORT, IntlDateFormatter::FULL);
		} else if ($d == 'MEDIUM' && $t == 'FULL') {
			$return = new IntlDateFormatter($lg, IntlDateFormatter::MEDIUM, IntlDateFormatter::FULL);
		} else if ($d == 'LONG' && $t == 'FULL') {
			$return = new IntlDateFormatter($lg, IntlDateFormatter::LONG, IntlDateFormatter::FULL);
		} else if ($d == 'FULL' && $t == 'FULL') {
			$return = new IntlDateFormatter($lg, IntlDateFormatter::FULL, IntlDateFormatter::FULL);
		} else if ($d == 'SQLDATE') {
			$return = new IntlDateFormatter(
				$lg,
				IntlDateFormatter::FULL,
				IntlDateFormatter::FULL,
				'Europe/Brussels',
				IntlDateFormatter::GREGORIAN,
				'yyyy-MM-dd'
			);
		} else if ($d == 'SQLDATETIME') {
			$return = new IntlDateFormatter(
				$lg,
				IntlDateFormatter::FULL,
				IntlDateFormatter::FULL,
				'Europe/Brussels',
				IntlDateFormatter::GREGORIAN,
				'yyyy-MM-dd hh-mm-ss'
			);
		} else {
			$return = new IntlDateFormatter($lg, IntlDateFormatter::FULL, IntlDateFormatter::FULL);
		}

		return $return->format($date);
	}
	#########################################
	# Send Mail
	#########################################
	public static function SendMail (array $data)
	{
		$fromName = (isset($data['name']) AND !empty($data['name'])) ? $data['name'] : 'Bel-CMS MAIL';
		$fromMail = (isset($data['mail']) AND !empty($data['mail'])) ? $data['mail'] : $_SERVER['SERVER_ADMIN'];
		$subject  = (isset($data['subject']) AND !empty($data['subject'])) ? $data['subject'] : 'Bel-CMS MAIL';
		$content  = (isset($data['content']) AND !empty($data['content'])) ? $data['content'] : 'Testing Website mail';
		$sendMail = (isset($data['sendMail']) AND !empty($data['sendMail'])) ? $data['sendMail'] : false;

		if ($sendMail) {

			if (Secure::isMail($sendMail)) {
				$headers   = array();
				$headers[] = "MIME-Version: 1.0";
				$headers[] = 'Content-Type: text/html; charset="utf-8"';
				$headers[] = "From: {$fromName} <{$fromMail}>";
				$headers[] = "Reply-To: NoReply <{$fromMail}>";
				$headers[] = "X-Mailer: PHP/".phpversion();
				$return = @mail($sendMail, $subject, $content, implode("\n", $headers));
			} else {
				$return = false;
			}
		} else {
			$return = false;
		}

		return $return;
	}
	#########################################
	# Convert Size
	#########################################
	public static function ConvertSize ($size)
	{
		$unit = array('byte','Ko','Mo','Gb ','TéraOctet','Pétaoctet');
		return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
	}
	#########################################
	# 
	#########################################
	public static function convertPHPSizeToByte($sSize)
	{
		$sSuffix = strtoupper(substr($sSize, -1));

		if (!in_array($sSuffix,array('P','T','G','M','K'))){
			return (int)$sSize;  
		}

		$iValue = substr($sSize, 0, -1);

		switch ($sSuffix) {
			case 'P':
				$iValue *= 1024;
				// Fallthrough intended
			case 'T':
				$iValue *= 1024;
				// Fallthrough intended
			case 'G':
				$iValue *= 1024;
				// Fallthrough intended
			case 'M':
				$iValue *= 1024;
				// Fallthrough intended
			case 'K':
				$iValue *= 1024;
				break;
		}
		return (int) $iValue;
	}
	#########################################
	# Change all array to Upper
	#########################################
	public static function ArrayChangeCaseUpper($arr)
	{
		return array_map(function($item){
			if (is_array($item)) {
				$item = self::ArrayChangeCaseUpper($item, CASE_UPPER);
			}
			return $item;
		}, array_change_key_case($arr, CASE_UPPER));
	}
	#########################################
	# Change all array to Lower
	#########################################
	public static function ArrayChangeCaseLower($arr)
	{
		return array_map(function($item){
			if (is_array($item)) {
				$item = self::ArrayChangeCaseLower($item, CASE_LOWER);
			}
			return $item;
		}, array_change_key_case($arr, CASE_LOWER));
	}
	#########################################
	# Secure PHP - HTML Var
	#########################################
	public static function VarSecure ($data = null, $authorised = 'html') {
		$return = null;
		$base_html = '<p><hr><em><big><a><b><u><s><i><div><img><pre><br><ul><li><ol><tr><td><th><table><tbody><thead><tfoot><colgroup><span><strong><blockquote><iframe><font><h1><h2><h3><h4><h5><h6><font><sup><sub><section><article><button><figure><form><input><video><code>';

		if ($authorised == 'html') {
			$authorised = $base_html;
		} else if ($authorised == null) {
			$authorised = '';
		}

		if ($data != null) {
			if (is_array($data)) {
				foreach ($data as $k => $v) {
					$return[$k] = strip_tags($v, $authorised);
				}
			} else {
				$return = strip_tags($data, $authorised);
			}
		}

		return $return;
	}
	public static function removeBlank ($data = null)
	{
		$return = null;

		if ($data !== null) {
			$return = str_replace(' ','',$data);
		}

		return $return;
	}

	public static function getSmiley ($text)
	{
		$smiley = array();
		$img    = array();
		$sql    = New BDD();
		$sql->table('TABLE_EMOTICONES');
		$sql->queryAll();
		$data   = $sql->data;

		foreach ($data as $key => $value) {
			$smiley[] = $value->code;
			$img[]    = '<img src="'.$value->dir.'" alt="emoticone">';
		}
		$text = str_replace($smiley,$img,$text);

		return $text;
	}
	#########################################
	# Request ID or rewrite_name secure
	#########################################
	public static function SecureRequest ($data = false) {

		$return = false;

		if ($data) {
			if (is_numeric($data)) {
				$return = intval($data);
			} else {
				$return = Common::VarSecure($data, null);
			}
		}

		return $return;
	}
	#########################################
	# Request ID hash_key
	#########################################
	public static function hash_key ($data = false) {
		if ($data) {
			if (ctype_alnum($data) && strlen($data) == 32) {
				return true;
			} else {
				return false;
			}
		}
	}
	#########################################
	# Check exist page
	#########################################
	public static function ExistsPage ($search = null) : bool
	{
		$return = (bool) false;
		$search = current(Common::ArrayChangeCaseLower(array($search)));
		if (!empty($search)) {
			$return = in_array($search, self::ScanDirectory(constant('DIR_PAGES'))) ? true : false;
		}
		return (bool) $return;
	}
	public static function translate ($data, $ucfirst = true) {
		$str  = $data;
		$data = self::makeConstant($data);
		$data = strtoupper($data);
		if (defined($data)) {
			$return = $ucfirst === true ? ucfirst(constant($data)) : $str;
		} else {
			$return = $ucfirst === true ? ucfirst($str) : $str;
		}
		return $return;
	}
	public static function transformOpt ($data, $reverse = false, $bool = false) {
		$return = array();
		if ($reverse === false) {
			$opt = explode('|', $data);
			foreach ($opt as $k => $v) {
				$tmp_opt = explode('=', $v);
				if ($bool === true) {
					$return[$tmp_opt[0]] = $tmp_opt[1] == 1 ? true : false;
				} else {
					$return[$tmp_opt[0]] = $tmp_opt[1];
				}
			}
		} else if ($reverse === true) {
			foreach ($data as $k => $v) {
				$v = (empty($v)) ? '0' : $v;
				$return[] = $k.'='.$v;
			}
			$return = implode('|', $return);
		}
		return $return;
	}
	public static function PaginationCount ($nb, $table, $where = false)
	{
		$return = 0;

		$sql = New BDD();
		$sql->table($table);
		if ($where !== false) {
			$sql->where($where);
		}
		$sql->count();
		$return = $sql->data;

		return $return;
	}
	#########################################
	# Security Upload
	#########################################
	public static function Upload ($name, $dir, $ext = false)
	{
		if ($_FILES[$name]['error'] != 4) {
			$return  = '';
			$dir     = $dir;
			$file    = basename($_FILES[$name]['name']);
			$sizeMax = self::GetMaximumFileUploadSize();
			$size    = filesize($_FILES[$name]['tmp_name']);

			if (!file_exists($dir)) {
				mkdir($dir, 0777);
			}

			if (!is_writable($dir)) {
				chmod($dir, 0777);
			}

			if ($ext !== false) {
				$extensions = $ext;
			} else {
				$extensions = array('.png', '.gif', '.jpg', '.ico', '.jpeg', '.doc', '.txt', '.pdf', '.rar', '.zip', '.7zip');
			}

			$extension = strrchr($_FILES[$name]['name'], '.');
			if (!in_array($extension, $extensions)):
				$err = constant('UPLOAD_ERROR_FILE');
			endif;

			if ($size>$sizeMax):
				$err = constant('UPLOAD_ERROR_SIZE');
			endif;

			if (!isset($err)):
				if (move_uploaded_file($_FILES[$name]['tmp_name'], $dir .'/'. ($file))):
					$return = constant('UPLOAD_FILE_SUCCESS');
				else:
					$return = constant('UPLOAD_ERROR');
				endif;
			else:
				$return = $err;
			endif;
		} else {
			$return = 'UPLOAD_NONE';
		}
		return $return;
	}
	public static function FormatName ($n)
	{
		$n = strtr($n,
			'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
			'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
		$n = preg_replace('/([^.a-z0-9]+)/i', '-', $n);
		return $n;
	}
	public static function SizeFile ($file = false)
	{
		$return = filesize($file);
		$return = self::ConvertSize($return);
		return $return;
	}

	public static function return_bytes($val) {
		$val = trim($val);
		$last = strtolower($val[strlen($val)-1]);
		switch($last) {
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
			case 'k':
				$val *= 1024;
		}
		return $val;
	}
	public static function ConvertPHPSizeToBytes ($s)
	{
		if (is_numeric($s)) {
			return $s;
		}
		$suffix = substr($s, -1);
		$r = substr($s, 0, -1);
		switch(strtoupper($suffix)) {
			case 'P':
				$r *= 1024;
			case 'T':
				$r *= 1024;
			case 'G':
				$r *= 1024;
			case 'M':
				$r *= 1024;
			case 'K':
				$r *= 1024;
			break;
		}
		return $r;
	}
	public static function size($size, array $options=null) {

		$o = [
			'binary' => false,
			'decimalPlaces' => 2,
			'decimalSeparator' => '.',
			'thausandsSeparator' => '',
			'maxThreshold' => false,
			'sufix' => [
				'thresholds' => ['octet', 'Ko', 'Mo', 'Giga', 'téraoctet', 'pétaoctet', 'E', 'Z', 'Y'],
				'decimal' => ' {threshold}',
				'binary' => ' {threshold}iB'
			]
		];

		if ($options !== null)
			$o = array_replace_recursive($o, $options);

		$count = count($o['sufix']['thresholds']);
		$pow = $o['binary'] ? 1024 : 1000;

		for ($i = 0; $i < $count; $i++)

			if (($size < pow($pow, $i + 1)) ||
				($i === $o['maxThreshold']) ||
				($i === ($count - 1))
			)
				return

					number_format(
						$size / pow($pow, $i),
						$o['decimalPlaces'],
						$o['decimalSeparator'],
						$o['thausandsSeparator']
					) .

					str_replace(
						'{threshold}',
						$o['sufix']['thresholds'][$i],
						$o['sufix'][$o['binary'] ? 'binary' : 'decimal']
					);
	}
	public static function GetMaximumFileUploadSize()
	{
		return min(self::ConvertPHPSizeToBytes(ini_get('post_max_size')), self::ConvertPHPSizeToBytes(ini_get('upload_max_filesize')));
	}
	public static function SiteMap()
	{
		$fp = fopen(ROOT.'/sitemap.xml', 'w+');
		if ($fp !== false){
			$file = '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;
			$file .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL;

			$scanDir = self::ScanDirectory(ROOT);
			$pages	 = array();

			$file .= '<url>'.PHP_EOL;
			$file .= '<loc>'.ROOT.'</loc>'.PHP_EOL;
			$file .= '<changefreq>daily</changefreq>'.PHP_EOL;
			$file .= '<priority>1</priority>'.PHP_EOL;
			$file .= '</url>'.PHP_EOL;

			foreach ($scanDir as $k => $v) {
				$file .= '<url>'.PHP_EOL;
				$file .= '<loc>'.ROOT.$v.'</loc>'.PHP_EOL;
				$file .= '<changefreq>daily</changefreq>'.PHP_EOL;
				$file .= '<priority>0.80</priority>'.PHP_EOL;
				$file .= '</url>'.PHP_EOL;
			}
			$file .= '</urlset>'.PHP_EOL;
			fwrite($fp, chr(0xEF) . chr(0xBB)  . chr(0xBF) . $file); //Ajout de la marque d'Octet
			fclose($fp);
		}
	}
	public static function truncate($text, $chars = 25) {
		if (strlen($text) <= $chars) {
			return $text;
		}
		$text = $text." ";
		$text = substr($text,0,$chars);
		$text = substr($text,0,strrpos($text,' '));
		if (strlen($text) < $chars) {
			$text = $text."...";
		}
		return $text;
	}
}
function cesure_href($d) {
	return '<a href="' . $d[1] . '" title="' . $d[1] . '" >[Lien]</a>';
}
function fixUrl ($d) {
	return strtr($d, array('?' => '%3F'));
}
function defixUrl ($d) {
	return strtr($d, array('%3F' => '?'));
}