<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="/app/static/css/style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" type="image/x-icon" href="/app/static/img/favicon.ico">
		<title>Ошибка | PHP ERROR</title>
	</head>
	<body>

		<?php require_once(__DIR__."/../layouts/header.php"); ?>

		<main class="error">
			<section class="error__header-section">
				<div class="error__background">
					<div class="error__content"></div>
				</div>
			</section>
			<section class="error__main-section">
				<div class="error__container">
					<p><?php echo $error; ?></p>
				</div>
			</section>
		</main>

		<script src="/app/static/scripts/js/scripts.js"></script>

	</body>
</html>