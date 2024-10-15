<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.1.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

use BelCMS\Requires\Common;

class File_manager extends AdminPages
{
	var $admin  = true; // Admin suprême uniquement (Groupe 1);
	var $active = true;
	var $bdd = 'ModelsFiles';

	public function index ()
	{
		$data['space_total']  = self::GetTotalHDD();
		$data['space_free']   = self::GetUsedHDD();
		$data['percent_free'] = self::GetPercentHDD();
		$data['uploads']      = Common::ConvertSize(self::GetUsed(ROOT.DS.'uploads'));
		$data['users']        = Common::ConvertSize(self::GetUsed(ROOT.DS.'uploads'.DS.'users'));
		$data['downloads']    = Common::ConvertSize(self::GetUsed(ROOT.DS.'uploads'.DS.'downloads'));
		$data['gallery']      = Common::ConvertSize(self::GetUsed(ROOT.DS.'uploads'.DS.'gallery'));
		$data['tmp']          = Common::ConvertSize(self::GetUsed(ROOT.DS.'uploads'.DS.'tmp'));
		$data['templates']    = Common::ConvertSize(self::GetUsed(ROOT.DS.'templates'));
		$data['forum']        = Common::ConvertSize(self::GetUsed(ROOT.DS.'uploads'.DS.'forum'));
		$data['articles']     = Common::ConvertSize(self::GetUsed(ROOT.DS.'pages'.DS.'articles'.DS.'sub-page'));
		$data['data']         = $this->models->getUploads();
		$this->set($data);
		$this->render('index');
	}

