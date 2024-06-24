<?php
// Подключение к базе данных
$db = mysqli_connect('localhost', 'root', '', 'murchalka');

if (!$db) {
	die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}
$applicationView = "SELECT * FROM application";
$applicationView_result = mysqli_query($db, $applicationView);
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
		<h2 class="admin_title">Все заявки</h2>
		<table>
			<tr>
				<th class="popup__block-text">ID_application</th>
				<th class="popup__block-text">Комментарий</th>
				<th class="popup__block-text">ID_users</th>
				<th class="popup__block-text">ID_pets</th>
				<th class="popup__block-text">ID_statusApp</th>
				<th class="popup__block-text">Номер</th>
			</tr>
			<?php while ($row = mysqli_fetch_assoc($applicationView_result)) { ?>
				<tr>
					<td class="popup__block-text"><?= $row['ID_application'] ?></td>
					<td class="popup__block-text"><?= $row['comment'] ?></td>
					<td class="popup__block-text"><?= $row['ID_users'] ?></td>
					<td class="popup__block-text"><?= $row['ID_pets'] ?></td>
					<td class="popup__block-text"><?= $row['ID_statusApp'] ?></td>
					<td class="popup__block-text"><?= $row['number'] ?></td>
				</tr>
			<?php } ?>
		</table>
		<button class="exit view_exit" onclick="history.back()">Вернуться назад</button>
	</div>
</body>

</html>