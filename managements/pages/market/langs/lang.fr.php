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

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

use BelCMS\Requires\Common;

Common::constant(array(
	#####################################
	# Fichier lang en français - Pages gallery
	#####################################
	'DATE_OF_RELEASE'    => 'Date de la vente',
	'COST'               => 'Coût',
	'REMAINING'          => 'Réstant',
	'PRICE'              => 'Prix',
	'PAYMENT'            => 'Versement',
	'NO_CAT'             => 'Aucune câtégorie, veuillez en ajouté une.',
	'ADD_CAT'            => 'Ajouter une catégorie',
	'EDIT_CATEGORY'      => 'Éditer la catégorie',
	'ADD_BUY'            => 'Ajout d\'une vente',
	'EDIT_BUY'           => 'Editer une vente',
	'SCREEN'             => 'Image',
	'UNLIMITED'          => 'Illimité',
	'MARKET_ACTIVE'      => 'Activer la boutique',
	'MARKET_PAGE_ACTIVE' => 'Page market ouvert',
	'NB_BUY_PAGE'        => 'Nombre par page',
	'SCREEN_OPT'         => 'Image de forme carre de préférence 100*100 ou plus',
	'ADD_IMG'            => 'Ajouter des images',
	'IMG'                => 'Images',
	'DISCOUNT_COUPON'    => 'Coupon de réduction',
	'ADD_DISCOUNT'       => 'Ajouter une réduction',
	'CODE'               => 'Code',
	'DATE_OF_FINISH'     => 'Date de fin',
	'NUMBER'             => 'Nombre',
	'INFINITE'           => 'Infini',
	'CONFIRM_DEL_CODE'   => 'Confirmer la suppression du code',
	'PRE_ADD_DISCOUNT'   => 'Code prédéfini',
	'NO_TAXE'            => 'Pas de taxe',
	'NO_DELIVRY'         => 'Livraison gratuit',
	'ONE_LIVRAISON'      => 'Payé une seule fois la livraison',
	'ADD_COUPON'         => 'Enregistrer le coupon de réduction',
	'EDIT_COUPON'        => 'Édition du coupon de réduction',
	'CODE_ERROR'         => 'Aucun code ou auto-code utilisé',
	'SEND_SOLD_SUCCESS'  => 'Enregistrement du coupon avec succès',
	'SEND_SOLD_ERROR'    => 'Erreur lors de l\'enregistrement du coupon',
	'DESCRIPTION'        => 'Description',
	'STATUS'             => 'Status',
	'ETAT_0'             => 'Contacter L\'administrateur',
	'ETAT_1'             => 'Paiement effectué',
	'ETAT_2'             => 'En préparation',
	'ETAT_3'             => 'En livraison',
	'ETAT_4'             => 'Finalisée',
	'ID_PAYPAL'          => 'ID PayPal',
 )); 