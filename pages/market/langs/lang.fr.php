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
	'SHOP'            	     => 'Boutique',
	'REMAINING'       	     => 'Restant',
	'UNLIMITED'       	     => 'Illimité',
	'PRICE'           	     => 'Prix',
	'ADD_DATE'        	     => 'Date de l\'ajout',
	'ADDED_TO_CART'   	     => 'Ajouté au panier',
	'YOUR_INFORMATON' 	     => 'Vos informations',
	'YOUR_NAME'       	     => 'Votre Nom',
	'FIRST_NAME'      	     => 'Votre prénom',
	'PHONE'           	     => 'Numéro de téléphone',
	'YOUR_ADRESS'     	     => 'Rue',
	'NUMBER'          	     => 'Numéro',
	'POSTAL_CODE'     	     => 'Code postal',
	'CITY'            	     => 'Ville',
	'COUNTRY'         	     => 'Pays',
	'UPDATE_ADDRESS'  	     => 'Mise à jour de l\'adresse',
	'ADRESS_CODE'     	     => '* Votre profil d\'adresse est crypté en base de données',
	'CART_TOTALS'     	     => 'Totaux du panier',
	'NUMBER_OF_PURCHASES'    => 'Nombre d\'achats',
	'CART_SUBTOTAL'          => 'Sous-total du panier',
	'SHIPPING_TOTAL'         => 'Frais de livraison',
	'TOTAL'                  => 'Total',
	'PROCEED_TO_CHECKOUT'    => 'Passer à la caisse',
	'VIEW_BUY'               => 'Nombre de fois visité',
	'NB_BUY'                 => 'Nombre de vente',
	'NB_BUY_OBJECT'          => 'A été vendu',
	'FINISH_BUY'             => 'Toutes les ventes ont été effectuées',
	'SHOPPING_CART'          => 'Panier',
	'TAXE_TOTAL'             => 'Taxe',
	'DISCOUNT_COUPON'        => 'Coupon de réduction',
	'ORDER'                  => 'Commande',
	'PRODUCT'                => 'Produit',
	'QUANTITY'               => 'Quantité',
	'UPDATE_CART'            => 'Update panier',
	'ADRESS_REQUIRE'         => 'Un achat demande une adresse pour la TVA<br>Redirection dans 5s',
	'ADD_ADRESS_OK'          => 'Adresse crypter et enregistrer en base de données',
	'ADD_ADRESS_NOK'         => 'Adresse n\'a pas pu être sauvegardé en base de données',
	'REQUIRE_BUY'            => 'Achat requis, redirection vers la boutique dans 3s',
	'SOLD_OK'                => 'Votre coupon a bien été validé',
	'SOLD_NOK'               => 'Votre coupon n\'est pas valable',
	'SOLD_NOK_FINISH'        => 'Ce coupon n\'est plus valable date dépassée',
	'SOLD_NOK_FINISH_NUMBER' => 'Ce coupon n\'est plus disponible',
	'SOLD_OK_STOP'           => 'Un coupon a déjà été utilisé',
	'COUPON'                 => 'Réduction',
	'APPLY'                  => 'Appliquer',
	'ERROR_UNKNOW'           => 'Erreur de données',
	'UPDATE_BUY'             => 'mise à jour du panier avec succès',
	'COUNTRY_REQUIRE'        => 'Le Pays est obligatoire pour le calcul du pannier',
	'NO_VALIDATION'          => 'Aucune validation !<br>redirection vers la boutique dans 3s',
	'THANK_YOU_FOR_PAYMENT'  => 'Merci pour votre paiement',
	'PAYMENT_IN_PROGRESS'    => 'Paiement en cours…',
	'EMPTY_SHOPPING_CAT'     => 'Panier vide <br> redirection vers la boutique dans 5s',
	'MY_ORDERS'              => 'Mes commandes',
	'VIEW_YOUR_HISTORY'      => 'Consultez votre historique et suivez les commandes en cours. Accédez à vos bons de commande.',
	'ORDER_NUMBER'           => 'Numéro de commande',
	'ETAT'                   => 'État',
	'ETAT_0'                 => 'Contacter L\'administrateur',
	'ETAT_1'                 => 'Paiement effectué',
	'ETAT_2'                 => 'En préparation',
	'ETAT_3'                 => 'En livraison',
	'ETAT_4'                 => 'Finalisée',
	'DESCRIPTION'            => 'Description',
	'AMOUNT'                 => 'Montant',
	'INVOICE_FROM'           => 'Facture De :',
	'PAY_TO'                 => 'Payer à :',

));