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
<form action="index.php?page=install" method="post">
    <div id="main_content">
        <h1>Connexion a la base de donnée</h1>
        <div class="main_content">
            <div class="row_table">
                <label>Il s'agit ici de l'adresse du serveur MySQL de votre hébergement. </label>
                <input type="text" value="localhost" name="serversql" required="required">
            </div>
            <div class="row_table">
                <label>Le prefix permet d'installer plusieurs fois BEL-CMS. </label>
                <input type="text" value="belcms_" name="prefix" required="required">
            </div>
            <div class="row_table">
                <label>Il s'agit du port utiliser de votre base de donnée MySQL.</label>
                <input type="text" value="3306" name="port" required="required">
            </div>
            <div class="row_table">
                <label>Il s'agit du nom de votre base de données MySQL.</label>
                <input type="text" value="" name="name" required="required">
            </div>
            <div class="row_table">
                <label>Il s'agit de votre identifiant qui vous permet de vous connecter à votre base MySQL.</label>
                <input type="text" value="root" name="user" required="required">
            </div>
            <div class="row_table">
                <label>Il s'agit du mot de passe, qui vous permet de vous connecter à votre base de donnée MySQL.</label>
                <input type="password" name="password">
            </div>
        </div>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-end">
                <li class="page-item">
                    <a class="page-link" href="index.php?page=check">Précédant</a>
                </li>
                <li class="page-item">
                    <button type="submit" class="page-link">Suivant</a>
                </li>
            </ul>
        </nav>
        <progress max="100" value="35">50%</progress>
        <i class="pourcent">50%</i>
    </div>
</form>