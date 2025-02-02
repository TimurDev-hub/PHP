<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="/app/static/css/style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" type="image/x-icon" href="/app/static/img/favicon.ico">
		<title><?php echo $userData['name']; ?> | АТП Транссервис</title>
	</head>
	<body>

		<?php require_once(__DIR__."/../layouts/header.php"); ?>

		<main class="profile">
			<section class="profile__header-section">
				<div class="profile__header-background">
					<div class="profile__header-container">
						<div class="profile__user-content">
							<h1>Добро пожаловать, <wbr> <?php echo $userData['name']; ?></h1>
						</div>
					</div>
				</div>
			</section>
			<section class="profile__main-section">
				<div class="profile__main-container">
					<div class="profile__user-bar">
						<form action="/profile" method="post" target="_self" class="profile__inputs-form">
							<label class="profile__inputs-form--line-container">
								Имя:
								<input type="text" name="username" value="<?php echo $userData['name']; ?>" required maxlength="40">
							</label>
							<label class="profile__inputs-form--line-container">
								Почта:
								<input type="email" name="email" value="<?php echo $userData['email']; ?>" required maxlength="40">
							</label>
							<input type="text" name="saveUserData" value="true" hidden>
							<input type="submit" value="Сохранить" class="save-button">
						</form>
						<form action="/profile" method="post" target="_self" class="profile__inputs-form">
							<input type="text" name="out" value="out" hidden>
							<input type="submit" value="Выйти" class="out-button">
						</form>
						<div class="profile__process-messages">
							<?php echo $renameStatus ?? null; ?>
						</div>
					</div>
					<?php if (isset($_SESSION['admin'])): ?>
						<div class="admin__controlbar">
							<h2>Редактировать маршрут</h2>
							<form action="/profile" method="post" class="admin__controlbar-form--search">
								<input type="text" name="routeId" placeholder="id маршрута" required maxlength="5" class="search__input">
								<input type="submit" value="Найти" class="search__submit">
							</form>
							<form action="/profile" method="post" class="admin__controlbar-form">
								<input type="text" name="rName" placeholder="Рейс" required maxlength="40" class="input-normal" value="<?php echo $routeService['route'][0]['c_route'] ?? null ?>">
								<span class="controlbar__inputs-group">
									<input type="text" name="rNum" placeholder="Номер" required maxlength="10" class="input-normal__short" value="<?php echo $routeService['route'][0]['c_num'] ?? null ?>">
									<input type="text" name="rTime" placeholder="Отправление" required maxlength="20" class="input-normal__short" value="<?php echo $routeService['route'][0]['c_time'] ?? null ?>">
								</span>
								<span class="controlbar__inputs-group">
									<input type="text" name="rPrice" placeholder="Цена" required maxlength="10" class="input-normal__short" value="<?php echo $routeService['route'][0]['c_price'] ?? null ?>">
								</span>
								<input type="text" name="updateRoute" value="<?php echo $routeService['route'][0]['id'] ?? null ?>" hidden>
								<input type="submit" value="Изменить" class="save-button">
							</form>
							<form action="/profile" method="post" class="admin__controlbar-form">
								<input type="text" name="deleteRoute" value="<?php echo $routeService['route'][0]['id'] ?? null ?>" hidden>
								<input type="submit" value="Удалить" class="delete-button">
							</form>
							<div class="global__messages-container">
								<?php echo $routeService['delete'] ?? null; echo $routeService['update'] ?? null; ?>
							</div>
						</div>
						<div class="admin__controlbar">
							<h2>Добавить маршрут</h2>
							<form action="/profile" method="post" enctype="multipart/form-data" class="admin__controlbar-form">
								<input type="file" name="setImg" required class="form__file">
								<input type="text" name="setRoute" placeholder="Рейс" required maxlength="35" class="input-normal">
								<span class="controlbar__inputs-group">
									<input type="text" name="setNum" placeholder="Номер" required maxlength="10" class="input-normal__short">
									<input type="text" name="setTime" placeholder="Отправление" required maxlength="20" class="input-normal__short">
								</span>
								<span class="controlbar__inputs-group">
									<input type="text" name="setPrice" placeholder="Цена" required maxlength="15" class="input-normal__short">
								</span>
								<input type="text" name="pushRoute" value="true" hidden>
								<input type="submit" value="Добавить" class="save-button">
							</form>
							<div class="profile__process-messages">
								<?php echo $routeService['push'] ?? null; ?>
							</div>
						</div>
					<?php else: ?>
						<div class="user__routebar">
							<h2>Действия</h2>
						</div>
					<?php endif; ?>
				</div>
			</section>
		</main>

		<script src="/app/static/scripts/js/scripts.js"></script>

	</body>
</html>