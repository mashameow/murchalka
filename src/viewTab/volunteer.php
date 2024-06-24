<?php
// Подключение к базе данных
$db = mysqli_connect('localhost', 'root', '', 'murchalka');

if (!$db) {
	die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}
$volunteerView = "SELECT * FROM volunteer";
$volunteerView_result = mysqli_query($db, $volunteerView);
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
		<h2 class="admin_title">Все волонтеры</h2>
		<table>
			<tr>
				<th class="popup__block-text">ID_volunteer</th>
				<th class="popup__block-text">ФИО</th>
				<th class="popup__block-text">Телефон</th>
				<th class="popup__block-text">Email</th>
				<th class="popup__block-text">Специализация</th>
			</tr>
			<?php while ($row = mysqli_fetch_assoc($volunteerView_result)) { ?>
				<tr>
					<td class="popup__block-text"><?= $row['ID_volunteer'] ?></td>
					<td class="popup__block-text"><?= $row['FIO'] ?></td>
					<td class="popup__block-text"><?= $row['phone'] ?></td>
					<td class="popup__block-text"><?= $row['email'] ?></td>
					<td class="popup__block-text"><?= $row['specialization'] ?></td>
				</tr>
			<?php } ?>
		</table>
		<button class="exit view_exit" onclick="history.back()">Вернуться назад</button>
	</div>
</body>

</html>