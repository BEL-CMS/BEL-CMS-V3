<!DOCTYPE html>
<html lang="fr">
<head>
	<title><?=$_SESSION['CONFIG_CMS']['CMS_WEBSITE_NAME'];?> | Coming Soon</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="/maintenance/tpl/images/icons/favicon.ico">
	<link rel="stylesheet" type="text/css" href="/maintenance/tpl/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/plugins/fontawesome-6.4.2/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="/maintenance/tpl/vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="/maintenance/tpl/css/main.css">
	<link rel="stylesheet" type="text/css" href="/maintenance/tpl/css/util.css">
	<link type="text/plain" rel="author" href="/maintenance/tpl/humans.txt">
</head>
<body>
	<div class="simpleslide100">
		<div class="simpleslide100-item bg-img1" style="background-image: url('/maintenance/tpl/images/bg01.jpg');"></div>
		<div class="simpleslide100-item bg-img1" style="background-image: url('/maintenance/tpl/images/bg02.jpg');"></div>
		<div class="simpleslide100-item bg-img1" style="background-image: url('/maintenance/tpl/images/bg03.jpg');"></div>
	</div>
	<div class="size1 overlay1">
		<div class="size1 flex-col-c-m p-l-15 p-r-15 p-t-50 p-b-50">
			<h3 class="l1-txt1 txt-center p-b-25">
				<?=$unavailable->title;?>
			</h3>

			<p class="m2-txt1 txt-center p-b-48" id="desc">
				<?=$unavailable->description?>
			</p>
		</div>
	</div>
	<footer>Popuslé par <a href="https://bel-cms.dev">Bel-CMS V3</a></footer>
	<script src="/assets/js/jQuery/jquery-3.7.1.min.js"></script>
	<script src="assets/plugins/tooltip/popper.min.js"></script>
	<script src="/maintenance/tpl/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="/maintenance/tpl/js/main.js"></script>
</body>
</html>