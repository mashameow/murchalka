<?php
session_start();

if ($_POST) {
	// Авторизация пользователя
	if (isset($_POST['auth__email']) && isset($_POST['auth__pass']) && isset($_POST['g-recaptcha-response'])) {
		$email = $_POST['auth__email'];
		$password = $_POST['auth__pass'];
		$recaptcha_response = $_POST['g-recaptcha-response'];

		// Проверка reCAPTCHA
		$secret_key = '6LcPs_kpAAAAAH0g09WysybknpxhIZUeo7_9dJmJ';
		$verify_response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret_key}&response={$recaptcha_response}&remoteip={$_SERVER['REMOTE_ADDR']}");
		$response_data = json_decode($verify_response, true);

		if ($response_data['success']) {
			$db = mysqli_connect('localhost', 'root', '', 'murchalka');

			// Проверка учетных данных пользователя
			$stmt = $db->prepare("SELECT ID_users, name, phone, role FROM users WHERE email =? AND password =?");
			$stmt->bind_param("ss", $email, $password);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows > 0) {
				$user_data = $result->fetch_assoc();

				// Сохранение данных пользователя в сессии
				$_SESSION['auth__email'] = $email;
				$_SESSION['auth__pass'] = $password;
				$_SESSION['user_id'] = $user_data['ID_users'];
				$_SESSION['auth__name'] = $user_data['name'];
				$_SESSION['auth__phone'] = $user_data['phone'];
				$_SESSION['role'] = $user_data['role'];
				if ($_SESSION['role'] == 1) {
					header('Location:http://localhost:5173/page/admin.html?');
				}
				// Вставка информации о начале сессии в базу данных
				$session_stmt = $db->prepare("INSERT INTO session (ID_session, ID_users, dateStart, dateEnd) VALUES (NULL,?,?, NULL)");
				$login_time = date('Y-m-d H:i:s');
				$session_stmt->bind_param("is", $_SESSION['user_id'], $login_time);
				$session_stmt->execute();
				$session_stmt->close();

				// Проверка наличия записей в таблице application
				$application_stmt = $db->prepare("SELECT ID_statusApp, comment, ID_pets FROM application WHERE ID_users =?");
				$application_stmt->bind_param("i", $_SESSION['user_id']);
				$application_stmt->execute();
				$application_result = $application_stmt->get_result();

				if ($application_result->num_rows > 0) {
					$application_data = $application_result->fetch_assoc();
					$_SESSION['ID_statusApp'] = $application_data['ID_statusApp'];
					$_SESSION['application_comment'] = $application_data['comment'];
					$_SESSION['pet_id'] = $application_data['ID_pets'];
					$_SESSION['user_pet'] = $application_data['ID_pets'];

					$status_stmt = $db->prepare("SELECT name FROM statusApp WHERE ID_statusApp =?");
					$status_stmt->bind_param("i", $_SESSION['ID_statusApp']);
					$status_stmt->execute();
					$status_result = $status_stmt->get_result();
					if ($status_result->num_rows > 0) {
						$status_data = $status_result->fetch_assoc();
						// Получение значения атрибута photo из таблицы pets
						$_SESSION['name_statusApp'] = $status_data['name'];
					}
					$pet_stmt = $db->prepare("SELECT photo, name FROM pets WHERE ID_pets =?");
					$pet_stmt->bind_param("i", $_SESSION['user_pet']);
					$pet_stmt->execute();
					$pet_result = $pet_stmt->get_result();
					if ($pet_result->num_rows > 0) {
						$pet_data = $pet_result->fetch_assoc();
						$_SESSION['user_pet-photo'] = $pet_data['photo'];
						$_SESSION['user_pet-name'] = $pet_data['name'];
					}
				}
				echo "<script>alert('Вы успешно авторизовались!');history.go(-1);</script>";
			} else {
				echo "<script>alert('Неверный логин или пароль. Попробуйте снова.');</script>";
			}
			$stmt->close();
		} else {
			echo "<script>alert('Пройдите рекапчу');</script>";
		}
	}

	// Обработка выхода пользователя
	if (isset($_POST['logout'])) {
		// Если пользователь выходит, сохраняем время окончания сессии
		if (isset($_SESSION['user_id'])) {
			$logout_time = date('Y-m-d H:i:s');

			// Получаем текущий ID сессии из базы данных
			$db = mysqli_connect('localhost', 'root', '', 'murchalka');
			$stmt = $db->prepare("SELECT ID_session FROM session WHERE ID_users =? ORDER BY dateStart DESC LIMIT 1");
			$stmt->bind_param("i", $_SESSION['user_id']);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$session_id_db = $row['ID_session'];

				// Обновляем запись с временем окончания сессии
				$update_stmt = $db->prepare("UPDATE session SET dateEnd =? WHERE ID_session =?");
				$update_stmt->bind_param("si", $logout_time, $session_id_db);
				$update_stmt->execute();
				$update_stmt->close();
			}
			$stmt->close();
		}

		// Удаляем все переменные сессии
		$_SESSION = array();

		// Уничтожаем сессию
		session_destroy();

		// Перенаправляем на главную страницу или другую
		header('Location: http://localhost:5173/page/account.php');
		exit;
	}
}
// Determine if the user is authenticated
$is_authenticated = isset($_SESSION['auth__email']) && isset($_SESSION['auth__pass']);
$_SESSION['is_authenticated'] = isset($_SESSION['auth__email']) && isset($_SESSION['auth__pass']);
$_SESSION['is_application'] = isset($_SESSION['name_statusApp']) && isset($_SESSION['application_comment']);



