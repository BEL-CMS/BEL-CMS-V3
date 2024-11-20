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

namespace Belcms\Pages\Models;

use BelCMS\Core\Secure;
use BelCMS\Core\UserNotification;
use BelCMS\PDO\BDD;
use BelCMS\User\User as Users;
use BelCMS\Requires\Common;
use BelCMS\Core\eMail;
use BelCMS\Core\encrypt;

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
			// Ajout du blacklistage des mail jetables & spam
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

			if (!isset($data['charter'])) {
				$return['msg']   = constant('CHARTER_ERROR'); $error++;
				$return['type']  = 'error';
			} else if (empty($data['username']) OR empty($data['email']) OR empty($data['passwordhash'])) {
				$return['msg']   = constant('UNKNOW_USER_MAIL_PASS'); $error++;
				$return['type']  = 'error';
			} else if (in_array($tmpNdd[0], $arrayBlackList)) {
				$return['msg']   = constant('NO_MAIL_ALLOWED'); $error++;
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

			$data['username'] = str_replace(' ', '_', $data['username']);

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

					$passwordCrypt =  new encrypt($_POST['passwordrepeat'], $_SESSION['CONFIG_CMS']['KEY_ADMIN']);
					$password      = $passwordCrypt->encrypt();

					$pass_key      = Common::randomString(32);

					$insertUser = array(
						'id'                => null,
						'username'          => $data['username'],
						'hash_key'          => $hash_key,
						'password'          => $password,
						'mail'              => $data['email'],
						'ip'                => Common::getIp(),
						'expire'            => (int) 0,
						'token'             => '',
						'gold'              => (int) 0
					);

					if ($_SESSION['CONFIG_CMS']['VALIDATION'] == 'mail') {
						$insertUser['valid'] = (int) 0;
						$insertUser['number_valid'] = $pass_key;
					} else {
						$insertUser['valid'] = (int) 1;
						$insertUser['number_valid'] = null;
					}

					$test = New BDD();
					$test->table('TABLE_USERS');
					$test->count();

					$insert = New BDD();
					$insert->table('TABLE_USERS');
					$insert->insert($insertUser);

					if ($test->data == 0) {
						$insertGroups = array(
							'id'                => null,
							'hash_key'          => $hash_key,
							'user_group'        => 1,
							'user_groups'       => 1
						);
					} else {
						$insertGroups = array(
							'id'                => null,
							'hash_key'          => $hash_key,
							'user_group'        => 2,
							'user_groups'       => 2
						);
					}

					$insertGrp = New BDD();
					$insertGrp->table('TABLE_USERS_GROUPS');
					$insertGrp->insert($insertGroups);

					$dataProfils = array(
						'hash_key'     => $hash_key,
						'gender'       => 'unisexual',
						'public_mail'  => '',
						'websites'     => '',
						'list_ip'      => '',
						'avatar'       => constant('DEFAULT_AVATAR'),
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

					$hardware = New BDD();
					$hardware->table('TABLE_USERS_HARDWARE');
					$hardware->insert(array('author'=> $hash_key));

					if ($_SESSION['CONFIG_CMS']['VALIDATION'] == 'mail') {
						require constant('DIR_CORE').'class.mail.php';
						$mail = new eMail;
						$mail->setFrom($_SESSION['CONFIG_CMS']['CMS_WEBSITE_NAME']);
						$mail->addAdress($data['email'], $data['username']);
						$mail->subject(constant('ACCOUNT_REGISTRATION'));
						$mail->body(self::sendHtmlBody($hash_key));
						$mail->submit();
					}

				}
			}
			$return['msg']  = constant('CURRENT_RECORD');
			$return['type'] = 'success';
			return $return;
		}
	}

	private function sendHtmlBody ($hash_key)
	{
		setLocale(LC_TIME, 'fr_FR.utf8');

		$date = new \DateTime();
		$date = $date->format('d/m/Y à H:i:s');

		$user = Users::getInfosUserAll($hash_key);

		if ($_SERVER['SERVER_PORT'] == '80') {
			$host = 'http://'.$_SERVER['HTTP_HOST'].'/';
		} else {
			$host = 'https://'.$_SERVER['HTTP_HOST'].'/';
		}

		return '<table width="100%" border="0" cellspacing="5" cellpadding="5" bgcolor="#666666">
				<thead><tr><th><a style="color:#CCC; text-decoration:none" href="'.$host.'" style="display:block; text-align:center">'.$_SESSION['CONFIG_CMS']['CMS_WEBSITE_NAME'].'</a></th></tr>
				</thead>
				<tbody><tr><td>
				<table width="90%" border="0" align="center" cellpadding="5" cellspacing="5" bgcolor="#FFF"><tr><td><p>'.constant('ACTIVE_TO_SERIAL').'</p></td></tr></table></td></tr></tbody></table>
				<table style="color:#FFF; text-align:center" width="100%" border="0" align="center" cellpadding="5" cellspacing="5" bgcolor="#3333"><tr><td>'.$user->user->number_valid.'</td></tr></table>
				<table style="color:#FFF; text-align:center" width="100%" border="0" align="center" cellpadding="5" cellspacing="5" bgcolor="#8f8e8c"><thead><tr><td colspan="2"><b>'.constant('INFOS').'</b></td></tr></thead><tbody><tr bordercolor="#FFF"><td style="text">'.constant('NAME').'</td><td><b>'.$user->user->username.'</b></td></tr><tr><td>'.constant('DATE').'</td><td><b>'.$date.'</b></td></tr><tr><td>IP</td><td><b>'.Common::GetIp().'</b></td></tr></tbody>
				</table></body></html>';
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
		$insertProfil['info_text'] = Common::VarSecure($data['info_text'], 'html');
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

			$passwordCrypt =  new encrypt($data['password'], $_SESSION['CONFIG_CMS']['KEY_ADMIN']);
			$passwordDecrypt = $passwordCrypt->decrypt();

			if ($passwordDecrypt == $results->password) {
				$insertUser['password'] = $passwordCrypt;
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
			New UserNotification($_SESSION['USER']->user->hash_key, 'Mot de passe changer');
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
			$dir = 'uploads/users/'.$_SESSION['USER']->user->hash_key.'/';
			$checkdir = strpos($data, $dir);
			if ($checkdir !== false) {
				$sql = New BDD();
				$sql->table('TABLE_USERS_PROFILS');
				$sql->where(array('name'=>'hash_key','value'=>$_SESSION['USER']->user->hash_key));
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
			$dir = 'uploads'.DS.'users'.DS.$_SESSION['USER']->user->hash_key.DS;
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
		$character = "#/*&@$%-+2346789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
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
				$type = 'mail';
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
					$contentMail  = '<tr>';
					$contentMail .= '<td><p style="text-align:center;">Token de réinitialisation de mot de passe, valable 1h00</p></td>';
					$contentMail .= '</tr>';
					$contentMail .= '<tr>';
					$contentMail .= '<td>';
					$contentMail .= '<table style="margin: 25px auto;background-color: #EE7716;width:100%;display:block;">';
					$contentMail .= '<tr style="width:100%;"><td style="width:100%:padding: 15px;color: #FFF;font-size: 14px;"><p style="text-align:center;">' . $hashToken . '</p></td></tr>';
					$contentMail .= '</table>';
					$contentMail .= '</td>';
					$contentMail .= '</tr>';

					$mail = array(
						'subject'  => 'Demande de nouveau mot de passe',
						'content'  => self::contentMail('Token', $contentMail),
						'sendMail' => $results['mail']
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
						$return['msg']  = 'Ce token n\'est plus valide, un nouveau a été généré';
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
							// Update du mot de passe & reset du token
							$contentMail  = '<tr>';
							$contentMail .= '<td><p style="text-align:center;">Mot de passe, réinitialiser</p></td>';
							$contentMail .= '</tr>';
							$contentMail .= '<tr>';
							$contentMail .= '<td>';
							$contentMail .= '<table style="margin: 25px auto;background-color: #EE7716;width:100%;display:block;">';
							$contentMail .= '<tr style="width:100%;"><td style="width:100%:padding: 15px;color: #FFF;font-size: 14px;"><p style="text-align:center;">' . $generatePass . '</p></td></tr>';
							$contentMail .= '</table>';
							$contentMail .= '</td>';
							$contentMail .= '</tr>';

							$name = defined('CMS_WEBSITE_NAME') ? constant('CMS_WEBSITE_NAME') : 'Nom inconnu';
							$mailInconnu = defined('CMS_MAIL_WEBSITE') ? constant('CMS_MAIL_WEBSITE') : 'no_reply@bel-cms.dev';
							$mail = array(
								'name'     => $name,
								'mail'     => $mailInconnu,
								'subject'  => 'Demande de nouveau mot de passe',
								'content'  => self::contentMail('Mot de passe', $contentMail),
								'sendMail' => $results['mail']
							);

							$encrypt = new encrypt($generatePass, $_SESSION['CONFIG_CMS']['KEY_ADMIN']);
							$crpyt = $encrypt->encrypt();

							$returnMail = Common::sendMail($mail);
							$return['msg']  = 'Voici votre nouveau mot de passe : '. $generatePass;
							$return['type'] = 'success';
							$return['pass'] = true;
							$sqlUpdatePass  = new BDD;
							$sqlUpdatePass->table('TABLE_USERS');
							$sqlUpdatePass->where(array('name' => $type,'value'=> $data['value']));
							$sqlUpdatePass->update(array('password' => $crpyt));
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
		$datetime = date_create()->format('Y-m-d H:i:s');
		$date = Common::TransformDate($datetime, 'FULL', 'MEDIUM');
		$return = '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<style>
					* {
					color: #777777;
					font-family: monospace, monospace;
					font-size: 12px;
					margin: 0; padding: 0;
					border-collapse: collapse;
					}
					body {
						background-color: #444444;
						width: 100%;
						height: 100%;
					}
					p {
						text-align: justify;
						padding: 0 15px;
					}
					.table_content {
						width:600px; background-color: #FFF; color:#777777; padding:20px; display:block;border:2px solid #EE7716;border-top: 0px; border-bottom: 3px solid #EE7716;
					}
				  </style>
			</head>
			<body>
				<table width="100%">
					<tr>
						<td style="background-color: #EE7716;height: 80px; color: #FFF;text-align: center;font-size: 32px;">'.$_SESSION['CONFIG_CMS']['CMS_WEBSITE_NAME'].'</td>
					</tr>
					<tr>
						<td align="center">
							<table class="table_content">
								'.$content.'
								<tr>
									<td style="background-color: #f4f4f4; height: 80px;">
										<table style="text-align: left;display: block;padding-left: 25px;width: 100%;">
											<tbody style="width: 100%; display: block;">
												<tr style="width: 100%;display: block;overflow: hidden;">
													<td style="text-align: left; width: 40%;display: block;float: left;">SiteWeb <i style="float: right;">:</i></td>
													<td style="text-align: left;width: 60%;display: block;float: left;"><b>'.$_SESSION['CONFIG_CMS']['HOST'].'</b></td>
												</tr>
												<tr style="width: 100%;display: block;overflow: hidden;">
													<td style="text-align: left;width: 40%;display: block;float: left;">Date & heure<i style="float: right;">:</i></td>
													<td style="text-align: left;width: 60%;display: block;float: left;"><b>'.$date.'</b></td>
												</tr>
												<tr style="width: 100%;display: block;overflow: hidden;">
													<td style="text-align: left;width: 40%;display: block;float: left;">IP<i style="float: right;">:</i></td>
													<td style="text-align: left;width: 60%;display: block;float: left;"><b>'.Common::GetIp().'</b></td>
												</tr> 
											</tbody>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</body>
		</html>
		';
		
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
						$dataInsertProfils['info_text'] = Common::VarSecure($data['info_text'], 'html');
						$dataInsertProfils['info_text'] = empty($dataInsertProfils['info_text']) ? '<p></p>' : $dataInsertProfils['info_text'];

						$sql = New BDD();
						$sql->table('TABLE_USERS_PROFILS');
						$sql->where(array('name' => 'hash_key', 'value' => $_SESSION['USER']->user->hash_key));
						$sql->update($dataInsertProfils);

						$return = array('type' => 'success', 'msg' => 'Tout les paramètre, on été enregistré', 'title' => 'Profil');
						New UserNotification($_SESSION['USER']->user->hash_key, 'Profil mise à jour');
						$_SESSION['USER'] = Users::getInfosUserAll($_SESSION['USER']->user->hash_key);
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

		$a = new encrypt($results->password, $_SESSION['CONFIG_CMS']['KEY_ADMIN']);
		$a = $a->decrypt();
		$b = $data['password_old'];

		if ($a == $b) {
			$new = new encrypt($data['password_new'], $_SESSION['CONFIG_CMS']['KEY_ADMIN']);
			$new = $new->encrypt();
			$insert['password'] = $new;
			$sql = New BDD();
			$sql->table('TABLE_USERS');
			$sql->where(array('name' => 'hash_key', 'value' => $_SESSION['USER']->user->hash_key));
			$sql->update($insert);
			setcookie('BELCMS_HASH_KEY', $_SESSION['USER']->user->hash_key, time()+60*60*24*30*3, '/');
			setcookie('BELCMS_NAME', $_SESSION['USER']->user->username, time()+60*60*24*30*3, '/');
			setcookie('BELCMS_PASS', $insert['password'], time()+60*60*24*30*3, '/');
			$return = array('type' => 'success', 'msg' => constant('SEND_PASS_IS_OK'), 'title' => constant('PASSWORD'));
			New UserNotification($_SESSION['USER']->user->hash_key, constant('SEND_PASS_IS_OK'));
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
				$return['title']  = 'Extention';
 			} else if (move_uploaded_file($_FILES['avatar']['tmp_name'], $dir.$_FILES['avatar']['name'])) {
				$return['msg']  = 'Upload effectué avec succès';
				$return['type'] = 'success';
				$return['title']  = 'Avatar';
				$data = array('avatar' => $dir.$_FILES['avatar']['name'], 'select' => 'select');
				self::avatarSubmit($data);
			} else {
				$return['msg']  = 'Echec de l\'upload !';
				$return['type'] = 'warning';
				$return['title']  = 'Erreur inconnu';
			}
		} else {
			$return['msg']  = 'Aucun upload d\'image en cours...';
			$return['type'] = 'error';
			$return['title']  = 'Aucune image';
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
					$sql->table('TABLE_USERS_PROFILS');
					$sql->where(array('name'=>'hash_key','value'=>$_SESSION['USER']->user->hash_key));
					$sql->update(array('avatar'=> $data['avatar']));
					$return['msg']  = 'Avatar changer avec succès';
					$return['type'] = 'success';
					$return['title']  = 'Avatar';
					/* update $_SESSION */
					New UserNotification($_SESSION['USER']->user->hash_key, 'Avatar changer');
					$_SESSION['USER'] = Users::getInfosUserAll($_SESSION['USER']->user->hash_key);
					return $return;
				} else {
					$return['msg']    = 'mavaise extention de l\'avatar';
					$return['type']   = 'warning';
					$return['title']  = 'Avatar';
				}
			} else {
				$return['msg']       = 'Aucune avatar';
				$return['type']      = 'warning';
				$return['title']  = 'Avatar';
			}
		} else if ($data['select'] == 'delete') {
			$sql = New BDD();
			$sql->table('TABLE_USERS_PROFILS');
			$sql->where(array('name'=>'hash_key','value'=>$_SESSION['USER']->user->hash_key));
			$sql->update(array('avatar'=> constant('DEFAULT_AVATAR')));
			$link = $data['avatar'];
			// @ = fix erreur Windows localhost
			@unlink($link);
			unset($return);
			New UserNotification($_SESSION['USER']->user->hash_key, 'Avatar surrpimé');
			$return['msg']    = $link;
			$return['type']   = 'success';
			$return['title']  = 'Avatar';
		}

		return $return;
	}
	#########################################
	# Sauvegarde le background avatar
	#########################################
	public function bgSubmit ($data)
	{
		if (!empty($_FILES['hight_avatar'])) {
			$dir = 'uploads/users/'.$_SESSION['USER']->user->hash_key.'/';
			$extensions = array('.png', '.gif', '.jpg', '.jpeg');
			$extension = strrchr($_FILES['hight_avatar']['name'], '.');
			if (!in_array($extension, $extensions)) {
				$return['msg']    = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg';
				$return['type']   = 'error';
				$return['title']  = 'Extention';
				return $return;
			} else {
				Common::Upload('hight_avatar', $dir, $extensions);
				$sql = New BDD();
				$sql->table('TABLE_USERS_PROFILS');
				$sql->where(array('name'=>'hash_key','value'=>$_SESSION['USER']->user->hash_key));
				$sql->update(array('hight_avatar'=> $dir.$_FILES['hight_avatar']['name']));
				$return['msg']    = 'Avatar changer avec succès';
				$return['msg']    = 'Upload effectué avec succès';
				$return['type']   = 'success';
				$return['title']  = 'Avatar';
				New UserNotification($_SESSION['USER']->user->hash_key, 'Image de couverture ajouter');
				$_SESSION['USER'] = Users::getInfosUserAll($_SESSION['USER']->user->hash_key);
			}
		} else {
			$return['msg']  = 'Aucun upload d\'image en cours...';
			$return['type'] = 'error';
			$return['title']  = 'Aucune image';
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
			$sql->where(array('name'=>'hash_key','value'=>$_SESSION['USER']->user->hash_key));
			$sql->update($update);
			$return['msg']    = constant('MODIFY_SOCIAL_SUCCESS');
			$return['type']   = 'success';
			$return['title']  = 'Liens';
			/* update $_SESSION */
			New UserNotification($_SESSION['USER']->user->hash_key, constant('MODIFY_SOCIAL_SUCCESS'));
			$_SESSION['USER'] = Users::getInfosUserAll($_SESSION['USER']->user->hash_key);
		} else {
			$return['msg']    = constant('ERROR_UPDATE_BDD');
			$return['type']   = 'warning';
			$return['title']  = 'Liens';
		}

		return $return;
	}
	#########################################
	# Recuperer tout les jeux depuis la BDD
	#########################################
	public function getGames ()
	{
		$sql = New BDD();
		$sql->table('TABLE_PAGES_GAMES');
		$sql->queryAll();
		return $sql->data;
	}
	#########################################
	# Récupère touts auteurs
	#########################################
	public function sendGames ($data = null)
	{
		$return = array();
		$sql = New BDD();
		$sql->table('TABLE_USERS_GAMING');
		$sql->where(array('name'=> 'hash_key','value'=>$_SESSION['USER']->user->hash_key));
		$sql->queryOne();
		if ($sql->rowCount == 1) {
			if ($data == null) {
				$insert = new BDD();
				$insert->table('TABLE_USERS_GAMING');
				$insert->where(array('name'=> 'hash_key','value'=>$_SESSION['USER']->user->hash_key));
				$return['name_game'] = null;
				$insert->update($return); 
			} else {
				$returnData = $sql->data;
				$id = explode('|',$returnData->name_game);
				$return = array_merge($data, $id);
				$data   = array_unique($return); unset($return);
				if (count($data) == 1) {
					$return['name_game'] = $data;
				} else {
					$return['name_game'] = implode('|', $data);
				}
				$return['name_game'] = substr($return['name_game'], 0, -1);
				$insert = new BDD();
				$insert->table('TABLE_USERS_GAMING');
				$insert->where(array('name'=> 'hash_key','value'=>$_SESSION['USER']->user->hash_key));
				$insert->update($return);
			}
		} else {
			$insert = new BDD();
			$insert->table('TABLE_USERS_GAMING');
			$insert->where(array('name'=> 'hash_key','value'=>$_SESSION['USER']->user->hash_key));
			$insert->insert($data);
		}
		$return['msg']  = constant('MODIFY_GAMES_SUCCESS');
		$return['type'] = 'success';
		$return['title']  = constant('VIDEO_GAMES');
		New UserNotification($_SESSION['USER']->user->hash_key, constant('MODIFY_GAMES_SUCCESS'));
		return $return;
	}

	public function sessions ()
	{
		$sql = new BDD();
		$sql->table('TABLE_VISITORS');
		$sql->where(array('name' => 'visitor_user', 'value' => $_SESSION['USER']->user->hash_key));
		$sql->orderby(array(array('name' => 'id', 'type' => 'DESC')));
		$sql->limit(7);
		$sql->queryAll();
		$return = $sql->data;
		return $return;
	}

	public function sendGen ($data)
	{
		if (is_array($data)) {
			$insert['gravatar'] = isset($data['gravatar']) && $data['gravatar'] == 'on' ? '1' : '0';
			$insert['profils']  = isset($data['profils'])  && $data['profils']  == 'on' ? '1' : '0';
			$sql = New BDD();
			$sql->table('TABLE_USERS_PROFILS');
			$sql->where(array('name' => 'hash_key', 'value' => $_SESSION['USER']->user->hash_key));
			$sql->update($insert);
			$return['msg']  = constant('MODIFY_PROFILS_SUCCESS');
			$return['type'] = 'success';
			New UserNotification($_SESSION['USER']->user->hash_key, constant('MODIFY_PROFILS_SUCCESS'));
			$_SESSION['USER'] = Users::getInfosUserAll($_SESSION['USER']->user->hash_key);
			return $return;
		} else {
			$return['msg']  = constant('MODIFY_PROFILS_ERROR');
			$return['type'] = 'alert';
			return $return;
		}
	}

	public function getNotif ()
	{
		$sql = New BDD();
		$sql->table('TABLE_USERS_NOTIFICATION');
		$sql->where(array('name' => 'author', 'value' => $_SESSION['USER']->user->hash_key));
		$sql->limit(6);
		$sql->queryAll();
		return $sql->data;
	}

	public function testUser () : bool
	{
		if (Users::isLogged()) {
			$sql = new BDD;
			$sql->table('TABLE_USERS');
			$sql->where(array('name' => 'hash_key', 'value' => $_SESSION['USER']->user->hash_key));
			$sql->queryOne();
			$data = $sql->data;
			return empty($data->number_valid) ? false : true;
		} else {
			return true;
		}
	}
	public function ChangeGroup ($id)
	{
		$up['user_group'] = $id;
		$update = New BDD;
		$update->table('TABLE_USERS_GROUPS');
		$update->update($up);

		$return['msg']    = constant('MODIFY_PROFILS_SUCCESS');
		$return['type']   = 'success';
		/* Mise à jour du profil */
		$_SESSION['USER'] = Users::getInfosUserAll($_SESSION['USER']->user->hash_key);
		return $return; 
	}
	public function banGroup ($data)
	{
		$sql = new BDD;
		$sql->table('TABLE_BAN');
		$sql->insert($data);
		debug($sql);
	}

	public function getCaptcha ()
	{
		$sql = new BDD;
		$sql->table('TABLE_CAPTCHA');
		$sql->where(array('name' => 'IP', 'value' => Common::GetIp()));
		$sql->queryOne();
		return $sql->data;
	}

	public function updateComputer ($data)
	{
		if (is_array($data)) {
			$sql = new BDD;
			$sql->table('TABLE_USERS_HARDWARE');
			$sql->where(array('name' => 'author', 'value' => $_SESSION['USER']->user->hash_key));
			$sql->update($data);
			$_SESSION['USER'] = Users::getInfosUserAll($_SESSION['USER']->user->hash_key);
		}
	}
}