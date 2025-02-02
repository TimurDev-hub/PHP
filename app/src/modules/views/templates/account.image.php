<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="/app/static/css/style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" type="image/x-icon" href="/app/static/img/favicon.ico">
		<title>Аккаунт | АТП Транссервис</title>
	</head>
	<body>

		<?php require_once(__DIR__."/../layouts/header.php"); ?>

		<main class="account">
			<section class="account__header-section">
				<div class="account__header-background">
					<div class="account__header-content"></div>
				</div>
			</section>
			<section class="account__main-section">
				<div class="account__main-container login-container">
					<h2>ВОЙТИ В АККАУНТ</h2>
					<form action="/account" method="post" class="account__inputs-form">
						<input type="text" name="username" placeholder="Введите имя" maxlength="16" required>
						<input type="email"name="email" placeholder="Введите почту" maxlength="32" required>
						<input type="password" name="password" placeholder="Введите пароль" maxlength="16" required>
						<input type="text" name="process" value="login" hidden>
						<input type="submit" value="Вход">
					</form>
					<div class="global__messages-container">
						<?php echo $authStatus['login'] ?? null; ?>
					</div>
				</div>
				<div class="account__main-container registration-container">
					<h2>НЕТ АККАУНТА?</h2>
					<form action="/account" method="post" class="account__inputs-form">
						<input type="text" name="username" placeholder="Придумайте имя" maxlength="16" required>
						<input type="email" name="email" placeholder="Укажите почту" maxlength="32" required>
						<input type="password" name="password" placeholder="Придумайте пароль" maxlength="16" required>
						<input type="text" name="process" value="registration" hidden>
						<input type="submit" value="Регистрация">
					</form>
					<div class="global__messages-container">
						<?php echo $authStatus['registration'] ?? null; ?>
					</div>
				</div>
			</section>
		</main>

		<script defer src="/app/static/scripts/js/scripts.js"></script>

	</body>
</html>