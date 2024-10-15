<div id="wrapper" class="th_padding">
    <div class="hero-content full-height" id="sec1">
        <div class="fs-wrapper">
        <div class="video-holder-wrap">
                <div class="video-container">
                    <video autoplay playsinline loop muted  class="bgvid">
                        <source src="templates/cyberbook/video/1.mp4" type="video/mp4">
                    </video>
                </div>
            </div>
            <div class="fs-slider_align_title fsat_single">
                <div class="fs-slider_align_title_container">
                    <h2>Bel-CMS<br> <span>Système de gestion de contenu</span></h2>
                    <p style="text-align: justify;">Un système de gestion de contenu, souvent abrégé en CMS (Content Management System), est un logiciel qui aide les utilisateurs à créer, gérer et modifier du contenu sur un site Web sans avoir besoin de connaissances techniques spécialisées.</p>
                </div>
            </div>
            <div class="overlay"></div>
            <div class="hero-video_single">
                <div class="bg" data-bg="templates/cyberbook/images/bg/php_code.jpg"></div>
                <div class="overlay"></div>
                <a href="#sec2" class="custom-scroll-link start-btn_sin"><span> Start explore <i class="fal fa-long-arrow-down"></i></span></a>
            </div>
            <div class="showcase-dec_line sdl_top sdl_top2"></div>
        </div>
    </div>
    <div class="fixed-column-image-wrap">
        <div class="fixed-column-image fs-wrapper">
            <div class="bg hor_scroll"  data-bg="templates/cyberbook/images/bg/2.jpg"></div>
            <div class="overlay"></div>
            <div class="overlay-dec"></div>
        </div>
        <footer class="column-footer">
            <div class="column-footer_arrow-dec_wrap color-bg">
                <div class="arrow_dec_wrap">
                    <div class="arrow_dec"></div>
                </div>
            </div>
            <div class="column-footer_head">Scroll  Down</div>
            <div class="column-footer_content fl-wrap">
                <div class="column-footer_title"><span><?=$var->link;?></span></div>
            </div>
            <div class="dir-arrow"></div>
        </footer>
        <div class="fci_progress-bar-wrap dark-bg">
            <div class="ver_progress-bar_wrap">
                <div class="ver_progress-bar color-bg"></div>
            </div>
            <div class="pbw_animicon">
                <i class="fas fa-caret-down"></i>
            </div>
        </div>
        <div class="hero-arrows_dec"></div>
    </div>
    <div class="scroll-nav-container">
        <div class="page-scroll-nav">
            <div class="scroll-down-container">
                <div class="scroll-down-wrap">
                    <div class="mousey">
                        <div class="scroller"></div>
                    </div>
                </div>
            </div>
            <div class="hidden_wrap_btn"><span></span></div>

            <div class="section-counter color-bg">
                <div class="section-counter_cuurent"><span>01</span></div>
                <div class="section-counter_total"></div>
            </div>
        </div>
    </div>
    <div class="column-wrap hcw_sin">
        <div class="content fl-wrap full-height">
            <section id="sec2" class="scroll_sec">
                <div class="container">
                    <div class="section-title">
                        <h2>Notre dernière news</h2>
                        <p>Notre dernière nouveauté ou mise à jour du C.M.S ou tout simplement un petit mot important à dire.</p>
                    </div>
                    <?php
                        echo $var->page;
                    ?>
                </div>
                <div class="section-number"> <span>0</span>1. </div>
                <div class="sec-dec" style="left: -270px; bottom: -5%"></div>
                <div class="dec_cirlce" style="right: -120px; top: 350px"><span></span></div>
                <div class="sec-lines"></div>
            </section>

            <section class="no-padding">
                <div class="half-bg-wrap fl-wrap">
                    <div class="half-bg">
                        <div class="bg" data-bg="templates/cyberbook/images/bg/Statistics.png"></div>
                        <div class="overlay"></div>
                        <div class="half-bg_title">
                            <h2>Stati <br> stiques</h2>
                        </div>
                    </div>
                    <div class="half-bg-container dark-bg">
                        <div class="inline-facts-container">
                            <div class="container">
                                <div class="inline-facts-wrap">
                                    <div class="inline-facts">
                                        <div class="milestone-counter">
                                            <div class="stats animaper">
                                                <div class="num" data-content="0" data-num="<?=nbNews();?>">0</div>
                                            </div>
                                        </div>
                                        <h6>Nombre de News</h6>
                                    </div>
                                </div>
                                <div class="inline-facts-wrap">
                                    <div class="inline-facts">
                                        <div class="milestone-counter">
                                            <div class="stats animaper">
                                                <div class="num" data-content="0" data-num="<?=getNbPageView();?>">0</div>
                                            </div>
                                        </div>
                                        <h6>Nombre de page vu</h6>
                                    </div>
                                </div>
                                <div class="inline-facts-wrap">
                                    <div class="inline-facts">
                                        <div class="milestone-counter">
                                            <div class="stats animaper">
                                                <div class="num" data-content="0" data-num="<?=nbDl();?>">0</div>
                                            </div>
                                        </div>
                                        <h6>Nombre de téléchargements</h6>
                                    </div>
                                </div>
                                <div class="inline-facts-wrap">
                                    <div class="inline-facts">
                                        <div class="milestone-counter">
                                            <div class="stats animaper">
                                                <div class="num" data-content="0" data-num="<?=getNbArticles();?>">0</div>
                                            </div>
                                        </div>
                                        <h6>Nombre d'articles</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="half-bg-container_dec"></div>
                        <div class="chart-dec"><span><i class="fal fa-plus"></i></span></div>
                    </div>
                </div>
            </section>
            <section class="dec_sec" style="padding: 120px;">
                <div class="container" style="padding-bottom: 80px;">
                    <div class="cards-row">
                        <div class="card-item">
                            <div class="card-item-inner">
                                <div class="dec-icon act-link">
                                    <i class="fal fa-solid fa-water"></i>
                                </div>
                                <h3><i styl="font-size:11px">ASBL</i> ASEH</h3>
                                <p>Partenaire d'un club de sport, de piscine et de secourisme de l'est-Hainaut (Belgique) avec la participation de L.F.B.S avec a la clef un certificat de formation BBSA/BBSA</p>
                            </div>
                            <span class="testi-number color-bg">.01</span>										
                        </div>
                        <div class="card-item">
                            <div class="card-item-inner">
                                <div class="dec-icon  ">
                                    <i class="fal fa-headset"></i>
                                </div>
                                <h3>PalaceWaR</h3>
                                <p>Clan jeux vidéo existant depuis 2001 sur Alien versus prédator puis la série Battlefield.</p>
                            </div>
                            <span class="testi-number color-bg">.02</span>										
                        </div>
                        <div class="card-item">
                            <div class="card-item-inner">
                                <div class="dec-icon  ">
                                    <i class="fal fa-phone-laptop"></i>
                                </div>
                                <h3>Web-Help</h3>
                                <p>Site d'entraide sur tout ce qui touche le PC, aussi bien le code HTML/PHP/CSS/JS, que comment brancher un PC</p>
                            </div>
                            <span class="testi-number color-bg">.03</span>									
                        </div>
                        <div class="card-item">
                            <div class="card-item-inner">
                                <div class="dec-icon  ">
                                    <i class="fal fa-rocket"></i>
                                </div>
                                <h3>Le projet</h3>
                                <p>Le projet a été réalisé sans framework back-end, l'ensemble du code appartient à Bel-CMS, les template sont en général faits par boostrap qui se trouvent sur ThemeForest.</p>
                            </div>
                            <span class="testi-number color-bg">.04</span>									
                        </div>
                    </div>
                    <div class="order-wrap  dark-bg">
                        <h4>Prêt à rejoindre le projet ?</h4>
                        <a href="Contact" class="btn color-bg"><span>Entrer en contact</span></a>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="dec_cirlce" style="left: -120px; bottom: -120px"><span></span></div>
                <div class="dec_cirlce" style="right: -120px; top: 350px"><span></span></div>
                <div class="sec-lines"></div>
            </section>
        </div>
    </div>
</div>