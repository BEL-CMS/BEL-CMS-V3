<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.5 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

 ?>
<div id="main_content">
    <h1>Vérification des droits de fichier (chmod 755)</h1>
    <div class="main_content">
        <ul id="check">
            <?php
            foreach (createDirAll() as $key => $value):
                echo $value;
            endforeach;
            ?>
        </ul>
    </div>
	<nav aria-label="Page navigation">
		<ul class="pagination justify-content-end">
			<li class="page-item">
				<a class="page-link" href="index.php?page=check">Précédant</a>
			</li>
			<li class="page-item">
				<a class="page-link" href="index.php?page=pdo">Suivant</a>
			</li>
		</ul>
	</nav>
	<progress max="100" value="40">40%</progress>
	<i class="pourcent">40%</i>
</div>