<?php
final class Secure
{
	public static function isMail ($data = false)
	{
		return filter_var($data, FILTER_VALIDATE_EMAIL) ? $data : false;
	}

	public static function isBool ($data = false)
	{
		return filter_var($data, FILTER_VALIDATE_BOOLEAN) ? $data : false;
	}

	public static function isInt ($data = false)
	{
		return filter_var($data, FILTER_VALIDATE_INT) ? $data : false;
	}

	public static function isfloat ($data = false)
	{
		return filter_var($data, FILTER_VALIDATE_FLOAT) ? $data : false;
	}

	public static function isIp ($data = false)
	{
		return filter_var($data, FILTER_VALIDATE_IP) ? $data : false;
	}

	public static function isUrl ($data = false)
	{
		return filter_var($data, FILTER_VALIDATE_URL) ? $data : false;
	}

	public static function isString($data = false)
	{
		return is_string($data) ? $data : false;
	}
	public static function validateDate($date, $format = 'Y-m-d H:i:s')
	{
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}
	public static function isDate($data = false)
	{
		return Secure::validateDate($data) ? $data : false;
	}
}
?>