<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.1.0  [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
*/

namespace BelCMS\Core;

use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

################################################
# Class Encrypt - Decrypt
################################################
class encrypt
{
	public  $string,
			$key,
			$method;

	function __construct($string, $key) {
		$this->string  = $string;
		$this->key     = $key;
		$this->method  = 'AES-256-CBC'; 
	}

	function encrypt() {
		$key = $this->key;
		$plaintext = $this->string;
		$ivlen = openssl_cipher_iv_length($cipher = $this->method);
		$iv = openssl_random_pseudo_bytes($ivlen);
		$ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
		$hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
		$ciphertext = base64_encode($iv . $hmac . $ciphertext_raw);
		return $ciphertext;
	}
			
	function decrypt() {
		$key = $this->key;
		$c = base64_decode($this->string);
		$ivlen = openssl_cipher_iv_length($cipher = $this->method);
		$iv = substr($c, 0, $ivlen);
		$hmac = substr($c, $ivlen, $sha2len = 32);
		$ciphertext_raw = substr($c, $ivlen + $sha2len);
		$original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, OPENSSL_RAW_DATA, $iv);
		$calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
		if (hash_equals($hmac, $calcmac)) {
			return $original_plaintext;
		}
	} 
}