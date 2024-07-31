<?php
use BelCMS\Core\GetHost;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<base href="<?=GetHost::curPageURL();?>">
	<title>Administration</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="managements/assets/css/app.css" rel="stylesheet" type="text/css">
	<link href="managements/assets/css/icons.min.css" rel="stylesheet" type="text/css">
	<link href="assets/plugins/DataTables-1.13.06/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="managements/assets/css/magnific-popup.css">
	<link rel="stylesheet" href="assets/plugins/tinymce/skins/lightgray/skin.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome-6.5.1/css/all.min.css">
	<link rel="stylesheet" href="managements/assets/libs/dropzone/min/dropzone.min.css">
	<link rel="stylesheet" href="assets/plugins/glightbox/glightbox.min.css">
	<link rel="stylesheet" href="assets/plugins/quick-events/quick-events.css">
	<script src="assets/js/jQuery/jquery-3.7.1.min.js"></script>
	<script src="assets/plugins/quick-events/languages/lang.js"></script>
	<script src="managements/assets/js/config.js"></script>
</head>
<body>
	<div class="flex wrapper">
		<div class="app-menu">
			<a href="Dashboard?admin" class="logo-box">
				<div class="logo-light">
					<img src="managements/assets/images/logo-light.png" class="logo-lg h-6" alt="Light logo">
					<img src="managements/assets/images/logo-sm.png" class="logo-sm" alt="Small logo">
				</div>
			</a>
			<button id="button-hover-toggle" class="absolute top-5 end-2 rounded-full p-1.5">
				<span class="sr-only">Menu Toggle Button</span>
				<i class="mgc_round_line text-xl"></i>
			</button>
			<div class="srcollbar" data-simplebar>
				<ul class="menu" data-fc-type="accordion">
					<li class="menu-title">Menu</li>
					<li class="menu-item">
						<a href="Dashboard?admin" class="menu-link">
							<span class="menu-icon"><i class="mgc_home_3_line"></i></span>
							<span class="menu-text"> <?=constant('HOME');?> </span>
						</a>
					</li>
					<li class="menu-item">
						<a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
							<span class="menu-icon"><i class="mgc_greatwall_fill"></i></span>
							<span class="menu-text"> <?=constant('PARAMETERS');?> </span>
							<span class="menu-arrow"></span>
						</a>
						<ul class="sub-menu hidden">
							<?php
							foreach ($menuParameter as $k => $v):
							?>
							<li class="menu-item">
								<a href="<?=$k?>" class="menu-link">
									<span class="menu-text"><?=ucfirst($v)?></span>
								</a>
							</li>
							<?php
							endforeach;
							?>
						</ul>
					</li>
					<li class="menu-item">
						<a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
							<span class="menu-icon"><i class="mgc_inbox_2_fill"></i></span>
							<span class="menu-text"> <?=constant('TEMPLATES');?> </span>
							<span class="menu-arrow"></span>
						</a>
						<ul class="sub-menu hidden">
							<?php
							foreach ($menuTemplates as $k => $v):
							?>
							<li class="menu-item">
								<a href="<?=$k?>" class="menu-link">
									<span class="menu-text"><?=ucfirst($v)?></span>
								</a>
							</li>
							<?php
							endforeach;
							?>
						</ul>
					</li>
					<li class="menu-item">
						<a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
							<span class="menu-icon"><i class="mgc_user_3_fill"></i></span>
							<span class="menu-text"> <?=constant('USERS');?> </span>
							<span class="menu-arrow"></span>
						</a>
						<ul class="sub-menu hidden">
							<?php
							foreach ($menuUsers as $k => $v):
							?>
							<li class="menu-item">
								<a href="<?=$k?>" class="menu-link">
									<span class="menu-text"><?=ucfirst($v)?></span>
								</a>
							</li>
							<?php
							endforeach;
							?>
						</ul>
					</li>
					<li class="menu-item">
						<a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
							<span class="menu-icon"><i class="mgc_file_code_fill"></i></span>
							<span class="menu-text"> <?=constant('PAGES');?> </span>
							<span class="menu-arrow"></span>
						</a>
						<ul class="sub-menu hidden">
							<?php
							foreach ($menuPage as $k => $v):
							?>
							<li class="menu-item">
								<a href="<?=$k?>" class="menu-link">
									<span class="menu-text"><?=ucfirst($v)?></span>
								</a>
							</li>
							<?php
							endforeach;
							?>
						</ul>
					</li>
					<li class="menu-item">
						<a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
							<span class="menu-icon"><i class="mgc_fridge_fill"></i></span>
							<span class="menu-text"> <?=constant('WIDGETS');?> </span>
							<span class="menu-arrow"></span>
						</a>
						<ul class="sub-menu hidden">
							<?php
							foreach ($menuWidget as $k => $v):
							?>
							<li class="menu-item">
								<a href="<?=$k?>" class="menu-link">
									<span class="menu-text"><?=ucfirst($v)?></span>
								</a>
							</li>
							<?php
							endforeach;
							?>
						</ul>
					</li>
					<li class="menu-item">
						<a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
							<span class="menu-icon"><i class="mgc_game_1_fill"></i></span>
							<span class="menu-text"> <?=constant('GAMINGS');?> </span>
							<span class="menu-arrow"></span>
						</a>
						<ul class="sub-menu hidden">
							<?php
							foreach ($menuGaming as $k => $v):
							?>
							<li class="menu-item">
								<a href="<?=$k?>" class="menu-link">
									<span class="menu-text"><?=ucfirst($v)?></span>
								</a>
							</li>
							<?php
							endforeach;
							?>
						</ul>
					</li>
					<li class="menu-item">
						<a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
							<span class="menu-icon"><i class="mgc_file_more_fill"></i></span>
							<span class="menu-text"> <?=constant('MISCELLANEOUS');?> </span>
							<span class="menu-arrow"></span>
						</a>
						<ul class="sub-menu hidden">
							<?php
							foreach ($menuExtras as $k => $v):
							?>
							<li class="menu-item">
								<a href="<?=$k?>" class="menu-link">
									<span class="menu-text"><?=ucfirst($v)?></span>
								</a>
							</li>
							<?php
							endforeach;
							?>
						</ul>
					</li>
				</ul>
				<div class="my-10 mx-5">
            		<div class="help-box p-6 bg-black/5 text-center rounded-md">
                		<a href="<?=GetHost::curPageURL();?>" class="btn btn-sm bg-secondary text-white">Retour au site</a>
            		</div>
       			</div>
			</div>
		</div>
		<div class="page-content">
			<header class="app-header flex items-center px-4 gap-3">
                <button id="button-toggle-menu" class="nav-link p-2">
                    <span class="sr-only">Menu Toggle Button</span>
                    <span class="flex items-center justify-center h-6 w-6">
                        <i class="mgc_menu_line text-xl"></i>
                    </span>
                </button>
                <a href="index.html" class="logo-box">
                    <div class="logo-light">
                        <img src="managements/assets/images/logo-light.png" class="logo-lg h-6" alt="Light logo">
                        <img src="managements/assets/images/logo-sm.png" class="logo-sm" alt="Small logo">
                    </div>
                    <div class="logo-dark">
                        <img src="managements/assets/images/logo-dark.png" class="logo-lg h-6" alt="Dark logo">
                        <img src="managements/assets/images/logo-sm.png" class="logo-sm" alt="Small logo">
                    </div>
                </a>
                <div class="md:flex hidden">
                    <button data-toggle="fullscreen" type="button" class="nav-link p-2">
                        <span class="sr-only">Fullscreen Mode</span>
                        <span class="flex items-center justify-center h-6 w-6">
                            <i class="mgc_fullscreen_line text-2xl"></i>
                        </span>
                    </button>
                </div>
                <div class="flex">
                    <button id="light-dark-mode" type="button" class="nav-link p-2">
                        <span class="sr-only">Light/Dark Mode</span>
                        <span class="flex items-center justify-center h-6 w-6">
                            <i class="mgc_moon_line text-2xl"></i>
                        </span>
                    </button>
                </div>
				<?php 
				$avatar = empty($_SESSION['USER']->profils->avatar) ? constant('DEFAULT_AVATAR') : $_SESSION['USER']->profils->avatar;
				?>
                <div class="relative">
                    <button data-fc-type="dropdown" data-fc-placement="bottom-end" type="button" class="nav-link fc-dropdown">
                        <img src="<?=$avatar;?>" alt="user-image" class="rounded-full h-10">
                    </button>
                    <div class="fc-dropdown fc-dropdown-open:opacity-100 hidden opacity-0 w-44 z-50 transition-[margin,opacity] duration-300 mt-2 bg-white shadow-lg border rounded-lg p-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800">
                        <a class="flex items-center py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="pages-gallery.html">
                            <i class="mgc_pic_2_line  me-2"></i> 
                            <span>Gallery</span>
                        </a>
                        <a class="flex items-center py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="apps-kanban.html">
                            <i class="mgc_task_2_line  me-2"></i> 
                            <span>Kanban</span>
                        </a>
                        <a class="flex items-center py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="auth-login.html">
                            <i class="mgc_lock_line  me-2"></i> 
                            <span>Lock Screen</span>
                        </a>
                        <hr class="my-2 -mx-2 border-gray-200 dark:border-gray-700">
                        <a class="flex items-center py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="auth-login.html">
                            <i class="mgc_exit_line  me-2"></i> 
                            <span>Log Out</span>
                        </a>
                    </div>
                </div>
            </header>
			<main class="flex-grow p-6">
				<?php
				echo $render;
				?>
			</main>

			<footer class="footer h-16 flex items-center px-6 bg-white shadow dark:bg-gray-800">
                <div class="flex justify-center w-full gap-4">
                    <div>
                        <script>document.write(new Date().getFullYear())</script> © <a href="https://bel-CMS.dev" target="_blank">Bel-CMS v.<?=constant('VERSION_CMS');?></a>
                    </div>
                </div>
            </footer>
            
		</div>
	</div>

	<script src="managements/assets/js/extract.js"></script>
	<script src="assets/plugins/glightbox/glightbox.min.js"></script>
	<script src="assets/plugins/tooltip/popper.min.js"></script>
	<script src="assets/plugins/tooltip/tippy-bundle.umd.min.js"></script>
	<script src="assets/plugins/tooltip/tooltip.js"></script>
	<script src="assets/plugins/tinymce/tinymce.min.js"></script>
	<script src="assets/plugins/DataTables-1.13.06/datatables.min.js"></script>
	<script src="managements/assets/js/datatables.fr.js"></script>
	<script src="managements/assets/libs/simplebar/simplebar.min.js"></script>
	<script src="managements/assets/libs/feather-icons/feather.min.js"></script>
	<script src="managements/assets/libs/@frostui/tailwindcss/frostui.js"></script>
	<script src="managements/assets/libs/dropzone/min/dropzone-amd-module.min.js"></script>
	<script src="assets/js/belcms.core.js"></script>
	<script src="managements/assets/js/app.js"></script>
	<script src="assets/plugins/quick-events/jquery.magnific-popup.js"></script>
	<script src="assets/plugins/quick-events/quick-events.js"></script>
	<script src="assets/js/jscolor.min.js"></script>
	</body>
</html>