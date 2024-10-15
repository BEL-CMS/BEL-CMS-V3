<!-- wrapper -->
<div id="wrapper">
    <!-- fixed-column-image -->
    <div class="fixed-column-image-wrap">
        <div class="fixed-column-image fs-wrapper">
            <div class="bg hor_scroll" data-bg="templates/cyberbook/images/bg/book-page.png"></div>
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
        <div class="fci_progress-bar-wrap fci_progress-bar-wrap2 dark-bg">
            <div class="mousey-wrap">
                <div class="mousey">
                    <div class="scroller"></div>
                </div>
            </div>
            <div class="ver_progress-bar_wrap">
                <div class="ver_progress-bar color-bg"></div>
            </div>
            <div class="pbw_animicon">
                <i class="fas fa-caret-down"></i>
            </div>
        </div>
        <div class="hero-arrows_dec"></div>
    </div>
    <!-- fixed-column-image end -->				 
    <!-- column-wrap -->
    <div class="column-wrap">
        <div class="content fl-wrap full-height">
            <!-- section -->
            <section id="sec1">
                <div class="container">
                    <div class="fl-wrap text-block gray-bg">
                        <div class="clearfix"></div>
                        <?php
                            echo $var->page;
                        ?>
                    </div>
                    <div class="clearfix"></div> 									
                </div>
                <div class="section-number"><?=$var->link;?></div>
                <div class="dec_cirlce" style="left: -120px; bottom: 350px"><span></span></div>
                <div class="dec_cirlce" style="right: -120px; top: 350px"><span></span></div>
                <div class="sec-lines"></div>
            </section>
        </div>
    </div>

    <div class="height-emulator fl-wrap"></div>
    <!-- footer end -->
</div>
<!-- wrapper end -->