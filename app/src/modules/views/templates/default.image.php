<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="/app/static/css/style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" type="image/x-icon" href="/app/static/img/favicon.ico">
		<title>Главная | АТП Транссервис</title>
	</head>
	<body>

		<?php require_once(__DIR__."/../layouts/header.php"); ?>

		<main class="default">
			<section class="defaul__header-section">
				<div class="default__background">
					<div class="default__container">
						<div class="default__title">
							<p>У нас самые дешёвые автобусные билеты</p>
						</div>
						<div class="default__routes-menu">
							<form action="" method="get" class="default__inputs-form">
								<input class="input-start" type="text" placeholder="Откуда" required>
								<input type="text" placeholder="Куда" required>
								<input type="date" placeholder="Когда" required>
								<input class="input-finish" type="date" placeholder="Обратно">
							</form>
						</div>
						<div class="default__search-block">
							<p>Выберите нужные параметры и приступайте к поиску:</p>
							<button type="submit">Найти билет!</button>
						</div>
					</div>
				</div>
			</section>
			<section class="default__main-section">
				<div class="default__container">
					<?php if (is_array($cards)): ?>
						<?php foreach($cards as $card): ?>
							<div class="card">
								<img class="card__header-img" src="<?php echo $card['c_img'] ?? null ?>" alt="#">
								<div class="card__container">
									<p class="card__text">
										Рейс: <?php echo $card['c_route'] ?? null; ?>
									</p>
									<p class="card__text">
										Номер маршрута: <?php echo $card['c_num'] ?? null; ?>
									</p>
									<p class="card__text">
										Отправление: <?php echo $card['c_time'] ?? null; ?>
									</p>
									<p class="card__text">
										Цена: <?php echo $card['c_price'] ?? null; ?>
									</p>
									<form class="card__button-wrapper" action="/default" method="post">
										<input name="ticketId" type="text" value="<?php echo $card['id'] ?? null; ?>" hidden required>
										<button type="submit" class="card__button">Купить!</button>
									</form>
									<?php if (isset($_SESSION['admin'])): ?>
										<p>Id: <?php echo $card['id'] ?? null; ?></p>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
					<?php else: ?>
						<?php echo $cards; ?>
					<?php endif; ?>
				</div>
			</section>
		</main>

		<?php require_once(__DIR__."/../layouts/footer.php"); ?>

		<script src="/app/static/scripts/js/scripts.js"></script>

	</body>
</html>