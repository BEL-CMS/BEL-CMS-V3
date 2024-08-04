<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.8 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Requires\Common as Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

Common::constant(array(
	#####################################
	# Fichier lang en français - Pricing
	#####################################
	'PRICE'        => 'Prix',
	'DESC'         => 'Déscription',
	'LISTING'      => 'Liste',
	'ACTIFS'       => 'Activer',
	'VIEW_LIST'    => 'Voir la liste',
	'CAT_1'        => 'Liste une',
	'CAT_2'        => 'Liste deux',
	'CAT_3'        => 'Liste trois',
	'CAT_4'        => 'Liste quatre',
	'CAT_5'        => 'Liste cinq',
	'MONTH'        => 'Mois',
	'DAY'          => 'Jours',
	'YEAR'         => 'Ans',
	'PER'          => 'Par',
	'CREATED_DATE' => 'Date de création',
	'ACTION'       => 'Actions',
)); 