?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="../src/scss/style.css" />
	<link rel="icon" href="../src/image/loolgo.png" />
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<title>Личный кабинет</title>
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
						<a href="./account.html" class="header__nav-menu-link"><img src="../src/image/user.svg" alt="user" class="header__nav-menu-link-img" /></a>
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
		<section class="heroAcc">
			<div class="heroAcc__container container">
				<h1 class="heroAcc__title">лИЧНЫЙ КАБИНЕТ</h1>
				<div class="heroAcc__info">
					<div class="heroAcc__info-block">
						<p class="heroAcc__info-block-text">
							<?php if ($is_authenticated) echo $_SESSION['auth__name'] . ', ';
							?>добро пожаловать в ваш личный кабинет на сайте приюта
							"МУРЧАЛКА"!
						</p>

						<div class="heroAcc__info-block-people">
							<p class="heroAcc__info-block-people-text">ваша почта:</p>
							<p class="heroAcc__info-block-people-text-bd e-mail"> <?php if ($is_authenticated)  echo $_SESSION['auth__email']; ?></p>
						</div>
						<div class="heroAcc__info-block-people">
							<p class="heroAcc__info-block-people-text">
								ваш номер телефона:
							</p>
							<p class="heroAcc__info-block-people-text-bd phone_numder"> <?php if ($is_authenticated) echo $_SESSION['auth__phone']; ?></p>
						</div>
						<?php if ($_SESSION['is_application']) echo '<div class="heroAcc__info-block-people">
							<p class="heroAcc__info-block-people-text">Вы хотите забрать:</p>
							<a href="./pet.php?id=' . $_SESSION["user_pet"] . '" class="heroAcc__info-block-people-text-bd name application_name">' . $_SESSION['user_pet-name'] . '</a>
						</div>
						<div class="heroAcc__info-block-people">
							<p class="heroAcc__info-block-people-text">статус заявки:</p>
							<p class="heroAcc__info-block-people-text-bd name application_status">' . $_SESSION['name_statusApp'] . '</p>
						</div>
						<div class="heroAcc__info-block-people heroAcc__info-block-people-comment">
							<p class="heroAcc__info-block-people-text heroAcc__info-block-people-text-comment">
								комментарий к заявке:
							</p>
							<p class="heroAcc__info-block-people-text-bd  comment">' . $_SESSION['application_comment'] . '</p>
						</div>'; ?>

					</div>
					<?php if ($_SESSION['is_application']) {
						echo '<a href="./pet.php?id=' . $_SESSION["user_pet"] . '"><img src="../src/image/pet/' . $_SESSION['user_pet-photo'] . '" alt="sitting_cat" class="heroAcc__info-img pet"/></a>';
					} else {
						echo  "<img src='../src/image/acc/sitting_cat.png' alt='sitting_cat' class= 'heroAcc__info-img'/>";
					} ?>

				</div>

				<?php if ($is_authenticated) {
					if ($_SESSION['role'] == 1) {
						echo '<div class="acc_btn">
						<form method="post" action="./account.php">
						<button class="exit" name="logout">Выйти</button>
						</form>
						<a href="./admin.html" class="exit adminBtn" name="adminBtn">Перейти в панель администратора</a>
						</div>';
					} else {
						echo '<form method="post" action="./account.php">
						<button class="exit" name="logout">Выйти</button>
					</form>';
					}
				} ?>



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
	<div class="auth popup <?php if ($is_authenticated) echo 'none'; ?>">
		<form method="post" action="./account.php" class="popup__block">
			<p class="popup__block-title">авторизация</p>
			<p class="popup__block-text">E-mail</p>
			<input type="text" class="popup__block-input auth__email" placeholder="E-mail" name="auth__email" />
			<p class="popup__block-text">Пароль</p>
			<input type="password" placeholder="Пароль" class="popup__block-input auth__pass" name="auth__pass" />
			<div class="g-recaptcha" data-sitekey="6LcPs_kpAAAAAEUzIJHh5v2Hr4PbUSgXWryGNToI"></div>
			<button class="popup__block-btn popup-btn auth-btn">
				авторизоваться
			</button>
			<p class="popup__block-comment">
				или <br />
				если у вас нет аккаунта
			</p>

			<button class="popup__block-btn popup-btn reg-btn">
				Зарегистрироваться
			</button>
			<button type="reset" class="popup__block-close closeAuth close">
				✖
			</button>
		</form>
		<script>
			function onClick(e) {
				e.preventDefault();
				grecaptcha.enterprise.ready(async () => {
					const token = await grecaptcha.enterprise.execute(
						'6LcPs_kpAAAAAEUzIJHh5v2Hr4PbUSgXWryGNToI', {
							action: 'LOGIN'
						}
					);
					document.querySelector('.enter-form').submit();
				});
			}
		</script>
	</div>
	<div class="reg popup none">
		<form method="post" action="../src/reg.php" class="popup__block reg__block">
			<p class="popup__block-title">Регистрация</p>
			<p class="popup__block-text">Имя</p>
			<input type="text" class="popup__block-input reg__name" placeholder="Имя" name="name" />
			<p class="popup__block-text">Номер телефона</p>
			<input type="text" class="popup__block-input reg__phone" placeholder="Номер телефона" name="phone" />
			<p class="popup__block-text">E-mail</p>
			<input type="text" class="popup__block-input reg__email" placeholder="E-mail" name="email" />
			<p class="popup__block-text">Пароль</p>
			<input type="password" placeholder="Пароль" class="popup__block-input reg__pass" name="password" />
			<p class="popup__block-text">Подтверждение пароля</p>
			<input type="password" placeholder="Подтверждение пароля" class="popup__block-input reg__pass2" name="passwordConf" />
			<button class="popup__block-btn popup-btn reg-btn">
				Зарегистрироваться
			</button>
			<button type="reset" class="popup__block-close close closeReg">
				✖
			</button>
		</form>
	</div>
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
	<script type="module" src="../src/js/popup.js"></script>
</body>

</html>