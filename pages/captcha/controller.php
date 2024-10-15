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

namespace Belcms\Pages\Controller;
use Belcms\Pages\Pages;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Captcha extends Pages
{
	var $useModels  = 'Captcha';

	public function index ()
	{
		$largeur = 100;
		//hauteur de l'image
		$hauteur = 30;
		//nombre de lignes multicolore qui seront affichées avec le code (10 est bien)
		$lignes = 8;
		//type de caractère du code qui sera affiché dans l'image
		$caracteres = "abcdefghijklmnopqrstuvwxyzABCDEF123456789+-=&@";
		//longeur du mot de passe
		$longeur = 5;
		//on crée l'image rectangle
		$image = imagecreatetruecolor($largeur, $hauteur);
		//on met un fond en blanc (255,255,255)
		imagefilledrectangle($image, 0, 0, $largeur, $hauteur, imagecolorallocate($image, 242, 242, 242));
		//on ajoute les lignes
		//fonction qui permet de retourner la valeur en RGB d'une couleur hexadécimale
		function hexargb($hex){
		 //on retourne la valeur sous forme d'array R, G et B
		  return [
			'r' => hexdec(substr($hex,0,2)),
			'g' => hexdec(substr($hex,2,2)),
			'b' => hexdec(substr($hex,4,2))
		  ];
		}
		//ajoute les lignes de différentes couleurs au fond blanc pour mettre de la difficulté
		for($i = 0; $i <= $lignes; $i++){
		  
		  //choisi une couleur aléatoirement (str_shuffle), de 6 caractères (substr(chaine,0,6)) avec la sélection alphanumérique
		 $rgb = hexargb(substr(str_shuffle("ABCDEF0123456789"),0,6));
		  
		 imageline(
			$image,
			rand(1, $largeur - 25),
			rand(1, $hauteur),
			rand(1, $largeur + 25),
			rand(1, $hauteur),
			imagecolorallocate($image, $rgb['r'], $rgb['g'], $rgb['b'])
		  );
		  
		}
		$code_session = substr(str_shuffle($caracteres), 0, $longeur);
		$this->models->insertBDDCaptcha($code_session);
		$code = '';
		for($i = 0; $i <= strlen($code_session); $i ++){
			$code .= substr($code_session, $i, 1) . ' ';
		}
		//on écrit le code dans le rectangle
		imagestring($image, 80, 15, 15, $code, imagecolorallocate($image, 0, 0, 0));
		//on affiche l'image
		imagepng($image);
		//puis on détruit l'image pour libérer de l'espace
		imagedestroy($image);
	}
}