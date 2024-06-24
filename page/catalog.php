<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'murchalka');
// Проверка на ошибки подключения к базе данных
if ($db == false) {
	echo "<script>alert('Ошибка подключения к базе данных');</script>";
	exit(); // Прекращаем выполнение скрипта, так как база недоступна
}
$pets = mysqli_query($db, "SELECT * FROM `pets` WHERE `status` != 'усыновлен';");
$kind = $_GET['kind'] ?? '';
$floor = $_GET['floor'] ?? '';
if (isset($_GET['none_filter'])) {
	$kind = '';
	$floor = '';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="../src/scss/style.css" />
	<link rel="icon" href="../src/image/loolgo.png" />
	<title>Каталог животных</title>
</head>

<body>
	<header class="header">
		<div class="container header__container">
			<nav class="header__nav">
				<a class="logo header__nav-logo" href="../index.html">
					<img src="../src/image/logo.svg" alt="logo" class="logo-img header__nav-logo-img" />
					<p class="logo-text header__nav-logo-text">мурчалка</p>
				</a>
				<ul class="header__nav-menu">
					<li class="header__nav-menu-item">
						<a href="./catalog.php" class="header__nav-menu-link underline">Каталог животных</a>
					</li>
					<li class="header__nav-menu-item">
						<a href="./about.html" class="header__nav-menu-link underline">о нас</a>
					</li>
					<li class="header__nav-menu-item">
						<a href="./FAQ.html" class="header__nav-menu-link underline">FAQ</a>
					</li>
					<li class="header__nav-menu-item">
						<a href="./contacts.html" class="header__nav-menu-link underline">контакты</a>
					</li>
					<li class="header__nav-menu-item">
						<a href="./help.html" class="header__nav-menu-link underline">помочь приюту</a>
					</li>
					<li class="header__nav-menu-item userAuth">
						<a href="./account.php" class="header__nav-menu-link"><img src="../src/image/user.svg" alt="user" class="header__nav-menu-link-img" /></a>
					</li>
				</ul>
				<div class="header__burger">
					<span class="header__burger-bar"></span>
					<span class="header__burger-bar"></span>
					<span class="header__burger-bar"></span>
				</div>
				<nav class="header__nav-mobile">
					<ul class="header__nav-mobile-menu">
						<li class="header__nav-mobile-menu-item">
							<a href="./catalog.php" class="header__nav-mobile-menu-link underline">Каталог животных</a>
						</li>
						<li class="header__nav-mobile-menu-item">
							<a href="./about.html" class="header__nav-mobile-menu-link underline">о нас</a>
						</li>
						<li class="header__nav-mobile-menu-item">
							<a href="./FAQ.html" class="header__nav-mobile-menu-link underline">FAQ</a>
						</li>
						<li class="header__nav-mobile-menu-item">
							<a href="./contacts.html" class="header__nav-mobile-menu-link underline">контакты</a>
						</li>
						<li class="header__nav-mobile-menu-item">
							<a href="./help.html" class="header__nav-mobile-menu-link underline">помочь приюту</a>
						</li>
						<li class="header__nav-mobile-menu-item">
							<a href="./account.php" class="header__nav-mobile-menu-link underline">Личный кабинет</a>
						</li>
					</ul>
				</nav>
			</nav>
		</div>
	</header>
	<main>
		<section class="info">
			<div class="container info__container">
				<h1 class="info__greeting">
					Добро пожаловать в каталог животных приюта
					<span class="red">"МУРЧАЛКА"</span>! Здесь вы можете познакомиться с
					нашими подопечными и найти себе нового верного друга.
				</h1>
				<div class="info__block">
					<p class="info__block-text">
						Выберите себе питомца по фильтрам на странице или доверьтесь
						судьбе, а кураторы познакомят вас лично и помогут в период
						адаптации дома. А если вы затрудняетесь с выбором, расскажите нам,
						кого вы ищите и мы подберём животных, которые могут вам подойти.
						Все животные привиты, стерилизованы и чипированы.
					</p>
					<div class="info__block-filter">
						<p class="info__block-filter-text">кого вы ищите?</p>
						<div class="info__block-filter-buttons">
							<button class="info__block-filter-buttons-btn <?php echo $kind == 'к' ? 'active' : ''; ?>" onclick="location.href='<?php echo "?kind=к&floor=$floor"; ?>'">Кошка</button>

							<button class="info__block-filter-buttons-btn <?php echo $kind == 'с' ? 'active' : ''; ?>" onclick="location.href='<?php echo "?kind=с&floor=$floor"; ?>'">Собака</button>
						</div>
						<p class="info__block-filter-text">пол</p>
						<div class="info__block-filter-buttons">
							<button class="info__block-filter-buttons-btn <?php echo $floor == 'девочка' ? 'active' : ''; ?>" onclick="location.href='<?php echo "?kind=$kind&floor=девочка"; ?>'">Девочка</button>
							<button class="info__block-filter-buttons-btn <?php echo $floor == 'мальчик' ? 'active' : ''; ?>" onclick="location.href='<?php echo "?kind=$kind&floor=мальчик"; ?>'">Мальчик</button>
						</div>
						<button class="info__block-filter-buttons-btn none_filter" onclick="location.href='<?php echo $_SERVER['PHP_SELF']; ?>'">Очистить</button>
					</div>
				</div>
			</div>
		</section>
		<section class="pets">
			<div class="pets__container container">
				<?php
				while ($card = mysqli_fetch_assoc($pets)) {
					if (empty($kind) && empty($floor)) {
						// выводим все карточки, если кнопки не нажаты
				?>
						<a href="./pet.php?id=<?= $card['ID_pets'] ?>" class="pets__link">
							<div class="pets__link-card">
								<img src="../src/image/pet/<?php echo $card['photo'] ?>" alt="pet" class="pets__link-card-img" />
								<p class="pets__link-card-name"><?php echo $card['name'] ?></p>
								<p class="pets__link-card-year"><?php echo $card['age'] ?></p>
							</div>
						</a>
						<?php
					} elseif (!empty($kind) && $card['kind'] == $kind) {
						if (!empty($floor) && $card['floor'] == $floor) {
							// выводим карточки с выбранным kind и floor
						?>
							<a href="./pet.php?id=<?= $card['ID_pets'] ?>" class="pets__link">
								<div class="pets__link-card">
									<img src="../src/image/pet/<?php echo $card['photo'] ?>" alt="pet" class="pets__link-card-img" />
									<p class="pets__link-card-name"><?php echo $card['name'] ?></p>
									<p class="pets__link-card-year"><?php echo $card['age'] ?></p>
								</div>
							</a>
							<?php
						} elseif (!empty($floor)) {
							// выводим карточки с выбранным floor
							if ($card['floor'] == $floor) {
							?>
								<a href="./pet.php?id=<?= $card['ID_pets'] ?>" class="pets__link">
									<div class="pets__link-card">
										<img src="../src/image/pet/<?php echo $card['photo'] ?>" alt="pet" class="pets__link-card-img" />
										<p class="pets__link-card-name"><?php echo $card['name'] ?></p>
										<p class="pets__link-card-year"><?php echo $card['age'] ?></p>
									</div>
								</a>
							<?php
							}
						} elseif (!empty($kind)) {
							// выводим карточки с выбранным kind
							?>
							<a href="./pet.php?id=<?= $card['ID_pets'] ?>" class="pets__link">
								<div class="pets__link-card">
									<img src="../src/image/pet/<?php echo $card['photo'] ?>" alt="pet" class="pets__link-card-img" />
									<p class="pets__link-card-name"><?php echo $card['name'] ?></p>
									<p class="pets__link-card-year"><?php echo $card['age'] ?></p>
								</div>
							</a>
				<?php
						}
					}
				}
				?>
			</div>
		</section>
	</main>
	<footer class="footer">
		<div class="container footer__container">
			<div class="footer__links">
				<a class="logo footer__links-logo" href="#">
					<img src="../src/image/logo.svg" alt="logo" class="logo-img footer__links-logo-img" />
					<p class="logo-text footer__links-logo-text">мурчалка</p>
				</a>
				<div class="footer__links-socials">
					<a href="https://vk.com/club226305002" class="footer__links-socials-img">
						<img src="../src/image/vk.png" alt="vk" class="footer__links-socials-img-vk" />
					</a>
					<a href="#" class="footer__links-socials-img">
						<img src="../src/image/tg.png" alt="vk" class="footer__links-socials-img-tg" />
					</a>
				</div>
			</div>
			<div class="footer__block">
				<div class="footer__block-items">
					<a href="./catalog.php" class="footer__block-items-text underline">Каталог животных <br /></a><a href="./about.html" class="footer__block-items-text underline">о нас</a>
				</div>
				<div class="footer__block-items footer__block-items2">
					<a href="./FAQ.html" class="footer__block-items-text underline">FAQ<br /></a><a href="./contacts.html" class="footer__block-items-text underline">контакты</a>
				</div>
				<div class="footer__block-items">
					<a href="./help.html" class="footer__block-items-text underline">помочь приюту</a><a href="./account.php" class="footer__block-items-text underline">Личный кабинет</a>
				</div>
				<div class="footer__block-items">
					<p class="footer__block-items-text">Телефон для связи:</p>
					<p class="footer__block-items-text">+7 (123) 456-78-90</p>
				</div>
				<div class="footer__block-items">
					<p class="footer__block-items-text">Адрес:</p>
					<p class="footer__block-items-text">
						г. Москва, ул. Лесная, д. 15, стр. 3
					</p>
				</div>
			</div>
			<p class="footer__rights">
				© 2024 ООО “МУРЧАЛКА”.
				<span class="footer__rights-text">Все права защищены.</span>
			</p>
		</div>
	</footer>
	<script>
		const menuBtn = document.querySelector('.header__burger');
		const menu = document.querySelector('.header__nav-mobile');
		const modileLinks = document.querySelectorAll(
			'.header__nav-mobile-menu-link'
		);

		menuBtn.addEventListener('click', () => {
			menuBtn.classList.toggle('active');
			if (!menuBtn.classList.contains('active')) {
				menu.classList.remove('show');
			} else {
				menu.classList.add('show');
			}
		});

		modileLinks.forEach(link => {
			link.addEventListener('click', () => {
				menuBtn.classList.remove('active');
				menu.classList.remove('show');
			});
		});
	</script>
	<script type="module" src="../src/js/main.js"></script>
</body>

</html>