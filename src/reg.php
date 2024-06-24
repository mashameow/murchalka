
<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'murchalka');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$password = $_POST['password'];
	$passwordConf = $_POST['passwordConf'];
	$error = "";

	// Проверка на ошибки подключения к базе данных
	if ($db == false) {
		echo "<script>alert('Ошибка подключения к базе данных');</script>";
		exit(); // Прекращаем выполнение скрипта, так как база недоступна
	}

	// Проверка на пустые поля
	if (empty($name) || empty($email) || empty($phone) || empty($password) || empty($passwordConf)) {
		$error = 'Пожалуйста, заполните все поля';
	}
	// Проверка на правильное заполнение почты
	elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$error = 'Неправильный формат электронной почты';
	}
	// Проверка на запрещенные символы в пароле
	elseif (preg_match('/[\'",\*,\[\],\{\}]/', $password)) {
		$error = 'Недопустимые символы в пароле';
	}
	// Проверка совпадения паролей
	elseif ($password !== $passwordConf) {
		$error = 'Пароли не совпадают';
	}
	// Проверка длины пароля
	elseif (strlen($password) <= 6) {
		$error = 'Пароль должен быть длиннее 6 символов';
	}
	// Проверки на существующие данные в бд
	else {
		// Проверка на существующий email
		$userMail = mysqli_query($db, "SELECT email FROM users WHERE email = '$email'");
		if (mysqli_num_rows($userMail) > 0) {
			$error = 'Такая почта уже используется';
		}

		// Проверка на существующий телефон
		$userPhone = mysqli_query($db, "SELECT phone FROM users WHERE phone = '$phone'");
		if (mysqli_num_rows($userPhone) > 0) {
			$error = 'Такой номер телефона уже используется';
		}
	}
	// Если есть ошибка, показать её и не сохранять данные в БД
	if ($error) {
		echo "<script>
		alert('$error');
		history.go(-1); 
		document.querySelector('.auth').classList.remove('none');</script>";
		// Не перезагружаем страницу и останавливаем выполнение скрипта
		exit();
	}


	// Если ошибок нет, продолжаем обработку данных
	// Удаление всех нецифровых символов из номера телефона

	// Вставка данных в базу данных
	$sqlInsert = "INSERT INTO users SET email = '$email', password = '$password', name = '$name', phone = '$phone', role = '0'";
	$result = mysqli_query($db, $sqlInsert);

	if ($result) {
		// Регистрация прошла успешно перезагружаем страницу
		header('Location:http://localhost:5173/page/account.php?');
	}
}
