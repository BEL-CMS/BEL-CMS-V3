<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.4 [PHP8.3]
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
        $this->string  = Common::VarSecure($string, null);
        $this->key     = Common::VarSecure($key, null);
        $this->method  = 'AES-256-CBC'; 
    }

    function encrypt () {
        $secret_key = $this->key;
        $cipher     = $this->method;

        $ivlen = openssl_cipher_iv_length( $cipher );
        $iv    = openssl_random_pseudo_bytes( $ivlen );
        $ciphertext_raw = openssl_encrypt( $this->string, $cipher, $secret_key, $options = OPENSSL_RAW_DATA, $iv );
        $hmac  = hash_hmac( 'sha512', $ciphertext_raw, $secret_key, $as_binary = true );
        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );

        return $ciphertext;
    }

    public function decrypt ()
    {
        $secret_key = $this->key;
        $cipher     = $this->method;
        $ivlen      = openssl_cipher_iv_length( $cipher );
    
        $c = base64_decode( $this->string );
        $iv = substr( $c, 0, $ivlen );
        $hmac = substr( $c, $ivlen, $sha2len = 64 );
        $ciphertext_raw = substr( $c, $ivlen+$sha2len );
        $original_plaintext = openssl_decrypt( $ciphertext_raw, $cipher, $secret_key, $options = OPENSSL_RAW_DATA, $iv );
        $calcmac = hash_hmac( 'sha512', $ciphertext_raw, $secret_key, $as_binary = true );

        if ( hash_equals( $hmac, $calcmac ) )
            return $original_plaintext;
        else
            false;    
    }

   
}