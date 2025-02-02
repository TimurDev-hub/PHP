
<header class="header">
	<div class="header__container">
		<div class="header__title">
			<p>АТП Транссервис</p>
		</div>
		<nav class="header__navbar">
			<?php foreach ($navbarLinks as $routeLink): ?>
				<span class="header__navbar-item">
					<?php echo $routeLink; ?>
				</span>
			<?php endforeach; ?>
		</nav>
		<button class="header__burger-button" id="header__burger-button">
			<span class="header__burger-line"></span>
			<span class="header__burger-line"></span>
			<span class="header__burger-line"></span>
		</button>
	</div>
</header>
