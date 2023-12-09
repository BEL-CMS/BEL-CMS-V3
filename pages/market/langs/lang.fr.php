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

namespace BELCMS\LANG;
use BelCMS\Requires\Common as Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

Common::constant(array(
	#####################################
	# Fichier lang en français - Market
	#####################################
	'SHOP'            	  => 'Boutique',
	'REMAINING'       	  => 'Restant',
	'UNLIMITED'       	  => 'Illimité',
	'PRICE'           	  => 'Prix',
	'ADD_DATE'        	  => 'Date de l\'ajout',
	'ADDED_TO_CART'   	  => 'Ajouté au panier',
	'YOUR_INFORMATON' 	  => 'Vos informations',
	'YOUR_NAME'       	  => 'Votre Nom',
	'FIRST_NAME'      	  => 'Votre prénom',
	'PHONE'           	  => 'Numéro de téléphone',
	'YOUR_ADRESS'     	  => 'Rue',
	'NUMBER'          	  => 'Numéro',
	'POSTAL_CODE'     	  => 'Code postal',
	'CITY'            	  => 'Ville',
	'COUNTRY'         	  => 'Pays',
	'UPDATE_ADDRESS'  	  => 'Mise à jour de l\'adresse',
	'ADRESS_CODE'     	  => '* Votre profil d\'adresse est crypté en base de données',
	'CART_TOTALS'     	  => 'Totaux du panier',
	'NUMBER_OF_PURCHASES' => 'Nombre d\'achats',
	'CART_SUBTOTAL'       => 'Sous-total du panier',
	'SHIPPING_TOTAL'      => 'Frais de livraison',
	'TOTAL'               => 'Total',
	'PROCEED_TO_CHECKOUT' => 'Passer à la caisse',
));