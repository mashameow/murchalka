<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'murchalka');
$pet_id = $_GET['id'];
$_SESSION['pet_id'] = $pet_id;
// Проверка на ошибки подключения к базе данных
if ($db == false) {
	echo "<script>alert('Ошибка подключения к базе данных');</script>";
	exit(); // Прекращаем выполнение скрипта, так как база недоступна
}
// Получаем данные о животном из базы данных
$pet_stmt = $db->prepare("SELECT * FROM pets WHERE ID_pets = ?");
$pet_stmt->bind_param("i", $pet_id);
$pet_stmt->execute();
$pet_result = $pet_stmt->get_result();

if ($pet_result->num_rows > 0) {
	$pet_data = $pet_result->fetch_assoc();

	$_SESSION['name'] = $pet_data['name'];
	$_SESSION['age'] = $pet_data['age'];
	$_SESSION['petPsge_floor'] = $pet_data['floor'];
	$_SESSION['history'] = $pet_data['history'];
	$_SESSION['features'] = $pet_data['features'];
	$_SESSION['photo'] = $pet_data['photo'];
} else {
	echo "<script>alert('Животное не найдено'); history.go(-1);</script>";
	exit(); // Прекращаем выполнение скрипта, так как животное не найдено
}


// Закрываем соединение с базой данных

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="../src/scss/style.css" />
	<link rel="icon" href="../src/image/loolgo.png" />
	<title class="pet-name"><?php echo $_SESSION['name'] ?></title>
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
		<section class="heroPet">
			<div class="heroPet__container container">
				<img src="../src/image/pet/<?php echo $_SESSION['photo'] ?>" alt="pet" class="heroPet__img" />
				<div class="heroPet__info">
					<div class="heroPet__info-name">
						<h1 class="heroPet__info-name-h1 pet-name"><?php echo $_SESSION['name'] ?></h1>
						<p class="heroPet__info-name-text year"><?php echo $_SESSION['age'] ?></p>
						<p class="heroPet__info-name-text gender"><?php echo $_SESSION['petPsge_floor'] ?></p>
					</div>
					<p class="heroPet__info-description history__pet">
						<?php echo $_SESSION['history'] ?>
					</p>
					<p class="heroPet__info-features">Особенности:</p>
					<p class="heroPet__info-description features__pet">
						<?php echo $_SESSION['features'] ?>
					</p>
					<?php
					if ($_SESSION['is_authenticated']) {
						if ($_SESSION['is_application'] && $_SESSION['ID_statusApp'] == 1) {
							if ($_SESSION['pet_id'] == $_SESSION['user_pet']) {
								echo '<p class="heroPet__info-features">Вы уже оставили заявку!</p>
          <a href="./account.php" class="accBtn">Посмотреть статус заявки</a>
          <a href="./catalog.php" class="accBtn applicationBtn">
          вернуться в каталог
          </a>';
							} else {
								echo '<button class="heroPet__info-btn applicationBtn" onclick="alert(\'У вас уже есть заявка в обработке\');">
          Оставить заявку на знакомство!
          </button>
          <a href="./catalog.php" class="accBtn applicationBtn">
          вернуться в каталог
          </a>';
							}
						} elseif ($_SESSION['is_application'] && $_SESSION['ID_statusApp'] == 2) {
							if ($_SESSION['pet_id'] == $_SESSION['user_pet']) {
								echo '<p class="heroPet__info-features">Вы уже оставили заявку!</p>
          <a href="./account.php" class="accBtn">Посмотреть статус заявки</a>
          <a href="./catalog.php" class="accBtn applicationBtn">
          вернуться в каталог
          </a>';
							} else {
								echo '<button class="heroPet__info-btn applicationBtn" onclick="document.querySelector(\'.application\').classList.remove(\'none\');">
          Оставить заявку на знакомство!
          </button>
          <a href="./catalog.php" class="accBtn applicationBtn">
          вернуться в каталог
          </a>';
							}
						} else {
							echo '<button class="heroPet__info-btn applicationBtn" onclick="document.querySelector(\'.application\').classList.remove(\'none\');">
          Оставить заявку на знакомство!
          </button>
          <a href="./catalog.php" class="accBtn">
          вернуться в каталог
          </a>';
						}
					} else {
						echo '<button class="heroPet__info-btn applicationBtn" onclick="{ alert(\'Сначала авторизуйтесь!\'); window.location.href = \'./account.php\'; }">
          Оставить заявку на знакомство!
          </button>
          <a href="./catalog.php" class="accBtn heroPet__info-btn">
          вернуться в каталог
          </a>';
					}

					?>

				</div>
			</div>
		</section>
		<section class="infoPet">
			<div class="container infoPet__container">
				<h2 class="infoPet__title">Как забрать животное</h2>

				<p class="infoPet__text">
					Если вы хотите забрать собаку домой, выполните следующие шаги:
				</p>
				<p class="infoPet__text">
					<span class="infoPet__text-span">Заполните форму заявки на усыновление:
					</span>
					на этой странице вы найдете форму, которую нужно заполнить. Укажите
					ваши контактные данные и ответьте на несколько вопросов о том,
					почему вы хотите взять Джекки.
				</p>
				<p class="infoPet__text">
					<span class="infoPet__text-span">Ожидайте звонка:</span> После
					отправки заявки наш сотрудник свяжется с вами для уточнения деталей
					и приглашения на встречу.
				</p>
				<p class="infoPet__text">
					<span class="infoPet__text-span">Посетите приют:</span> Приезжайте в
					наш приют, чтобы лично познакомиться с животным и оформить
					необходимые документы.
				</p>
				<p class="infoPet__text">
					<span class="infoPet__text-span">Подготовьте дом:</span> Перед тем
					как забрать питомца, убедитесь, что у вас дома есть все необходимое
					для его комфортного проживания (корм, миски, игрушки, место для сна
					и т.д.).
				</p>
				<p class="infoPet__text">
					<span class="infoPet__text-span">Заберите друга:</span>
					После подписания всех документов вы сможете забрать питомца домой и
					подарить ему новую жизнь.
				</p>
			</div>
		</section>
		<section class="help">
			<div class="container help__container">
				<div class="help__block">
					<div class="help__block-info">
						<p class="help__block-info-title">
							Ваше участие может изменить жизнь наших подопечных к лучшему!
						</p>
						<p class="help__block-info-text">
							В приюте "МУРЧАЛКА" мы нуждаемся в вашей поддержке, чтобы
							обеспечить животным все необходимое и помочь им найти любящий
							дом. Есть множество способов, как вы можете помочь, узнать о них
							можно в разделе
							<span class="help__block-info-text-white">“помочь приюту”</span>
						</p>
					</div>
					<img src="../src/image/sleeping-cat.png" alt="sleeping-cat" class="help__block-img" />
				</div>
				<a href="../page/help.html" class="help__btn">узнать подробнее</a>
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
	<div class="application popup none">
		<form method="post" action="../src/app.php" class="popup__block application__block">
			<p class="popup__block-title">оставить заявку</p>
			<div class="popup__block-text-flex">
				<div class="popup__block-text-info">
					<p class="popup__block-text">Имя</p>
					<input <?php
									if ($_SESSION['is_authenticated'])
										echo "value=" . $_SESSION['auth__name'];
									?> type="text" class="popup__block-input popup__block-text-info-input application__name" name="name" placeholder="Имя" />
				</div>
				<div class="popup__block-text-info">
					<p class="popup__block-text">Номер телефона</p>
					<input <?php
									if ($_SESSION['is_authenticated'])
										echo "value=" . $_SESSION['auth__phone'];
									?> type="text" class="popup__block-input popup__block-text-info-input application__phone" name="phone" placeholder="Номер телефона" />
				</div>
			</div>
			<p class="popup__block-text">E-mail</p>
			<input <?php
							if ($_SESSION['is_authenticated'])
								echo "value=" . $_SESSION['auth__email'];
							?> type="text" class="popup__block-input application__email" name="email" placeholder="E-mail" />
			<p class="popup__block-text">Комментарий</p>
			<textarea maxlength="472" placeholder="Комментарий" class="popup__block-input application__comment" name="comment"></textarea>
			<button type="submit" class="popup__block-btn popup-btn application-btn">
				Оставить заявку!
			</button>
			<button type="reset" class="popup__block-close close closeApplication">✖</button>
		</form>
	</div>

	<script>
		document.addEventListener("DOMContentLoaded", function() {
			document.querySelector('.closeApplication').onclick = function() {
				document.querySelector('.application').className = 'application popup none';
			};
		});
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
	<script type="module" src="../src/js/popup.js">
	</script>
</body>

</html>