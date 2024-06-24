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
        <form action="index.php?page=finish" method="post">
            <h1>Inscription du 1ᵉʳ utilisateur</h1>
            <div class="main_content">
                <div class="row_table">
                    <label>Nom d'utilisateur.</label>
                    <input type="text" value="" name="username" required="required" placeholder="Minimum 3 caractère *sans espace">
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
            <button class="btn btn-primary" type="submit">Enregistrer</button>
            <progress max="100" value="75">75%</progress>
            <i class="pourcent">75%</i>
        </form>
    </div>
</form>