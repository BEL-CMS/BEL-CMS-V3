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

namespace Belcms\Pages\Models;

use BelCMS\Core\Secure as Secure;
use BelCMS\Core\Secures as Secures;
use BelCMS\PDO\BDD as BDD;
use BelCMS\User\User as Users;
use BelCMS\Requires\Common as Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class User
{
	#####################################
	# Variable declaration
	#####################################
	private $sql;
	#####################################
	# Insert registration
	#####################################
	public function sendRegistration (array $data)
	{
		if ($data) {
			$error = 0;
			// Ajout du blacklistage des mail jetables
			$sql = New BDD();
			$sql->table('TABLE_MAIL_BLACKLIST');
			$sql->isObject(false);
			$sql->queryAll();
			$results = $sql->data;

			$arrayBlackList = array();

			foreach ($results as $k => $v) {
				$arrayBlackList[$v['id']] = $v['name'];
			}

			if (!empty($data['email'])) {
				$tmpMailSplit = explode('@', $data['email']);
				$tmpNdd =  explode('.', $tmpMailSplit[1]);
			}

			if (!isset($_REQUEST['query_register']) or !isset($_SESSION['TMP_QUERY_REGISTER']['OVERALL'])) {
				$return['msg']  = constant('SECURE_CODE_FAIL'); $error++;
				$return['type'] = 'warning';
				return $return;
			}
			if (empty($data['username']) OR empty($data['email']) OR empty($data['passwordhash'])) {
				$return['msg']   = constant('UNKNOW_USER_MAIL_PASS'); $error++;
				$return['type']  = 'error';
			} else if (in_array($tmpNdd[0], $arrayBlackList)) {
				$return['msg']   = constant('NO_MAIL_ALLOWED'); $error++;
				$return['type']  = 'warning';
			} else if ($_REQUEST['query_register'] != $_SESSION['TMP_QUERY_REGISTER']['OVERALL'])  {
				$return['msg']   = constant('SECURE_CODE_FAIL'); $error++;
				$return['type']  = 'warning';
			} else if (strlen($data['username']) < 3) {
				$return['msg']   = constant('MIN_THREE_CARACTER'); $error++;
				$return['type']  = 'warning';
			} else if (strlen($data['passwordhash']) < 6) {
				$return['msg']   = constant('MIN_SIX_CARACTER'); $error++;
				$return['type']  = 'warning';
			} else if (strlen($data['username']) > 32) {
				$return['msg']   = constant('MAX_CARACTER'); $error++;
				$return['type']  = 'warning';
			} else if ($data['passwordhash'] != $_POST['passwordrepeat']) {
				$return['msg']   = constant('PASS_CONFIRM_NOT_SAME'); $error++;
				$return['type']  = 'info';
			}

			if ($error == 0) {

				$sql = New BDD();
				$sql->table('TABLE_USERS');
				$sql->where(array('name'=>'username','value'=>$data['username']));
				$sql->count();
				$returnCheckName = (int) $sql->data;

				$sql = New BDD();
				$sql->table('TABLE_USERS');
				$sql->where(array('name'=>'mail','value'=>$data['email']));
				$sql->count();
				$checkMail = (int) $sql->data;

				if ($returnCheckName >= 1) {
					$return['msg']  = constant('THIS_NAME_OR_PSEUDO_RESERVED');
					$return['type']  = 'warning';
				} elseif ($checkMail >= 1) {
					$return['msg']  = constant('THIS_MAIL_IS_ALREADY_RESERVED');
					$return['type']  = 'warning';
				} else {
					$hash_key = md5(uniqid(rand(), true));
					$password_hash = password_hash($data['passwordhash'], CRYPT_BLOWFISH);

					$insertUser = array(
						'id'                => null,
						'username'          => $data['username'],
						'hash_key'          => $hash_key,
						'password'          => $password_hash,
						'mail'              => $data['email'],
						'ip'                => Common::getIp(),
						'valid'             => (int) 1,
						'expire'            => (int) 0,
						'token'             => '',
						'expire'            => (int) 0,
						'god'               => (int) 0
					);	
					$insert = New BDD();
					$insert->table('TABLE_USERS');
					$insert->insert($insertUser);

					$insertGroups = array(
						'id'                => null,
						'hash_key'          => $hash_key,
						'user_group'        => 2,
						'user_groups'       => 2
					);
					$insertGrp = New BDD();
					$insertGrp->table('TABLE_USERS_GROUPS');
					$insertGrp->insert($insertGroups);

					$dataProfils = array(
						'hash_key'     => $hash_key,
						'gender'       => 'unisexual',
						'public_mail'  => '',
						'websites'     => '',
						'list_ip'      => '',
						'avatar'       => constant('AVATAR_DEFAULT'),
						'config'       => 0,
						'info_text'    => '',
						'birthday'     => date('Y-m-d'),
						'country'      => '',
						'hight_avatar' => '',
						'friends'      => ''
					);
					$insertProfils = New BDD();
					$insertProfils->table('TABLE_USERS_PROFILS');
					$insertProfils->insert($dataProfils);

					$insertSocial = New BDD();
					$insertSocial->table('TABLE_USERS_SOCIAL');
					$insertSocial->insert(array('hash_key'=> $hash_key));

					$insertPage = New BDD();
					$insertPage->table('TABLE_USERS_PAGE');
					$insertPage->insert(array('hash_key'=> $hash_key));

					unset($_SESSION['TMP_QUERY_REGISTER']);

					Users::login($data['username'],$data['passwordhash']);

					$return['msg']  = constant('CURRENT_RECORD');
					$return['type'] = 'success';
				}
			}
			return $return;
		}
	}
	public function sendEditProfil ($data) {
		$error  = true;
		$insertProfil = array();

		if ($error && !empty($data['birthday']) && strlen($data['birthday']) == 10) {
			$insertProfil['birthday'] = Common::DatetimeSQL($data['birthday'], false, 'Y-m-d');
		} else if ($error && empty($data['birthday'])) {
			$insertProfil['birthday'] = '0000-00-00';
		}
		if ($error && Secure::isUrl($data['websites'])) {
			$return['msg']  = $data['websites'].' n\'est pas valide'; ++$error;
			$return['type'] = 'red';
		} else {
			$insertProfil['websites'] = $data['websites'];
		}
		require ROOT.DS.'pages'.DS.'user'.DS.'country.php';
		if ($error && !empty($data['country'])) {
			if (in_array($data['country'], contryList())) {
				$insertProfil['country'] = $data['country'];
			}
		}

		if ($error && !empty($data['gender'])) {
			if ($data['gender'] == 'male') {
				$insertProfil['gender'] = 'male';
			} else if ($data['gender'] == 'female') {
				$insertProfil['gender'] = 'female';
			} else {
				$insertProfil['gender'] = 'unisexual';
			}
		} else {
			$insertProfil['gender'] = 'unisexual';
		}

		if (!empty($_FILES['hight_avatar'])) {
			$dir = 'uploads'.DS.'users'.$_SESSION['USER']['HASH_KEY']->user->hash_key.DS;
			$extensions = array('.png', '.gif', '.jpg', '.jpeg');
			$extension = strrchr($_FILES['hight_avatar']['name'], '.');
			if (!in_array($extension, $extensions)) {
				$return['msg']  = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg'; ++$error;
				$return['type'] = 'red';
			}
			if (move_uploaded_file($_FILES['hight_avatar']['tmp_name'], $dir.'hight_avatar.png')) {
				$insertProfil['hight_avatar'] = $dir.'hight_avatar.png';
			} else {
				$return['msg']  = 'Echec de l\'upload !'; ++$error;
				$return['type'] = 'blue';
			}
		}
		$insertProfil['info_text'] = Common::VarSecure($data['info_text'], null);
		$insertProfil['info_text'] = empty($insertProfil['info_text']) ? '<p></p>' : $insertProfil['info_text'];

		$sql = New BDD();
		$sql->table('TABLE_USERS_PROFILS');
		$sql->where(array('name'=>'hash_key','value'=> $_SESSION['USER']['HASH_KEY']->user->hash_key));
		$sql->update($insertProfil);
		$countRowUpdate = $sql->rowCount;

		if ($countRowUpdate != 0) {
			$return['msg']  = 'Vos informations ont été sauvegardées avec succès';
			$return['type'] = 'success';
		} else {
			$return['msg']  = 'Vos informations n\'ont pas été sauvegardées ou partiellement';
			$return['type'] = 'warning';
		}

		return $return;
	}
	public function sendEditSocial ($data) {

		$update = New BDD();
		$update->table('TABLE_USERS_SOCIAL');
		$update->where(array(
			'name'  => 'hash_key',
			'value' => $_SESSION['USER']['HASH_KEY']->user->hash_key
		));
		$update->update($data);
		$returnSql = $update->data;
		$resultsCount = $returnSql;

		if ($resultsCount != null) {
			$return['msg']      = 'Vos informations ont été sauvegardées avec succès';
			$return['type']     = 'success';
			$return['rowcount'] = $resultsCount;
		} else {
			$return['msg']  = 'Aucune informations a été sauvegardée';
			$return['type'] = 'danger';
			$return['rowcount'] = $resultsCount;
		}
		return $return;

	}
	public function sendEditPassword ($data) {
		$insertUser   = array();
		$insertProfil = array();
		$error        = true;

		$sql = New BDD();
		$sql->table('TABLE_USERS');
		$sql->where(array('name'=>'hash_key','value'=>$_SESSION['USER']['HASH_KEY']->user->hash_key));
		$sql->queryOne();
		$results = $sql->data;

		$sql = New BDD();
		$sql->table('TABLE_MAIL_BLACKLIST');
		$sql->queryAll();
		$resultsBlackList = $sql->data;

		$arrayBlackList   = array();
		foreach ($resultsBlackList as $k => $v) {
			$arrayBlackList[$v->id] = $v->name;
		}

		if (!empty($data['newpassword'])) {
			if (password_verify($data['password'], $results->password)) {
				$insertUser['password'] = password_hash($data['newpassword'], PASSWORD_DEFAULT);
			} else {
				$return['msg']  = 'Le mot de passe ne correspondent pas avec celui du compte'; ++$error;
				$return['type'] = 'danger';
			}
		}

		if ($error && $data['email'] != $results->mail) {

			if (!empty($data['email'])) {
				$tmpMailSplit = explode('@', $data['email']);
				$tmpNdd =  explode('.', $tmpMailSplit[1]);
			}

			if (Secure::isMail($data['email'])) {
				$return['msg']  = 'le courriel '.$data['private_mail'].' n\'est pas valide';
				$return['type'] = 'danger';
			} else if (in_array($tmpNdd[0], $arrayBlackList)) {
				$return['msg']  = 'Les faux mails ne sont pas autorisés';
				$return['type'] = 'danger';
			} else {
				$insertUser['email'] = $data['email'];
			}
		}

		$sql = New BDD();
		$sql->table('TABLE_USERS_PROFILS');
		$sql->where(array('name'=>'hash_key','value'=>$_SESSION['USER']['HASH_KEY']->user->hash_key));
		$sql->queryOne();
		$resultsProfils = $sql->data;

		if ($error && !empty($data['public_mail'])) {
			if (!empty($data['public_mail'])) {
				$tmpMailSplit = explode('@', $data['public_mail']);
				$tmpNdd =  explode('.', $tmpMailSplit[1]);
			}

			if (!empty($data['public_mail'])) {
				$tmpMailSplit = explode('@', $data['public_mail']);
				$tmpNdd = explode('.', $tmpMailSplit[1]);
			}

			if (!filter_var($data['public_mail'], FILTER_VALIDATE_EMAIL)) {
				$return['msg']  = 'le courriel '.$data['public_mail'].' n\'est pas valide';
				$return['type'] = 'error';
			} else if (in_array($tmpNdd[0], $arrayBlackList)) {
				$return['msg']  = 'Les faux mails ne sont pas autorisés';
				$return['type'] = 'error';
			} else {
				$sql = New BDD();
				$sql->table('TABLE_USERS_PROFILS');
				$sql->where(array('name'=>'hash_key','value'=>$_SESSION['USER']['HASH_KEY']->user->hash_key));
				$sql->update(array('public_mail' => $data['public_mail']));
				$resultsProfils = $sql->data;
			}
		} else if (empty($data['public_mail'])) {
			$sql = New BDD();
			$sql->table('TABLE_USERS_PROFILS');
			$sql->where(array('name'=>'hash_key','value'=>$_SESSION['USER']['HASH_KEY']->user->hash_key));
			$sql->update(array('public_mail' => ''));
		}
		if ($error && count($insertUser) > 0) {
			$sql = New BDD();
			$sql->table('TABLE_USERS');
			$sql->where(array('name'=>'hash_key','value'=>$_SESSION['USER']['HASH_KEY']->user->hash_key));
			$sql->update($insertUser);
			$resultsProfils = $sql->data;
		}

		if ($error) {
			$return['msg']  = 'Vos informations ont été sauvegardées avec succès';
			$return['type'] = 'success';
		}

		return $return;
	}
	public function sendChangeAvatar ($data = false)
	{
		$rowCount = null;
		if ($data) {
			$a = array('?ajax', '?jquery', '?echo');
			$data = str_replace($a, '', $data);
			$dir = 'uploads/users/'.$_SESSION['USER']['HASH_KEY']->user->hash_key.'/';
			$checkdir = strpos($data, $dir);
			if ($checkdir !== false) {
				$sql = New BDD();
				$sql->table('TABLE_USERS_PROFILS');
				$sql->where(array('name'=>'hash_key','value'=>$_SESSION['USER']['HASH_KEY']->user->hash_key));
				$sql->update(array('avatar'=> $data));
			}
		}
		if ($sql->rowCount == 0) {
			$return['msg']  = 'Erreur de changement d\'image';
			$return['type'] = 'warning';
		} else if ($sql->rowCount == 1) {
			$return['msg']  = 'Changement d\'image effectué avec succès';
			$return['type'] = 'success';
		} else {
			$return['msg'] = ERROR;
			$return['type'] = 'error';
		}
		return $return;
	}
	public function sendDeleteAvatar ($data = false)
	{
		if ($data) {
			$dir = 'uploads'.DS.'users'.DS.$_SESSION['USER']['HASH_KEY']->user->hash_key.DS;
			$checkdir = strpos($data, $dir);
			if ($checkdir !== false) {
				unlink($data);
				$return['msg']  = 'Effacés avec succès';
				$return['type'] = 'success';
			} else {
				$return['msg']  = 'Le dossier ne vous appartient pas !';
				$return['type'] = 'error';
			}
		} else {
			$return['msg']  = 'Aucune données';
			$return['type'] = 'warning';
		}
		return $return;
	}
	#####################################
	# Generator password 8 default
	#####################################
	public static function generatePass ($height = 8){
		// initialiser la variable $return
		$return = '';
		// Définir tout les caractères possibles dans le mot de passe,
		$character = "#'/*-&@$%2346789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		// obtenir le nombre de caractères dans la chaîne précédente
		$max = strlen($character);
		if ($height > $max) {
			$height = $max;
		}
		// initialiser le compteur
		$i = 0;
		// ajouter un caractère aléatoire à $return jusqu'à ce que $height soit atteint
		while ($i < $height) {
			// prendre un caractère aléatoire
			$letter = substr($character, mt_rand(0, $max-1), 1);
			// vérifier si le caractère est déjà utilisé dans $mdp
			if (!stristr($return, $character)) {
				// Si non, ajouter le caractère à $return et augmenter le compteur
				$return .= $letter;
				$i++;
			}
		}
		// retourner le résultat final
		return $return;
	}
	#####################################
	# Check token and send mail
	#####################################
	public function checkToken($data = false)
	{
		if ($data) {
			if (strpos($data['value'], '@')) {
				$type = 'email';
			} else {
				$type = 'username';
			}

			$sql = New BDD();
			$sql->table('TABLE_USERS');
			$sql->where(array('name'=>$type,'value'=>$data['value']));
			$sql->isObject(false);
			$sql->queryOne();
			$results = $sql->data;

			if ($results && is_array($results) && sizeof($results)) {
				if (empty($results['token'])) {
					// Création du token
					$hashToken = md5(uniqid(rand(), true));
					$timeToken = time() + 60*60;
					$token = $hashToken.'|'.$timeToken;

					$sql = New BDD();
					$sql->table('TABLE_USERS');
					$sql->where(array('name' => $type,'value'=> $data['value']));
					$sql->update(array('token' => $token));
					// Contenue du courriel
					$contentMail = '';
					$contentMail .= '<p>Token : <strong>' . $hashToken . '</strong></p>';
					$contentMail .= '<p>Valable : 1h00</p>';
					$mail = array(
						'subject'  => 'Demande de nouveau mot de passe',
						'content'  => self::contentMail('Token', $contentMail),
						'sendMail' => $results['email']
					);
					$returnMail = Common::sendMail($mail);
					if ($returnMail) {
						$dataAction = array(
							'name'        => '',
							'ip'          => Common::getIp(),
							'date_insert' => date('Y-m-d H:i:s'),
							'text'        => 'Une demande de regénération de mot de passe à été demander',
							'modules'     => 'User'
						);

						$return['msg']  = 'Un mail avec un token a été génère et envoyé par courriel';
						$return['type'] = 'success';
					} else {
						$return['msg']  = 'Le mail n\'a pas pu être envoyé, veuillez-vous référer à l\'administrateur du site';
						$return['type'] = 'error';
					}
				} else {
					$explode = explode('|', $results['token']);
					if ($explode[1] <= time()) {
						// Reset du token
						$sql = New BDD();
						$sql->table('TABLE_USERS');
						$sql->where(array('name' => $type,'value'=> $data['value']));
						$sql->update(array('token'=>''));
						self::checkToken($data['value']);
						$return['msg']  = 'Ce token n\'est plus valide, un nouveau a été génère';
						$return['type'] = 'blue';
					} else {
						if (empty($data['token'])) {
							$return['msg']  = 'Votre token est valide, veuillez l\'utiliser';
							$return['type'] = 'error';
						} else if ($data['token'] != $explode[0]) {
							$dataAction = array(
								'name'        => '',
								'ip'          => Common::getIp(),
								'date_insert' => date('Y-m-d H:i:s'),
								'text'        => 'Le token de correspondais pas avec celui du compte',
								'modules'     => 'User'
							);
							$return['msg']  = 'Ce token ne correspond pas avec celui du compte';
							$return['type'] = 'error';
						} else {
							$generatePass = self::generatePass(8);
							$password = password_hash($generatePass, PASSWORD_DEFAULT);
							// Update du mot de passe & reset du token
							$sql = New BDD();
							$sql->table('TABLE_USERS');
							$sql->where(array('name' => $type,'value'=> $data['value']));
							$sql->update(array('password'=>$password,'token'=>''));

							$contentMail = '';
							$contentMail .= $generatePass;
							$mail = array(
								'name'     => constant('CMS_WEBSITE_NAME'),
								'mail'     => constant('CMS_MAIL_WEBSITE'),
								'subject'  => 'Demande de nouveau mot de passe',
								'content'  => self::contentMail('Mot de passe', $contentMail),
								'sendMail' => $results['email']
							);

							$returnMail = Common::sendMail($mail);

							$return['msg']  = 'Voici votre nouveau mot de passe : '. $generatePass;
							$return['type'] = 'success';
							$return['pass'] = true;
						}
					}
				}
			} else {
				$return['msg']  = 'Aucun Nom et/ou pseudo connu';
				$return['type'] = 'error';
			}
		} else {
			$return['msg']  = 'Nom et/ou pseudo vide';
			$return['type'] = 'error';
		}
		return $return;
	}
	#####################################
	# Content mail
	#####################################
	public static function contentMail($title, $content)
	{
		$return = '	<!doctype html>
					<html>
						<meta charset="utf-8">
						<style type="text/css" data-hse-inline-css="true">
							body, html {font-family: Helvetica, Arial, sans-serif;background: #dbe5ea;margin: 0;margin: 0;padding: 0;border: none;outline: none;list-style: none; }
							#main {background: #FFF;padding-bottom: 60px; }
							#main > h1 {margin: 0;padding: 0;font-size: 16px;line-height: 50px;background-color: #ffffff;border-radius: 4px 4px 0px 0px;text-align: center; }
							#corp {background: #126de5;text-align: center;color: #FFF;line-height: 65px; }
							#corp > div,
							#corp > div > img {margin: 0; padding: 0;line-height: normal; }
							#token {text-align: center;padding: 20px 0; }
							#token > span {display: inline-block;background: #ebf5fa;margin: auto;line-height: 60px;padding: 0 20px; }
							#link {background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 8px;padding-bottom: 8px;						text-align: center; }
							#link > a {display: inline-block;background: #0ec06e;color: #FFF;padding: 15px 20px;margin: auto;text-decoration: none;}
							#infos {display: block;background: #FFF;text-align: center;}
							#infos > span {display: inline-block;background: #242b3d;color: #FFF;padding: 5px 15px;margin: 15px auto;}
							#copyright {text-align: center;font-size: 11px;margin-bottom: 50px;}
							.clear {clear: both;}
						</style>
						<body>
							<div id="main">
								<h1>'.$title.'</h1>
								<div id="corp">
									<div><img src=" data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGAAAABgCAMAAADVRocKAAAAZlBMVEUAAAD///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////+Vn2moAAAAIXRSTlMA9APwcWsX/GUp947VyU3OWCUSBtp1RAyR27e1iHAZvLsH6T7vAAABSUlEQVRo3u3Y626DMAwF4ISQptyh0NLdd97/Jfdn2obZIIpdqZP8PUBPRRLHjlFKKaWUUhsOffU4uTK46b3qD0bYyTdYaPxJ8s9XFiv2+mpkZLnFr+w5MwKKDn/qBsPWWmxwrWE6BmwKR+bvYxcroQ3YFRhfaXCI4JJXOusQpUndrWdEyhPPr0Ukl1aaKkR7TqpvFtHsnBDwAkL6MDRYqfNiHIu8BsP3EoMqffa5fX0pENCDKC/my6XkB1QgvPnB8wOesFRni0NeswMetk9rzg5wWCrIPccOADEuA8ZbB8z3/4n2Fvn+t+nOQfsHpeJWxW6nXA/jzCzXYhcOCPErE4T4pQ9CvG0BId54geC1jrEBVMFofkGIt+8gxAcQEOIjFAjxIRCE+BgLQnwQByH+lABC/DEEROxzTghueruS55yoAKWUUkoptfIBQWw+kbVEMGQAAAAASUVORK5CYII="></div>
									<p>Récupération de mot de passe</p>
								</div>
								<div id="token">
									<span>'.$content.'</span>
								</div>
								<div id="link"><a href="https://bel-cms.dev?token=21241545465">Lien automatique</a></div>
								<div id="infos"><span>Attention, le Token est valide uniquement pendant 1h00</span></div>
								<div class="clear"></div>
								<div id="copyright"><p>Template mail by <a href="https://bel-cms.dev">Bel-CMS</a></p>
							</div>
						</body>
					</html>';
		return $return;
	}
	#########################################
	# Ajoute une visite
	#########################################
	private function addLastVisit ($hash_key = null)
	{
		if (Common::hash_key($hash_key)) {
			$sql = New BDD();
			$sql->table('TABLE_USERS');
			$sql->where(array('name' => 'hash_key', 'value' => $hash_key));
			$sql->update(array('last_visit' => date('Y-m-d H:i:s'), 'ip' => Common::GetIp()));
		}
	}
	#########################################
	# Enregistre les parametres du compte 
	#########################################
	public function sendAccount ($data)
	{
		if (!empty($data)) {
			if (Common::hash_key($_SESSION['USER']->user->hash_key)) {
				$sql = New BDD();
				$sql->table('TABLE_USERS');
				$sql->where(array('name' => 'hash_key', 'value' => $_SESSION['USER']->user->hash_key));
				$sql->queryOne();
				$dataUser = $sql->data;
				if (empty($sql->data)) {
					$return = array('type' => 'warning', 'msg' => 'Erreur de données utilisateur', 'title' => 'Données');
					return $return;
				} else {
					if ($dataUser->hash_key != $_SESSION['USER']->user->hash_key) {
						$return = array('type' => 'error', 'msg' => 'La hash key ne vous appartient pas', 'title' => 'Hash Key');
						// TODO : faire un systeme de prévention 
						return $return;
					} else {

						if ($data['username'] != $dataUser->username) {
							$sql = New BDD();
							$sql->table('TABLE_USERS');
							$sql->where(array('name' => 'username', 'value' => $data['username']));
							$sql->count();
							if ($sql->data == 1) {
								$return = array('type' => 'error', 'msg' => 'Ce nom d\'utilisateur est déjà utilisé', 'title' => 'Pseudo');
								return $return;	
							} else {
								$dataInsert['username'] = $data['username'];
							}
						}

						if ($data['mail'] != $dataUser->mail) {
							$sql = New BDD();
							$sql->table('TABLE_USERS');
							$sql->where(array('name' => 'mail', 'value' => $data['mail']));
							$sql->count();
							if ($sql->data == 1) {
								$return = array('type' => 'error', 'msg' => 'Cette email priver est déjà utilisé', 'title' => 'Email');
								return $return;	
							} else {
								$dataInsert['mail'] = $data['mail'];
							}
						}

						if (!empty($dataInsert)) {
							$sql = New BDD();
							$sql->table('TABLE_USERS');
							$sql->where(array('name' => 'hash_key', 'value' => $_SESSION['USER']->user->hash_key));
							$sql->update($dataInsert);
						}

						$dataInsertProfils['birthday'] = $data['birthday'];
						$dataInsertProfils['country']  = Secure::isString($data['country']);
						$dataInsertProfils['websites'] = Secure::isUrl($data['websites']);
						$dataInsertProfils['gender']   = Secure::isString($data['gender']);

						$sql = New BDD();
						$sql->table('TABLE_USERS_PROFILS');
						$sql->where(array('name' => 'hash_key', 'value' => $_SESSION['USER']->user->hash_key));
						$sql->update($dataInsertProfils);

						$return = array('type' => 'success', 'msg' => 'Tout les paramètre, on été enregistré', 'title' => 'Profil');
						return $return;
					}
				}
			} else {

				$return = array('type' => 'error', 'msg' => 'Erreur de Key', 'title' => 'Profil');
				return $return;
			}
		} else {
			$return = array('type' => 'error', 'msg' => 'Aucune données', 'title' => 'Profil');
			return $return;
		}
	}
	#########################################
	# Enregistre un nouveau mot de passe
	#########################################
	public function sendSecurity ($data)
	{
		$sql = New BDD();
		$sql->table('TABLE_USERS');
		$sql->where(array('name' => 'hash_key', 'value' => $_SESSION['USER']->user->hash_key));
		$sql->queryOne();
		$results = $sql->data;
		if (password_verify($data['password_old'], $results->password)) {
			$insert['password'] = password_hash($data['password_new'], PASSWORD_DEFAULT);
			$sql = New BDD();
			$sql->table('TABLE_USERS');
			$sql->where(array('name' => 'hash_key', 'value' => $_SESSION['USER']->user->hash_key));
			$sql->update($insert);
			setcookie('BELCMS_HASH_KEY', $_SESSION['USER']->user->hash_key, time()+60*60*24*30*3, '/');
			setcookie('BELCMS_NAME', $results['username'], time()+60*60*24*30*3, '/');
			setcookie('BELCMS_PASS', $insert['password'], time()+60*60*24*30*3, '/');
			$return = array('type' => 'success', 'msg' => constant('SEND_PASS_IS_OK'), 'title' => constant('PASSWORD'));
			return $return;
		} else {
			$return = array('type' => 'error', 'msg' => constant('OLD_PASS_FALSE'), 'title' => constant('PASSWORD'));
			return $return;
		}
	}
	#########################################
	# Enregistre le nouveau avatar (upload)
	#########################################
	public function sendNewAvatar ()
	{
		if (!empty($_FILES['avatar'])) {
			$dir = 'uploads/users/'.$_SESSION['USER']->user->hash_key.'/';
			$extensions = array('.png', '.gif', '.jpg', '.jpeg');
			$extension = strrchr($_FILES['avatar']['name'], '.');
			if (!in_array($extension, $extensions)) {
				$return['msg']  = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg';
				$return['type'] = 'error';
				$return['ext']  = 'Extention';
 			} else if (move_uploaded_file($_FILES['avatar']['tmp_name'], $dir.$_FILES['avatar']['name'])) {
				$return['msg']  = 'Upload effectué avec succès';
				$return['type'] = 'success';
				$return['ext']  = 'Avatar';
				$data = array('avatar' => $dir.$_FILES['avatar']['name'], 'select' => 'select');
				self::avatarSubmit($data);
			} else {
				$return['msg']  = 'Echec de l\'upload !';
				$return['type'] = 'warning';
				$return['ext']  = 'Erreur inconnu';
			}
		} else {
			$return['msg']  = 'Aucun upload d\'image en cours...';
			$return['type'] = 'error';
			$return['ext']  = 'Aucune image';
		}
		return $return;
	}
	#########################################
	# Selectionne l'avatar ou le supprime
	#########################################
	public function avatarSubmit ($data)
	{
		$return = null;
		if ($data['select'] == 'select') {
			if ($data['avatar']) {
				$ext = new \SplFileInfo($data['avatar']);
				$extensions = array('png', 'gif', 'jpg', 'jpeg');
				if (in_array($ext->getExtension(), $extensions)) {
					$sql = New BDD();
					$sql->table('TABLE_USERS');
					$sql->where(array('name'=>'hash_key','value'=>$_SESSION['USER']->user->hash_key));
					$sql->update(array('avatar'=> $data['avatar']));
					$return['msg']  = 'Avatar changer avec succès';
					$return['type'] = 'success';
					$return['ext']  = 'Avatar';
					/* update $_SESSION */
					$_SESSION['USER'] = Users::getInfosUserAll($_SESSION['USER']->user->hash_key);
				} else {
					$return['msg']  = 'mavaise extention de l\'avatar';
					$return['type'] = 'warning';
					$return['ext']  = 'Avatar';
				}
			} else {
				$return['msg']  = 'Aucune avatar';
				$return['type'] = 'warning';
				$return['ext']  = 'Avatar';
			}
		} else if ($data['select'] == 'delete') {
			$return = (object) array();
			$sql = New BDD();
			$sql->table('TABLE_USERS');
			$sql->where(array('name'=>'hash_key','value'=>$_SESSION['USER']->user->hash_key));
			$sql->queryOne();
			$return->$sql->data;
			if (!empty($return)) {
				if ($return->avatar == $data['avatar']) {
					$sql = New BDD();
					$sql->table('TABLE_USERS');
					$sql->where(array('name'=>'hash_key','value'=>$_SESSION['USER']->user->hash_key));
					$sql->insert(array('avatar'=> ''));
					$sql->update();
				}
			}
			$link = constant('DIR_UPLOADS');
			$link .= $data['avatar'];
			// @ = fix erreur Windows localhost
			@unlink($link);
			$return['msg']  = $link;
			$return['type'] = 'success';
			$return['ext']  = 'Avatar';
		}

		return $return;
	}
	#########################################
	# Change les liens social
	#########################################
	public function sendSubmitSocial ($data)
	{
		foreach ($data as $k => $v) {
			$update[$k] = empty($data[$k]) ? '' : Secure::isString($data[$k]);
		}

		if (!empty($update)) {
			$sql = New BDD();
			$sql->table('TABLE_USERS_SOCIAL');
			$sql->update($update);
			$return['msg']  = constant('MODIFY_SOCIAL_SUCCESS');
			$return['type'] = 'success';
			$return['ext']  = 'Liens';
			/* update $_SESSION */
			$_SESSION['USER'] = Users::getInfosUserAll($_SESSION['USER']->user->hash_key);
		} else {
			$return['msg']  = constant('ERROR_UPDATE_BDD');
			$return['type'] = 'warning';
			$return['ext']  = 'Liens';
		}

		return $return;
	}
	#########################################
	# Recuperer tout les jeux depuis la BDD
	#########################################
	public function getGaming ()
	{
		$sql = New BDD();
		$sql->table('TABLE_TEAM');
		$sql->queryAll();
		return $sql->data;
	}
	#########################################
	# Récupère touts auteurs
	#########################################
	public function getTeamUsers ()
	{
		$sql = New BDD();
		$sql->table('TABLE_TEAM_USERS');
		$sql->queryAll();
		return $sql->data;
	}
}