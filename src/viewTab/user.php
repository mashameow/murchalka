<?php
// Подключение к базе данных
$db = mysqli_connect('localhost', 'root', '', 'murchalka');

if (!$db) {
	die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}
$usersView = "SELECT * FROM users";
$usersView_result = mysqli_query($db, $usersView);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../scss/style.css" />

	<title>Document</title>
</head>

<body>
	<div class="container">
		<h2 class="admin_title">Все пользователи</h2>
		<table>
			<tr>
				<th class="popup__block-text">ID_users</th>
				<th class="popup__block-text">Имя</th>
				<th class="popup__block-text">Email</th>
				<th class="popup__block-text">Телефон</th>
				<th class="popup__block-text">Пароль</th>
				<th class="popup__block-text">Роль</th>
			</tr>
			<?php while ($row = mysqli_fetch_assoc($usersView_result)) { ?>
				<tr>
					<td class="popup__block-text"><?= $row['ID_users'] ?></td>
					<td class="popup__block-text"><?= $row['name'] ?></td>
					<td class="popup__block-text"><?= $row['email'] ?></td>
					<td class="popup__block-text"><?= $row['phone'] ?></td>
					<td class="popup__block-text"><?= $row['password'] ?></td>
					<td class="popup__block-text"><?= $row['role'] ?></td>
				</tr>
			<?php } ?>
		</table>
		<button class="exit view_exit" onclick="history.back()">Вернуться назад</button>
	</div>
</body>

</html>