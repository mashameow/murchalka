<?php
// Подключение к базе данных
$db = mysqli_connect('localhost', 'root', '', 'murchalka');

if (!$db) {
	die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}
$sessionView = "SELECT * FROM session";
$sessionView_result = mysqli_query($db, $sessionView);
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
		<h2 class="admin_title">Все сессии</h2>
		<table>
			<tr>
				<th class="popup__block-text">ID_session</th>
				<th class="popup__block-text">ID_users</th>
				<th class="popup__block-text">Дата начала</th>
				<th class="popup__block-text">Дата конца</th>
			</tr>
			<?php while ($row = mysqli_fetch_assoc($sessionView_result)) { ?>
				<tr>
					<td class="popup__block-text"><?= $row['ID_session'] ?></td>
					<td class="popup__block-text"><?= $row['ID_users'] ?></td>
					<td class="popup__block-text"><?= $row['dateStart'] ?></td>
					<td class="popup__block-text"><?= $row['dateEnd'] ?></td>
				</tr>
			<?php } ?>
		</table>
		<button class="exit view_exit" onclick="history.back()">Вернуться назад</button>
	</div>
</body>

</html>