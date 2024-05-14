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
            <p>Votre compte a bien été créé, mais n'a pas été vérifié par email, veuillez regarder dans vos e-mails "possible spam" pour valider votre compte.</p>
            <form action="index.php?valid=form" method="post">
                <div>
                    <label for="mail">Votre é-mail d'enregistrement :</label>
                    <input id="mail" type="email" name="validation_mail" value="" placeholder="Votre é-mail d'enregistrement" required>
                </div>
                <div>
                    <label for="code">Le code de validation :</label>
                    <input id="code" type="text" name="validation_code" value="" placeholder="Le code de validation" required>
                </div>
                <input id="submit" type="submit" value="Soumettre">
            </form>
            <?php 
            if (isset($data) and $data != false):
            ?>
            <div id="notification"><?=$data;?></div>
            <script language="JavaScript">
                setTimeout(function () {
                    window.location.href = "index.php"; 
                }, 2500);
            </script>
            <?php
            else:
            ?>
            <a id="delete" href="index.php?valid=delUser">Effacer mon compte (c'est irréversible).</a>
            <a id="resend" href="index.php?valid=resend">Envoyé un nouveau code de validation.</a>
            <?php
            endif;
            ?>
        </div>
    </main>
    <footer>
        design and copyright in <a href="https://bel-cms.dev">https://bel-cms.dev</a> 2024
    </footer>
</body>
</html>