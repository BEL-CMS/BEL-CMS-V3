<!DOCTYPE html>
<html lang="fr">
<head>
	<title><?=$_SESSION['CONFIG_CMS']['CMS_WEBSITE_NAME'];?> | Validation </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="/assets/css/validation.css">
</head>
<body>
    <main>
        <div id="main_valid">
            <img src="/assets/img/validation/login-icon-3061.png">
        </div>
        <div id="main_content">
            <h1>Compte Utilisateur</h1>
            <?php 
            if (!isset($data)):
            ?>
            <p>Votre compte a bien été créé, mais n'a pas été vérifié par email, veuillez regarder dans vos e-mails "possible spam" pour valider votre compte.</p>
            <form action="index.php" method="get">
                <div>
                    <label for="mail">Votre é-mail d'enregistrement :</label>
                    <input id="mail" type="email" name="validation_mail" value="" placeholder="Votre é-mail d'enregistrement" required>
                </div>
                <div>
                    <label for="code">Le code de validation :</label>
                    <input id="code" type="text" name="validation_code" value="" placeholder="Le code de validation" required>
                </div>
                <input type="hidden" name="valid" value="form">
                <input id="submit" type="submit" value="Soumettre">
            </form>
            <?php
            else: 
            ?>
            <textarea id="notification" disabled><?=$data;?>.<?=PHP_EOL; ?>Redirection automatique dans 5 secondes</textarea>
            <script language="JavaScript">
                setTimeout(function () {
                    window.location.href = "index.php"; 
                }, 5000);
            </script>
            <?php 
            endif;
            if (!isset($data)):
            ?>
            <a id="delete" href="index.php?valid=delUser">Effacer mon compte (c'est irréversible).</a>
            <a id="resend" href="index.php?valid=resend">Envoyé un nouveau code de validation.</a>
            <?php
            endif;
            ?>
        </div>
    </main>
    <footer>
        Design and Copyright in <a href="https://bel-cms.dev">Bel-CMS</a> <?=date('Y');?>
    </footer>
</body>
</html>