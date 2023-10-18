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
################################################
# base des dossiers et les mets comme constante
################################################
$dir = array(
	'DIR_ASSETS'   => ROOT.DS.'assets'.DS,
	'DIR_CONFIG'   => ROOT.DS.'config'.DS,
	'DIR_CORE'     => ROOT.DS.'core'.DS,
	'DIR_ERROR'    => ROOT.DS.'error'.DS, 
	'DIR_LANGS'    => ROOT.DS.'langs'.DS,
	'DIR_ADMIN'    => ROOT.DS.'managements'.DS,
	'DIR_PAGES'    => ROOT.DS.'pages'.DS,
	'DIR_REQUIRES' => ROOT.DS.'requires'.DS,
	'DIR_SPDO'     => ROOT.DS.'spdo'.DS,
	'DIR_TPL'      => ROOT.DS.'templates'.DS,
	'DIR_UPLOADS'  => ROOT.DS.'uploads'.DS,
	'DIRE_USER'    => ROOT.DS.'users'.DS,
	'DIR_WIDGETS'  => ROOT.DS.'widgets'.DS,
);
foreach ($dir as $name => $value) {
	if (!defined(strtoupper($name))) {
		define($name, $value);
	}
}