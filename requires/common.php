<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.9 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

namespace BelCMS\Requires;
use \DateTime as DateTime;
use BelCMS\Core\GetHost;
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
									$return[] = ($full_access) ? $dir.DS.$file : $file;
								}
							} else {
								if ($fileExt == $ext) {
									$return[] = ($full_access) ? $dir.DS.$file : $file;
								}
							}
						} else {
							$return[] = ($full_access) ? $dir.DS.$file : $file;
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
		if (isset($_SERVER['SERVER_ADDR']) != empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$return = $_SERVER['SERVER_ADDR'];
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

		if ($_SESSION['CONFIG_CMS']['CMS_WEBSITE_LANG'] == constant('FRENCH')) {
			$lg = 'fr_FR';
		} else if ($_SESSION['CONFIG_CMS']['CMS_WEBSITE_LANG'] == constant('ENGLISH')) {
			$lg = 'en_US';
		} else if ($_SESSION['CONFIG_CMS']['CMS_WEBSITE_LANG'] == constant('NETHERLANDS')) {
			$lg = 'nl_NL';
		} else if ($_SESSION['CONFIG_CMS']['CMS_WEBSITE_LANG'] == constant('DEUTCH')) {
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
		if (is_numeric($size)) {
			$unit = array('byte','Ko','Mo','Gb ','TéraOctet','Pétaoctet');
			return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
		} else {
			return 0;
		}
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
					$return[$k] = trim($return[$k]);
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
	public static function hash_key ($data) {
		return (strlen($data) == 32) ? true : false;
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
		if (!empty($data)) {
			if ($reverse === false) {
				$opt = explode('{||}', $data);
				foreach ($opt as $k => $v) {
					$tmp_opt = explode('==', $v);
					if ($bool === true) {
						$return[$tmp_opt[0]] = $tmp_opt[1] == 1 ? true : false;
					} else {
						$return[$tmp_opt[0]] = $tmp_opt[1];
					}
				}
			} else if ($reverse === true) {
				foreach ($data as $k => $v) {
					$v = (empty($v)) ? '0' : $v;
					$return[] = $k.'=='.$v;
				}
				$return = implode('{||}', $return);
			}
		}
		return $return;
	}
	#########################################
	# Security Upload
	#########################################
	public static function Upload ($name, $dir, $ext = false)
	{
		if ($_FILES[$name]['error'] != 4) {
			$return  = '';
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
				$extensions = array(
				'.png', '.bmp', '.gif', '.jpg', '.ico', '.svg', '.tiff', '.webp', '.jpeg', '.doc', '.txt', '.pdf', '.rar',
				'.zip', '.7zip', '.exe', '.tar', '.psd', '.jar','.avi', '.mpg', '.mpeg', '.av4', '.ac3', '.docx', '.doc', '.mp3',
				'.mp4', '.svg', '.tif', '.tiff', '.txt', '.3gp', '.3g2', '.xml', '.xls', '.xlsx', '.ppt', '.pptx', '.pkg',
				'.iso', '.torrent'
				);
			}

			$extension = strrchr($_FILES[$name]['name'], '.');
			$extension = strtolower($extension);
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
	#########################################
	# Delete all > dir file
	#########################################
	public static function deleteFiles($dir)
	{
		// Assigning files inside the directory
		$dir = new \RecursiveDirectoryIterator(
			$dir, \FilesystemIterator::SKIP_DOTS);
		$dir = new \RecursiveIteratorIterator(
			$dir,\RecursiveIteratorIterator::CHILD_FIRST);
		foreach ( $dir as $file ) { 
			$file->isDir() ?  rmdir($file) : unlink($file);
		}
	}
	#########################################
	# Delete One file
	#########################################
	public static function deleteFile ($file)
	{
		if (file_exists($file)) {
			@unlink($file);
		}
	}
	#########################################
	# Deplace un fichier
	#########################################
	public static function moveFile($dossierSource , $dossierDestination){

		$retour = 1; 
		if(!file_exists($dossierSource)) { 
		 $retour = -1; 
		} else { 
		 if(!copy($dossierSource, $dossierDestination)) { 
		 $retour = -2; 
		 } else { 
		 if(!unlink($dossierSource)) { 
		 $retour = -3; 
		 } 
		 } 
		} 
		return($retour);
	}
	#########################################
	# Retire les accents
	#########################################
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

	public static function truncate ($string, $length = 25, $append="&hellip;")
	{
		$string = trim($string);
	  
		if (strlen($string) > $length) {
		  $string = wordwrap($string, $length);
		  $string = explode("\n", $string, 2);
		  $string = $string[0] . $append;
		}
	  
		return $string;
	}

	public static function cesureHref($d) 
	{
		return '<a href="' . $d[1] . '" title="' . $d[1] . '" >[Lien]</a>';
	}

	public static function randomString($length) {
		$str = random_bytes($length);
		$str = base64_encode($str);
		$str = str_replace(["+", "/", "="], "", $str);
		$str = substr($str, 0, $length);
		return $str;
	}

	public static function encryptDecrypt ($string, $key, $action = true)
	{
		$output = false;
		$encrypt = $action === true ? 'encrypt' : 'decrypt';
		$encrypt_method = "AES-256-CBC";
		$secret_iv      = $_SESSION['CONFIG_CMS']['KEY_ADMIN'];
		$key = hash ('sha256', $key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		if ($encrypt == 'encrypt' ) {
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
		} else if ($encrypt == 'decrypt' ) {
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}
		return $output;
	}
	public static function crypt64($data, $key) {
		$encryption_key = base64_decode($key);
		$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
		$encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
		return base64_encode($encrypted . '::' . $iv);
	}

	public static function decrypt64($data, $key) {
		$encryption_key = base64_decode($key);
		list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
		return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
	}

	public static function crypt ($string, $key)
	{
		$return = openssl_encrypt($string, "AES-128-ECB" ,$key);
		return $return;
	}

	public static function decrypt ($string, $key)
	{
		$return = openssl_decrypt($string, "AES-128-ECB",$key);
		return $return;
	}

	public static function zipAchive ($rootPath, $zipFileName)
	{
		$zip = new \ZipArchive();
		$zipFileName = $zipFileName.'.zip';
		$zip->open($zipFileName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

		$files = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($rootPath),
			\RecursiveIteratorIterator::LEAVES_ONLY
		);

		foreach ($files as $name => $file)
		{
		  if (!$file->isDir()) {
			  $filePath = $file->getRealPath();
			  $relativePath = substr($filePath, strlen($rootPath) + 1);
			  $zip->addFile($filePath, $relativePath);
			}
		}

		$zip->close();
	}

	public static function removeAllDir ($dir)
	{
		$handle = opendir($dir);
		while($elem = readdir($handle)) {
			if(is_dir($dir.'/'.$elem) && substr($elem, -2, 2) !== '..' && substr($elem, -1, 1) !== '.') {
				self::removeAllDir($dir.'/'.$elem);
			} else {
				if(substr($elem, -2, 2) !== '..' && substr($elem, -1, 1) !== '.') {
					unlink($dir.'/'.$elem);
				}
			}        
		}
		$handle = opendir($dir);
		while($elem = readdir($handle)) {
			if(is_dir($dir.'/'.$elem) && substr($elem, -2, 2) !== '..' && substr($elem, -1, 1) !== '.') {
				self::removeAllDir($dir.'/'.$elem);
				rmdir($dir.'/'.$elem);
			}
		}
		rmdir($dir);
	}

	public static function isBot($sistema) {
		   $bots = array(
				 'Googlebot'
			   , 'Baiduspider'
			   , 'ia_archiver'
			   , 'R6_FeedFetcher'
			   , 'NetcraftSurveyAgent'
			   , 'Sogou web spider'
			   , 'bingbot'
			   , 'Yahoo! Slurp'
			   , 'facebookexternalhit'
			   , 'PrintfulBot'
			   , 'msnbot'
			   , 'Twitterbot'
			   , 'UnwindFetchor'
			   , 'urlresolver'
			   , 'Butterfly'
			   , 'TweetmemeBot'
			   , 'PaperLiBot'
			   , 'MJ12bot'
			   , 'AhrefsBot'
			   , 'Exabot'
			   , 'Ezooms'
			   , 'YandexBot'
			   , 'SearchmetricsBot'
			   , 'picsearch'
			   , 'TweetedTimes Bot'
			   , 'QuerySeekerSpider'
			   , 'ShowyouBot'
			   , 'woriobot'
			   , 'merlinkbot'
			   , 'BazQuxBot'
			   , 'Kraken'
			   , 'SISTRIX Crawler'
			   , 'R6_CommentReader'
			   , 'magpie-crawler'
			   , 'GrapeshotCrawler'
			   , 'PercolateCrawler'
			   , 'MaxPointCrawler'
			   , 'NetSeer crawler'
			   , 'grokkit-crawler'
			   , 'SMXCrawler'
			   , 'PulseCrawler'
			   , 'Y!J-BRW'
			   , '80legs'
			   , 'Mediapartners-Google'
			   , 'InAGist'
			   , 'Python-urllib'
			   , 'NING'
			   , 'TencentTraveler'
			   , 'Feedfetcher-Google'
			   , 'mon.itor.us'
			   , 'spbot'
			   , 'Feedly'
			   , 'bitlybot'
			   , 'ADmantX'
			   , 'Niki-Bot'
			   , 'Pinterest'
			   , 'python-requests'
			   , 'DotBot'
			   , 'HTTP_Request2'
			   , 'linkdexbot'
			   , 'A6-Indexer'
			   , 'TwitterFeed'
			   , 'Microsoft Office'
			   , 'Pingdom'
			   , 'BTWebClient'
			   , 'KatBot'
			   , 'SiteCheck'
			   , 'proximic'
			   , 'Sleuth'
			   , 'Abonti'
			   , '(BOT for JCE)'
			   , 'Baidu'
			   , 'Tiny Tiny RSS'
			   , 'newsblur'
			   , 'updown_tester'
			   , 'linkdex'
			   , 'baidu'
			   , 'searchmetrics'
			   , 'genieo'
			   , 'majestic12'
			   , 'spinn3r'
			   , 'profound'
			   , 'domainappender'
			   , 'VegeBot'
			   , 'terrykyleseoagency.com'
			   , 'CommonCrawler Node'
			   , 'AdlesseBot'
			   , 'metauri.com'
			   , 'libwww-perl'
			   , 'rogerbot-crawler'
			   , 'ltx71'
			   , 'Qwantify'
			   , 'Traackr.com'
			   , 'Re-Animator Bot'
			   , 'Pcore-HTTP'
			   , 'BoardReader'
			   , 'omgili'
			   , 'okhttp'
			   , 'CCBot'
			   , 'Java/1.8'
			   , 'semrush.com'
			   , 'feedbot'
			   , 'CommonCrawler'
			   , 'MetaURI'
			   , 'ibwww-perl'
			   , 'rogerbot'
			   , 'MegaIndex'
			   , 'BLEXBot'
			   , 'FlipboardProxy'
			   , 'techinfo@ubermetrics-technologies.com'
			   , 'trendictionbot'
			   , 'Mediatoolkitbot'
			   , 'trendiction'
			   , 'ubermetrics'
			   , 'ScooperBot'
			   , 'TrendsmapResolver'
			   , 'Nuzzel'
			   , 'Go-http-client'
			   , 'Applebot'
			   , 'LivelapBot'
			   , 'GroupHigh'
			   , 'SemrushBot'
			   , 'commoncrawl'
			   , 'istellabot'
			   , 'DomainCrawler'
			   , 'cs.daum.net'
			   , 'StormCrawler'
			   , 'GarlikCrawler'
			   , 'The Knowledge AI'
			   , 'getstream.io/winds'
			   , 'YisouSpider'
			   , 'archive.org_bot'
			   , 'semantic-visions.com'
			   , 'FemtosearchBot'
			   , '360Spider'
			   , 'linkfluence.com'
			   , 'glutenfreepleasure.com'
			   , 'Gluten Free Crawler'
			   , 'YaK/1.0'
			   , 'Cliqzbot'
			   , 'app.hypefactors.com'
			   , 'axios'
			   , 'webdatastats.com'
			   , 'schmorp.de'
			   , 'SEOkicks'
			   , 'DuckDuckBot'
			   , 'Barkrowler'
			   , 'ZoominfoBot'
			   , 'Linguee Bot'
			   , 'Mail.RU_Bot'
			   , 'OnalyticaBot'
			   , 'admantx-adform'
			   , 'Zombiebot'
			   , 'Nutch'
			   , 'SemanticScholarBot'
			   , 'Jetslide'
			   , 'scalaj-http'
			   , 'XoviBot'
			   , 'sysomos.com'
			   , 'PocketParser'
			   , 'newspaper'
			   , 'serpstatbot'
			   , 'MetaJobBot'
			   , 'SeznamBot/3.2'
			   , 'VelenPublicWebCrawler/1.0'
			   , 'WordPress.com mShots'
			   , 'adscanner'
			   , 'BacklinkCrawler'
			   , 'netEstate NE Crawler'
			   , 'Astute SRM'
			   , 'GigablastOpenSource/1.0'
			   , 'DomainStatsBot'
			   , 'Winds: Open Source RSS & Podcast'
			   , 'dlvr.it'
			   , 'BehloolBot'
			   , '7Siters'
			   , 'AwarioSmartBot'
			   , 'Apache-HttpClient/5'
			   , 'Seekport Crawler'
			   , 'AHC/2.1'
			   , 'eCairn-Grabber'
			   , 'mediawords bot'
			   , 'PHP-Curl-Class'
			   , 'Scrapy'
			   , 'curl/7'
			   , 'Blackboard'
			   , 'NetNewsWire'
			   , 'node-fetch'
			   , 'admantx'
			   , 'metadataparser'
			   , 'Domains Project'
			   , 'SerendeputyBot'
			   , 'Moreover'
			   , 'DuckDuckGo' 
			   , 'monitoring-plugins'
			   , 'Selfoss'
			   , 'Adsbot'
			   , 'acebookexternalhit'
			   , 'SpiderLing'
			   , 'Cocolyzebot'
			   , 'TTD-Content'
			   , 'superfeedr'
			   , 'Twingly'
			   , 'Google-Apps-Scrip'
			   , 'LinkpadBot'
			   , 'CensysInspect'
			   , 'Reeder'
			   , 'tweetedtimes'
			   , 'Amazonbot'
			   , 'MauiBot'
			   , 'Symfony BrowserKit'
			   , 'DataForSeoBot'
			   , 'GoogleProducer'
			   , 'TinEye-bot-live'
			   , 'sindresorhus/got'
			   , 'CriteoBot'
			   , 'Down/5'
			   , 'Yahoo Ad monitoring'
			   , 'MetaInspector'
			   , 'PetalBot'
			   , 'MetadataScraper'
			   , 'Cloudflare SpeedTest'
			   , 'aiohttp'
			   , 'AppEngine-Google'
			   , 'heritrix'
			   , 'sqlmap'
			   , 'Buck'
			   , 'wp_is_mobile'
			   , '01h4x.com'
			   , '404checker'
			   , '404enemy'
			   , 'AIBOT'
			   , 'ALittle Client'
			   , 'ASPSeek'
			   , 'Aboundex'
			   , 'Acunetix'
			   , 'AfD-Verbotsverfahren'
			   , 'AiHitBot'
			   , 'Aipbot'
			   , 'Alexibot'
			   , 'AllSubmitter'
			   , 'Alligator'
			   , 'AlphaBot'
			   , 'Anarchie'
			   , 'Anarchy'
			   , 'Anarchy99'
			   , 'Ankit'
			   , 'Anthill'
			   , 'Apexoo'
			   , 'Aspiegel'
			   , 'Asterias'
			   , 'Atomseobot'
			   , 'Attach'
			   , 'AwarioRssBot'
			   , 'BBBike'
			   , 'BDCbot'
			   , 'BDFetch'
			   , 'BackDoorBot'
			   , 'BackStreet'
			   , 'BackWeb'
			   , 'Backlink-Ceck'
			   , 'Badass'
			   , 'Bandit'
			   , 'BatchFTP'
			   , 'Battleztar Bazinga'
			   , 'BetaBot'
			   , 'Bigfoot'
			   , 'Bitacle'
			   , 'BlackWidow'
			   , 'Black Hole'
			   , 'Blow'
			   , 'BlowFish'
			   , 'Boardreader'
			   , 'Bolt'
			   , 'BotALot'
			   , 'Brandprotect'
			   , 'Brandwatch'
			   , 'Buddy'
			   , 'BuiltBotTough'
			   , 'BuiltWith'
			   , 'Bullseye'
			   , 'BunnySlippers'
			   , 'BuzzSumo'
			   , 'CATExplorador'
			   , 'CODE87'
			   , 'CSHttp'
			   , 'Calculon'
			   , 'CazoodleBot'
			   , 'Cegbfeieh'
			   , 'CheTeam'
			   , 'CheeseBot'
			   , 'CherryPicker'
			   , 'ChinaClaw'
			   , 'Chlooe'
			   , 'Citoid'
			   , 'Claritybot'
			   , 'Cloud mapping'
			   , 'Cogentbot'
			   , 'Collector'
			   , 'Copier'
			   , 'CopyRightCheck'
			   , 'Copyscape'
			   , 'Cosmos'
			   , 'Craftbot'
			   , 'Crawling at Home Project'
			   , 'CrazyWebCrawler'
			   , 'Crescent'
			   , 'CrunchBot'
			   , 'Curious'
			   , 'Custo'
			   , 'CyotekWebCopy'
			   , 'DBLBot'
			   , 'DIIbot'
			   , 'DSearch'
			   , 'DTS Agent'
			   , 'DataCha0s'
			   , 'DatabaseDriverMysqli'
			   , 'Demon'
			   , 'Deusu'
			   , 'Devil'
			   , 'Digincore'
			   , 'DigitalPebble'
			   , 'Dirbuster'
			   , 'Disco'
			   , 'Discobot'
			   , 'Discoverybot'
			   , 'Dispatch'
			   , 'DittoSpyder'
			   , 'DnBCrawler-Analytics'
			   , 'DnyzBot'
			   , 'DomCopBot'
			   , 'DomainAppender'
			   , 'DomainSigmaCrawler'
			   , 'Dotbot'
			   , 'Download Wonder'
			   , 'Dragonfly'
			   , 'Drip'
			   , 'ECCP/1.0'
			   , 'EMail Siphon'
			   , 'EMail Wolf'
			   , 'EasyDL'
			   , 'Ebingbong'
			   , 'Ecxi'
			   , 'EirGrabber'
			   , 'EroCrawler'
			   , 'Evil'
			   , 'Express WebPictures'
			   , 'ExtLinksBot'
			   , 'Extractor'
			   , 'ExtractorPro'
			   , 'Extreme Picture Finder'
			   , 'EyeNetIE'
			   , 'FDM'
			   , 'FHscan'
			   , 'Fimap'
			   , 'Firefox/7.0'
			   , 'FlashGet'
			   , 'Flunky'
			   , 'Foobot'
			   , 'Freeuploader'
			   , 'FrontPage'
			   , 'Fuzz'
			   , 'FyberSpider'
			   , 'Fyrebot'
			   , 'G-i-g-a-b-o-t'
			   , 'GT::WWW'
			   , 'GalaxyBot'
			   , 'Genieo'
			   , 'GermCrawler'
			   , 'GetRight'
			   , 'GetWeb'
			   , 'Getintent'
			   , 'Gigabot'
			   , 'Go!Zilla'
			   , 'Go-Ahead-Got-It'
			   , 'GoZilla'
			   , 'Gotit'
			   , 'GrabNet'
			   , 'Grabber'
			   , 'Grafula'
			   , 'GrapeFX'
			   , 'GridBot'
			   , 'HEADMasterSEO'
			   , 'HMView'
			   , 'HTMLparser'
			   , 'HTTP::Lite'
			   , 'HTTrack'
			   , 'Haansoft'
			   , 'HaosouSpider'
			   , 'Harvest'
			   , 'Havij'
			   , 'Hloader'
			   , 'HonoluluBot'
			   , 'Humanlinks'
			   , 'HybridBot'
			   , 'IDBTE4M'
			   , 'IDBot'
			   , 'IRLbot'
			   , 'Iblog'
			   , 'Id-search'
			   , 'IlseBot'
			   , 'Image Fetch'
			   , 'Image Sucker'
			   , 'IndeedBot'
			   , 'Indy Library'
			   , 'InfoNaviRobot'
			   , 'InfoTekies'
			   , 'Intelliseek'
			   , 'InterGET'
			   , 'InternetSeer'
			   , 'Internet Ninja'
			   , 'Iria'
			   , 'Iskanie'
			   , 'IstellaBot'
			   , 'JOC Web Spider'
			   , 'JamesBOT'
			   , 'Jbrofuzz'
			   , 'JennyBot'
			   , 'JetCar'
			   , 'Jetty'
			   , 'JikeSpider'
			   , 'Joomla'
			   , 'Jorgee'
			   , 'JustView'
			   , 'Jyxobot'
			   , 'Kenjin Spider'
			   , 'Keybot Translation-Search-Machine'
			   , 'Keyword Density'
			   , 'Kinza'
			   , 'Kozmosbot'
			   , 'LNSpiderguy'
			   , 'LWP::Simple'
			   , 'Lanshanbot'
			   , 'Larbin'
			   , 'Leap'
			   , 'LeechFTP'
			   , 'LeechGet'
			   , 'LexiBot'
			   , 'Lftp'
			   , 'LibWeb'
			   , 'Libwhisker'
			   , 'LieBaoFast'
			   , 'Lightspeedsystems'
			   , 'Likse'
			   , 'LinkScan'
			   , 'LinkWalker'
			   , 'Linkbot'
			   , 'LinkextractorPro'
			   , 'LinksManager'
			   , 'LinqiaMetadataDownloaderBot'
			   , 'LinqiaRSSBot'
			   , 'LinqiaScrapeBot'
			   , 'Lipperhey'
			   , 'Lipperhey Spider'
			   , 'Litemage_walker'
			   , 'Lmspider'
			   , 'MFC_Tear_Sample'
			   , 'MIDown tool'
			   , 'MIIxpc'
			   , 'MQQBrowser'
			   , 'MSFrontPage'
			   , 'MSIECrawler'
			   , 'MTRobot'
			   , 'Mag-Net'
			   , 'Magnet'
			   , 'Majestic-SEO'
			   , 'Majestic12'
			   , 'Majestic SEO'
			   , 'MarkMonitor'
			   , 'MarkWatch'
			   , 'Mass Downloader'
			   , 'Masscan'
			   , 'Mata Hari'
			   , 'Mb2345Browser'
			   , 'MeanPath Bot'
			   , 'Meanpathbot'
			   , 'Metauri'
			   , 'MicroMessenger'
			   , 'Microsoft Data Access'
			   , 'Microsoft URL Control'
			   , 'Minefield'
			   , 'Mister PiX'
			   , 'Moblie Safari'
			   , 'Mojeek'
			   , 'Mojolicious'
			   , 'MolokaiBot'
			   , 'Morfeus Fucking Scanner'
			   , 'Mozlila'
			   , 'Mr.4x3'
			   , 'Msrabot'
			   , 'Musobot'
			   , 'NICErsPRO'
			   , 'NPbot'
			   , 'Name Intelligence'
			   , 'Nameprotect'
			   , 'Navroad'
			   , 'NearSite'
			   , 'Needle'
			   , 'Nessus'
			   , 'NetAnts'
			   , 'NetLyzer'
			   , 'NetMechanic'
			   , 'NetSpider'
			   , 'NetZIP'
			   , 'Net Vampire'
			   , 'Netcraft'
			   , 'Nettrack'
			   , 'Netvibes'
			   , 'NextGenSearchBot'
			   , 'Nibbler'
			   , 'Niki-bot'
			   , 'Nikto'
			   , 'NimbleCrawler'
			   , 'Nimbostratus'
			   , 'Ninja'
			   , 'Nmap'
			   , 'Not'
			   , 'Nuclei'
			   , 'Octopus'
			   , 'Offline Explorer'
			   , 'Offline Navigator'
			   , 'OnCrawl'
			   , 'OpenLinkProfiler'
			   , 'OpenVAS'
			   , 'Openfind'
			   , 'Openvas'
			   , 'OrangeBot'
			   , 'OrangeSpider'
			   , 'OutclicksBot'
			   , 'OutfoxBot'
			   , 'PECL::HTTP'
			   , 'PHPCrawl'
			   , 'POE-Component-Client-HTTP'
			   , 'PageAnalyzer'
			   , 'PageGrabber'
			   , 'PageScorer'
			   , 'PageThing.com'
			   , 'Page Analyzer'
			   , 'Pandalytics'
			   , 'Panscient'
			   , 'Papa Foto'
			   , 'Pavuk'
			   , 'PeoplePal'
			   , 'Petalbot'
			   , 'Pi-Monster'
			   , 'Picscout'
			   , 'Picsearch'
			   , 'PictureFinder'
			   , 'Piepmatz'
			   , 'Pimonster'
			   , 'Pixray'
			   , 'PleaseCrawl'
			   , 'Pockey'
			   , 'ProPowerBot'
			   , 'ProWebWalker'
			   , 'Probethenet'
			   , 'Psbot'
			   , 'Pu_iN'
			   , 'Pump'
			   , 'PxBroker'
			   , 'PyCurl'
			   , 'QueryN Metasearch'
			   , 'Quick-Crawler'
			   , 'RSSingBot'
			   , 'RankActive'
			   , 'RankActiveLinkBot'
			   , 'RankFlex'
			   , 'RankingBot'
			   , 'RankingBot2'
			   , 'Rankivabot'
			   , 'RankurBot'
			   , 'Re-re'
			   , 'ReGet'
			   , 'RealDownload'
			   , 'Reaper'
			   , 'RebelMouse'
			   , 'Recorder'
			   , 'RedesScrapy'
			   , 'RepoMonkey'
			   , 'Ripper'
			   , 'RocketCrawler'
			   , 'Rogerbot'
			   , 'SBIder'
			   , 'SEOlyticsCrawler'
			   , 'SEOprofiler'
			   , 'SEOstats'
			   , 'SISTRIX'
			   , 'SMTBot'
			   , 'SalesIntelligent'
			   , 'ScanAlert'
			   , 'Scanbot'
			   , 'ScoutJet'
			   , 'Screaming'
			   , 'ScreenerBot'
			   , 'ScrepyBot'
			   , 'Searchestate'
			   , 'Seekport'
			   , 'SemanticJuice'
			   , 'Semrush'
			   , 'SentiBot'
			   , 'SeoSiteCheckup'
			   , 'SeobilityBot'
			   , 'Seomoz'
			   , 'Shodan'
			   , 'Siphon'
			   , 'SiteCheckerBotCrawler'
			   , 'SiteExplorer'
			   , 'SiteLockSpider'
			   , 'SiteSnagger'
			   , 'SiteSucker'
			   , 'Site Sucker'
			   , 'Sitebeam'
			   , 'Siteimprove'
			   , 'Sitevigil'
			   , 'SlySearch'
			   , 'SmartDownload'
			   , 'Snake'
			   , 'Snapbot'
			   , 'Snoopy'
			   , 'SocialRankIOBot'
			   , 'Sociscraper'
			   , 'Sosospider'
			   , 'Sottopop'
			   , 'SpaceBison'
			   , 'Spammen'
			   , 'SpankBot'
			   , 'Spanner'
			   , 'Spbot'
			   , 'SputnikBot'
			   , 'Sqlmap'
			   , 'Sqlworm'
			   , 'Sqworm'
			   , 'Steeler'
			   , 'Stripper'
			   , 'Sucker'
			   , 'Sucuri'
			   , 'SuperBot'
			   , 'SuperHTTP'
			   , 'Surfbot'
			   , 'SurveyBot'
			   , 'Suzuran'
			   , 'Swiftbot'
			   , 'Szukacz'
			   , 'T0PHackTeam'
			   , 'T8Abot'
			   , 'Teleport'
			   , 'TeleportPro'
			   , 'Telesoft'
			   , 'Telesphoreo'
			   , 'Telesphorep'
			   , 'TheNomad'
			   , 'The Intraformant'
			   , 'Thumbor'
			   , 'TightTwatBot'
			   , 'Titan'
			   , 'Toata'
			   , 'Toweyabot'
			   , 'Tracemyfile'
			   , 'Trendiction'
			   , 'Trendictionbot'
			   , 'True_Robot'
			   , 'Turingos'
			   , 'Turnitin'
			   , 'TurnitinBot'
			   , 'TwengaBot'
			   , 'Twice'
			   , 'Typhoeus'
			   , 'URLy.Warning'
			   , 'URLy Warning'
			   , 'UnisterBot'
			   , 'Upflow'
			   , 'V-BOT'
			   , 'VB Project'
			   , 'VCI'
			   , 'Vacuum'
			   , 'Vagabondo'
			   , 'VelenPublicWebCrawler'
			   , 'VeriCiteCrawler'
			   , 'VidibleScraper'
			   , 'Virusdie'
			   , 'VoidEYE'
			   , 'Voil'
			   , 'Voltron'
			   , 'WASALive-Bot'
			   , 'WBSearchBot'
			   , 'WEBDAV'
			   , 'WISENutbot'
			   , 'WPScan'
			   , 'WWW-Collector-E'
			   , 'WWW-Mechanize'
			   , 'WWW::Mechanize'
			   , 'WWWOFFLE'
			   , 'Wallpapers'
			   , 'Wallpapers/3.0'
			   , 'WallpapersHD'
			   , 'WeSEE'
			   , 'WebAuto'
			   , 'WebBandit'
			   , 'WebCollage'
			   , 'WebCopier'
			   , 'WebEnhancer'
			   , 'WebFetch'
			   , 'WebFuck'
			   , 'WebGo IS'
			   , 'WebImageCollector'
			   , 'WebLeacher'
			   , 'WebPix'
			   , 'WebReaper'
			   , 'WebSauger'
			   , 'WebStripper'
			   , 'WebSucker'
			   , 'WebWhacker'
			   , 'WebZIP'
			   , 'Web Auto'
			   , 'Web Collage'
			   , 'Web Enhancer'
			   , 'Web Fetch'
			   , 'Web Fuck'
			   , 'Web Pix'
			   , 'Web Sauger'
			   , 'Web Sucker'
			   , 'Webalta'
			   , 'WebmasterWorldForumBot'
			   , 'Webshag'
			   , 'WebsiteExtractor'
			   , 'WebsiteQuester'
			   , 'Website Quester'
			   , 'Webster'
			   , 'Whack'
			   , 'Whacker'
			   , 'Whatweb'
			   , 'Who.is Bot'
			   , 'Widow'
			   , 'WinHTTrack'
			   , 'WiseGuys Robot'
			   , 'Wonderbot'
			   , 'Woobot'
			   , 'Wotbox'
			   , 'Wprecon'
			   , 'Xaldon WebSpider'
			   , 'Xaldon_WebSpider'
			   , 'Xenu'
			   , 'YoudaoBot'
			   , 'Zade'
			   , 'Zauba'
			   , 'Zermelo'
			   , 'Zeus'
			   , 'Zitebot'
			   , 'ZmEu'
			   , 'ZoomBot'
			   , 'ZumBot'
			   , 'ZyBorg'
			   , 'arquivo-web-crawler'
			   , 'arquivo.pt'
			   , 'autoemailspider'
			   , 'backlink-check'
			   , 'cah.io.community'
			   , 'check1.exe'
			   , 'clark-crawler'
			   , 'coccocbot'
			   , 'cognitiveseo'
			   , 'com.plumanalytics'
			   , 'crawl.sogou.com'
			   , 'crawler.feedback'
			   , 'crawler4j'
			   , 'dataforseo.com'
			   , 'demandbase-bot'
			   , 'domainsproject.org'
			   , 'eCatch'
			   , 'evc-batch'
			   , 'facebookscraper'
			   , 'gopher'
			   , 'instabid'
			   , 'internetVista monitor'
			   , 'ips-agent'
			   , 'isitwp.com'
			   , 'iubenda-radar'
			   , 'lwp-request'
			   , 'lwp-trivial'
			   , 'meanpathbot'
			   , 'mediawords'
			   , 'muhstik-scan'
			   , 'oBot'
			   , 'page scorer'
			   , 'pcBrowser'
			   , 'plumanalytics'
			   , 'polaris version'
			   , 'probe-image-size'
			   , 'ripz'
			   , 's1z.ru'
			   , 'satoristudio.net'
			   , 'scan.lol'
			   , 'seobility'
			   , 'seocompany.store'
			   , 'seoscanners'
			   , 'seostar'
			   , 'sexsearcher'
			   , 'sitechecker.pro'
			   , 'siteripz'
			   , 'sogouspider'
			   , 'sp_auditbot'
			   , 'spyfu'
			   , 'sysscan'
			   , 'tAkeOut'
			   , 'trendiction.com'
			   , 'trendiction.de'
			   , 'ubermetrics-technologies.com'
			   , 'voyagerx.com'
			   , 'webgains-bot'
			   , 'webmeup-crawler'
			   , 'webpros.com'
			   , 'webprosbot'
			   , 'x09Mozilla'
			   , 'x22Mozilla'
			   , 'xpymep1.exe'
			   , 'zauba.io'
			   , 'zgrab'
			   , 'petalsearch'        
			   , 'protopage'
			   , 'Miniflux'
			   , 'Feeder'
			   , 'Semanticbot' 
			   , 'ImageFetcher'
			   , 'Mastodon' 
			   , 'Neevabot'
			   , 'Pleroma'
			   , 'Akkoma'
			   , 'koyu.space'
			   , 'Embedly'
			   , 'Mjukisbyxor'        
			   , 'Giant Rhubarb'
			   , 'GozleBot'
			   , 'Friendica'
			   , 'WhatsApp'
			   , 'XenForo'        
			   , 'Yeti'
			   , 'MuckRack'
			   , 'PhxBot'
			   , 'Bytespider'
			   , 'GPTBot'
			   , 'SummalyBot'
			   , 'LinkedInBot'
			   , 'SpiderWeb'
			   , 'SpaceCowboys'
			   , 'LCC'
			   , 'Paqlebot'
			   );
	   
		   foreach($bots as $b)
			   {
				   if( stripos( $sistema, $b ) !== false ) return true;
			   }
		   return false;
	   }
	
	   public static function resize_img($image_path,$image_dest,$max_size = 300,$qualite = 100,$type = 'auto',$upload = false){

		// Vérification que le fichier existe
		if(!file_exists($image_path)):
		  return 'wrong_path';
		endif;
		if($image_dest == ""):
		  $image_dest = $image_path;
		endif;
		// Extensions et mimes autorisés
		$extensions = array('jpg','jpeg','png','gif');
		$mimes = array('image/jpeg','image/gif','image/png');
		// Récupération de l'extension de l'image
		$tab_ext = explode('.', $image_path);
		$extension  = strtolower($tab_ext[count($tab_ext)-1]);
		// Récupération des informations de l'image
		$image_data = getimagesize($image_path);
		// Si c'est une image envoyé alors son extension est .tmp et on doit d'abord la copier avant de la redimentionner
		if($upload && in_array($image_data['mime'],$mimes)):
		  copy($image_path,$image_dest);
		  $image_path = $image_dest;
	  
		  $tab_ext = explode('.', $image_path);
		  $extension  = strtolower($tab_ext[count($tab_ext)-1]);
		endif;
		// Test si l'extension est autorisée
		if (in_array($extension,$extensions) && in_array($image_data['mime'],$mimes)):
		  // On stocke les dimensions dans des variables
		  $img_width = $image_data[0];
		  $img_height = $image_data[1];
		  // On vérifie quel coté est le plus grand
		  if($img_width >= $img_height && $type != "height"):
			// Calcul des nouvelles dimensions à partir de la largeur
			if($max_size >= $img_width):
			  return 'no_need_to_resize';
			endif;
			$new_width = $max_size;
			$reduction = ( ($new_width * 100) / $img_width );
			$new_height = round(( ($img_height * $reduction )/100 ),0);
		  else:
			// Calcul des nouvelles dimensions à partir de la hauteur
			if($max_size >= $img_height):
			  return 'no_need_to_resize';
			endif;
			$new_height = $max_size;
			$reduction = ( ($new_height * 100) / $img_height );
			$new_width = round(( ($img_width * $reduction )/100 ),0);
		  endif;
		  // Création de la ressource pour la nouvelle image
		  $dest = imagecreatetruecolor($new_width, $new_height);
		  // En fonction de l'extension on prépare l'iamge
		  switch($extension){
			case 'jpg':
			case 'jpeg':
			  $src = imagecreatefromjpeg($image_path); // Pour les jpg et jpeg
			break;
	  
			case 'png':
			  $src = imagecreatefrompng($image_path); // Pour les png
			break;
	  
			case 'gif':
			  $src = imagecreatefromgif($image_path); // Pour les gif
			break;
		  }
		  // Création de l'image redimentionnée
		  if(imagecopyresampled($dest, $src, 0, 0, 0, 0, $new_width, $new_height, $img_width, $img_height)):
			// On remplace l'image en fonction de l'extension
			switch($extension){
			  case 'jpg':
			  case 'jpeg':
				imagejpeg($dest , $image_dest, $qualite); // Pour les jpg et jpeg
			  break;
			  case 'png':
				$black = imagecolorallocate($dest, 0, 0, 0);
				imagecolortransparent($dest, $black);
	  
				$compression = round((100 - $qualite) / 10,0);
				imagepng($dest , $image_dest, $compression); // Pour les png
			  break;
	  
			  case 'gif':
				imagegif($dest , $image_dest); // Pour les gif
			  break;
			}
			return 'success';
		  else:
			return 'resize_error';
		  endif;
		else:
		  return 'no_img';
		endif;
	  }
}