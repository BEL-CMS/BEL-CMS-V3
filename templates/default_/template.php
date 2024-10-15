<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <base href="<?=$var->host;?>">
        <meta charset="UTF-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Bel-CMS - <?=$var->link;?></title>
        <meta name="robots" content="index, follow"/>
        <meta name="keywords" content=""/>
        <meta name="description" content=""/>
		<?=$var->css;?>
        <link type="text/css" rel="stylesheet" href="templates/default/css/plugins.css">
        <link type="text/css" rel="stylesheet" href="templates/default/css/style.css">
		<link type="text/css" rel="stylesheet" href="templates/default/css/dark-style.css">		
        <link type="text/css" rel="stylesheet" href="templates/default/css/color.css">
        <link rel="shortcut icon" href="templates/default/images/favicon.ico">
    </head>
    <body>
        <div class="main-loader-wrap">
            <div class="loader-spin"><span></span></div>
            <div class="loader-dec"></div>
        </div>
        <div id="main">
            <div class="progress-bar-wrap">
                <div class="progress-bar"></div>
            </div>
            <header class="main-header">
                <div class="logo-holder">
                    <a href="index.php" class="ajax"><img src="templates/default/images/logo.png" alt=""></a>
                </div>
                <div class="breadcrumb-wrap">
                    <span></span>
                </div>
                <div class="nav-button-wrap vis-menbut">
                    <div class="nav-button">
                        <span></span><span></span><span></span>
                    </div>
                </div>
                <div class="share-button show-share">
                    <i class="fa fa-bullhorn"></i><span>Share</span>
                </div>
            </header>
			<?php
			include 'menu.php';
			?> 
            <div id="wrapper">
                <div class="content-holder" data-pagetitle="<?=ucfirst($var->link);?>">
                    <div class="content">
                        <?php
						if ($var->fullwide === true):
						?>
                        <div class="column-content">
                            <section>
								<div class="wrap-inner fl-wrap">
                                    <div class="container">
										<?php echo $var->page; ?>
									</div>
								</div>
                            </section>
                        </div>
						<?php
						elseif (strtolower($var->link) == 'news' && $var->fullwide !== true):
						?>
                        <div class="column-content">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="post-container fl-wrap">
                                        <section>
                                            <div class="wrap-inner fl-wrap">
                                                <div class="container">
                                                <?php
                                                echo $var->page;
                                                ?>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="main-sidebar fixed-bar fl-wrap">
                                        <div class="widget-sidebar ws_column">
                                            <?php
                                            if (isset($var->widgets['right'])):
                                                foreach ($var->widgets['right'] as $title => $content):
                                                    echo $content['view'];
                                                endforeach;
                                            endif
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        else:
                        ?>
                        <div class="column-content">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="wrap-inner fl-wrap">
                                    <?php
                                    echo $var->page;
                                    ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                <?php
                                if (isset($var->widgets['right'])):
                                    foreach ($var->widgets['right'] as $title => $content):
                                        echo $content['view'];
                                    endforeach;
                                endif
                                ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        endif;
                        ?>
                    </div>
                    <footer class="main-footer fl-wrap">
                        <div class="footer-wrap fl-wrap">
                            <div class="footer-inner">
                                <div class="row">
                                    <div class="col-md-7">
                                        <h3>Subscribe on our updates</h3>
                                        <div class="subcribe-form fl-wrap">
                                            <form id="subscribe">
                                                <div class="shadow-box fl-wrap">
                                                    <input class="enteremail" name="email" id="subscribe-email" placeholder="Your Email" spellcheck="false" type="text">
                                                    <button type="submit" id="subscribe-button" class="subscribe-button">Submit</button>
                                                </div>
                                                <label for="subscribe-email" class="subscribe-message"></label>
                                            </form>
                                        </div>
                                    </div>
                                </div>
								<div class="policy-box fl-wrap">
									<span>&#169;Bel-CMS 2015&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?=date("d-m-Y H:i:s");?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;All rights reserved.&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
									<?php
									echo "<a href='#'>Page générée en <span class='belcms_genered'></span> secondes.</a>";
									?></span>
								</div>
                                <a class="to-top"><span>Back to Top</span><i class="fas fa-caret-up"></i></a>
                            </div>
                            <div class="footer-decor">
                            </div>
                        </div>
                    </footer>
                    <div class="share-wrapper">
                        <div class="share-container isShare"></div>
                    </div>
                </div>
            </div>
            <div class="circle-bg">
                <div class="middle-circle"></div>
                <div class="big-circle"></div>
                <div class="small-circle"></div>
            </div>
            <div class="element">
                <div class="element-item"></div>
            </div>
        </div>
        <?=$var->javaScript;?>
        <script  src="templates/default/js/plugins.js"></script>
        <script  src="templates/default/js/scripts.js"></script>
		<div id="endloading">
		<?php
		$time = (microtime(true) - $_SESSION['SESSION_START']);
		echo round($time, 3);?>
		</div>
		<script>
			$(window).on('load', function() {
				var endloading = $('#endloading').text();
				$('.belcms_genered').append(endloading);
			});
        function bookmark(){
            var url = "https://bel-cms.dev";
            var title = "SiteW.com";      
            if (window.sidebar) {window.sidebar.addPanel(title, url, "");} else if( window.external ) { window.external.AddFavorite( url, title);}
            return false
        }
    </script>
    </body>
</html>