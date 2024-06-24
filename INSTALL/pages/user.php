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
<form action="index.php?page=finish" method="post">
    <div id="main_content">
        <h1>Inscription du 1ᵉʳ utilisateur</h1>
        <div class="main_content">
            <div class="row_table">
                <label>Nom d'utilisateur</label>
                <input type="text" name="username" required="required"  placeholder="Minimum 3 caractère *sans espace">
            </div>
            <div class="row_table">
                <label>Mot de passe</label>
                <input type="password" placeholder="Minimum 6 caractère" maxlength="32" minlength=”6″ name="password" required="required">
            </div>
            <div class="row_table">
                <label>E-Mail</label>
                <input type="mail" name="mail" required="required">
            </div>
        </div>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-end">
                <li class="page-item">
                    <a class="page-link" href="index.php?page=install">Précédant</a>
                </li>
                <li class="page-item">
                    <button type="submit" class="page-link">Enregister</a>
                </li>
            </ul>
        </nav>
        <progress max="100" value="90">90%</progress>
        <i class="pourcent">90%</i>
    </div>
</form>