	public function uploadTPL ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'file_manager?management&option=extras','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$this->render('tpl', $menu);
	}

	public function uploadPAGE ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'file_manager?management&option=extras','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$this->render('page', $menu);	
	}

	public function uploadCMS ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'file_manager?management&option=extras','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$this->render('cms', $menu);
	}

	public function install ()
	{
		$id = (int) $this->data[2];
		$return = $this->models->install($id);
		debug($return); // sert uniquement au dev, pour un debug 
	}

	public function installPage ()
	{
		$id = (int) $this->data[2];
		$return = $this->models->installPage ($id);
	}

	public function delete ()
	{
		$id = (int) $this->data[2];
		$return = $this->models->delete($id);
		debug($return); // sert uniquement au dev, pour un debug 
	}

	public function sendTpl ()
	{
		$return = $this->models->sendTpl();
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('file_manager?management&option=pages', 2);
	}

	public function sendPage ()
	{
		$return = $this->models->sendPage();
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('file_manager?management&option=pages', 2);
	}

	public function sendCMS ()
	{
		$return = $this->models->sendCMS();
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('file_manager?management&option=pages', 2);
	}

	public function backup ()
	{
		$data['space_total']  = self::GetTotalHDD();
		$data['space_free']   = self::GetUsedHDD();
		$data['percent_free'] = self::GetPercentHDD();
		$data['data'] = $this->models->backup();
		$this->set($data);
		$this->render('backup');	
	}

	public function cms ()
	{
		$data['space_total']  = self::GetTotalHDD();
		$data['space_free']   = self::GetUsedHDD();
		$data['percent_free'] = self::GetPercentHDD();
		$data['data'] = $this->models->backupCMS();
		$this->set($data);
		$this->render('cms_install');
	}

	public function backupcms ()
	{
		$date = new DateTime('now');		
		$date = $date->format('d_m_Y.H_i_s');
		$source = ROOT.DS;
		$destination = ROOT.DS.'backup'.DS.'backup_CMS_'.$date;
		if (Common::zipAchive($source, $destination) == true) {
			return true;
		} else {
			return false;
		}
	}

	public function saveBDD ()
	{
		$this->models->saveBDD();
	}

	public function deleteBackup ()
	{
		if (isset($_GET['url']) and !empty($_GET['url'])) {
			unlink($_GET['url']);
			return true;
		} else {
			return false;
		}
	}

	public function saveUploads () : bool
	{
		$date = new DateTime('now');		
		$date = $date->format('d_m_Y.H_i_s');
		$source = ROOT.DS.'uploads'.DS;
		$destination = ROOT.DS.'uploads'.DS.'backup'.DS.'backup_uploads_'.$date;
		if (Common::zipAchive($source, $destination) == true) {
			return true;
		} else {
			return false;
		}
	}

	public function saveUsers () : bool 
	{
		$date = new DateTime('now');		
		$date = $date->format('d_m_Y.H_i_s');
		$source = ROOT.DS.'uploads'.DS.'users'.DS;
		$destination = ROOT.DS.'uploads'.DS.'backup'.DS.'backup_users_'.$date;
		if (Common::zipAchive($source, $destination) == true) {
			return true;
		} else {
			return false;
		}	
	}

	public function saveDownloads () : bool
	{
		$date = new DateTime('now');		
		$date = $date->format('d_m_Y.H_i_s');
		$source = ROOT.DS.'uploads'.DS.'downloads'.DS;
		$destination = ROOT.DS.'uploads'.DS.'backup'.DS.'backup_uploads_'.$date;
		if (Common::zipAchive($source, $destination) == true) {
			return true;
		} else {
			return false;
		}
	}

	public function saveTpl () : bool
	{
		$date = new DateTime('now');		
		$date = $date->format('d_m_Y.H_i_s');
		$source = ROOT.DS.'templates'.DS;
		$destination = ROOT.DS.'uploads'.DS.'backup'.DS.'backup_templates_'.$date;
		if (Common::zipAchive($source, $destination) == true) {
			return true;
		} else {
			return false;
		}
	}

	public function saveGallery ()
	{
		$date = new DateTime('now');		
		$date = $date->format('d_m_Y.H_i_s');
		$source = ROOT.DS.'uploads'.DS.'gallery'.DS;
		$destination = ROOT.DS.'uploads'.DS.'backup'.DS.'backup_gallery_'.$date;
		if (Common::zipAchive($source, $destination) == true) {
			return true;
		} else {
			return false;
		}
	}

	public function saveTmp () : bool
	{
		$date = new DateTime('now');		
		$date = $date->format('d_m_Y.H_i_s');
		$source = ROOT.DS.'uploads'.DS.'tmp'.DS;
		$destination = ROOT.DS.'uploads'.DS.'backup'.DS.'backup_temp_'.$date;
		if (Common::zipAchive($source, $destination) == true) {
			return true;
		} else {
			return false;
		}
	}

	public function saveForum () : bool
	{
		$date = new DateTime('now');		
		$date = $date->format('d_m_Y.H_i_s');
		$source = ROOT.DS.'uploads'.DS.'forum'.DS;
		$destination = ROOT.DS.'uploads'.DS.'backup'.DS.'backup_forum_'.$date;
		if (Common::zipAchive($source, $destination) == true) {
			return true;
		} else {
			return false;
		}
	}

	public function saveArticles () : bool
	{
		$date = new DateTime('now');		
		$date = $date->format('d_m_Y.H_i_s');
		$source = ROOT.DS.'uploads'.DS.'articles'.DS;
		$destination = ROOT.DS.'uploads'.DS.'backup'.DS.'backup_articles_'.$date;
		if (Common::zipAchive($source, $destination) == true) {
			return true;
		} else {
			return false;
		}
	}

	private function GetTotalHDD ()
	{
		return Common::ConvertSize(disk_total_space(ROOT), ['maxThreshold' => 6]);
	}

	private function GetUsedHDD ()
	{
		$total = disk_total_space(ROOT) - disk_free_space(ROOT);
		return Common::ConvertSize($total);
	}

	private function GetUsed ($rep)
	{
		$Racine = opendir($rep);
		$Taille = 0;
		while($Dossier = readdir($Racine)) {
		  if ( $Dossier != '..' And $Dossier !='.' ) {
			if (is_dir($rep.'/'.$Dossier)) $Taille += self::GetUsed($rep.'/'.$Dossier);
			else $Taille += filesize($rep.'/'.$Dossier);
		  }
		}
		closedir($Racine);
		return $Taille;
	}
	private function GetPercentHDD ()
	{
		$dt = disk_total_space(ROOT);
		$df = disk_free_space(ROOT);
		$freespace = $df / 1048576;
		$totalspace = $dt / 1048576;
		$usedspace = $totalspace - $freespace;
		$pourcent = $usedspace / $totalspace;
		$usedspace = $usedspace / 1024;
		$usedspace = round($usedspace, 3);
		$pourcent = $pourcent * 100;
		$pourcent = round($pourcent, 2);
		return $pourcent;
	}
}