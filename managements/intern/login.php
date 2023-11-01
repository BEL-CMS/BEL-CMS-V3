<!doctype html>
<html lang="fr">
	<head>
		<link href="/pages/user/css/login.css" rel="stylesheet">
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="/managements/intern/login.js"></script>
	</head>
	<body id="LoginForm">
		<div class="container">
			<div id="login-management" class="login-form">
				<div id="loading">
					<img src="/assets/img/loader_9.png" id="loadspinner"></img>
					<span></span>
				</div>
				<div class="main-div">
					<div class="panel">
						<h2><?=constant('LOGIN_ADMIN');?></h2>
						<p id="message_login"><?=constant('MAIL_PASS_PRIVATE');?></p>
					</div>
					<form id="sendLogin" action="Login?management" method="post">
						<div class="form-group">
							<input name="umal" required="required" autofocus="" type="text" class="form-control" id="inputEmail" placeholder="Enter private email">
						</div>
						<div class="form-group">
							<input name="passwrd" required="required" type="password" class="form-control" id="inputPassword" placeholder="Password">
						</div>
						<button type="submit" class="btn btn-primary"><?=constant('LOGIN');?></button>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>