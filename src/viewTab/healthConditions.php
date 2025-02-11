<?php
// Подключение к базе данных
$db = mysqli_connect('localhost', 'root', '', 'murchalka');

if (!$db) {
	die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}
$healthConditionsView = "SELECT * FROM healthConditions";
$healthConditionsView_result = mysqli_query($db, $healthConditionsView);
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
		<h2 class="admin_title">Все статусы состояния здоровья</h2>
		<table>
			<tr>
				<th class="popup__block-text">ID_healthConditions</th>
				<th class="popup__block-text">Описание здоровья</th>
			</tr>
			<?php while ($row = mysqli_fetch_assoc($healthConditionsView_result)) { ?>
				<tr>
					<td class="popup__block-text"><?= $row['ID_healthConditions'] ?></td>
					<td class="popup__block-text"><?= $row['descriptionHealth'] ?></td>
				</tr>
			<?php } ?>
		</table>
		<button class="exit view_exit" onclick="history.back()">Вернуться назад</button>
	</div>
</body>

</html>