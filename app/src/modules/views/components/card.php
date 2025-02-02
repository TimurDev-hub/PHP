
<div class="card">
	<img class="card__header-img" src="<?php echo $card['c_img'] ?? null; ?>>" alt="#">
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
		<div class="card__button-wrapper">
			<button class="card__button">Купить!</button>
		</div>
	</div>
</div>
