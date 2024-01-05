<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
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
?>
<section id="belcms_section_faq">
    <h2><?=constant('GET_YOU_QUESTION');?></h2>
    <i><?=constant('FIND_ANSWERS_SEARCH');?></i>
    <input type="search" id="site_search" placeholder="Rechecher">
    <div id="belcms_section_faq_cat">
        <ul>
            <li class="active"><a class="faq_answer" id="faq_1"><i class="fa-solid fa-circle-question"></i>&ensp;Catégorie 1</a></li>
            <li><a class="faq_answer" id="faq_2"><i class="fa-solid fa-circle-question"></i>&ensp;Catégorie 2</a></li>
            <li><a class="faq_answer" id="faq_3"><i class="fa-solid fa-circle-question"></i>&ensp;Catégorie 3</a></li>
        </ul>
        <div id="belcms_section_faq_content">
            <div class="active" id="faq_1_active">
                <div class="bel_cms_accordion">
                    <h3>Section 1</h3>
                    <div>
                        <p>
                        Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer
                        ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit
                        amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
                        odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
                        </p>
                    </div>
                    <h3>Section 2</h3>
                    <div>
                        <p>
                        Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet
                        purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor
                        velit, faucibus interdum tellus libero ac justo. Vivamus non quam. In
                        suscipit faucibus urna.
                        </p>
                    </div>
                </div>
            </div>
            <div id="faq_2_active">
                <div class="bel_cms_accordion">
                    <h3>Section 1</h3>
                    <div>
                        <p>
                        Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer
                        ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit
                        amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
                        odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
                        </p>
                    </div>
                    <h3>Section 2</h3>
                    <div>
                        <p>
                        Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet
                        purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor
                        velit, faucibus interdum tellus libero ac justo. Vivamus non quam. In
                        suscipit faucibus urna.
                        </p>
                    </div>
                </div>
            </div>
            <div id="faq_3_active">
                <div class="bel_cms_accordion">
                    <h3>Section 1</h3>
                    <div>
                        <p>
                        Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer
                        ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit
                        amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
                        odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
                        </p>
                    </div>
                    <h3>Section 2</h3>
                    <div>
                        <p>
                        Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet
                        purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor
                        velit, faucibus interdum tellus libero ac justo. Vivamus non quam. In
                        suscipit faucibus urna.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>