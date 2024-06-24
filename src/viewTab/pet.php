<?php
// Подключение к базе данных
$db = mysqli_connect('localhost', 'root', '', 'murchalka');

if (!$db) {
	die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}
$petsView = "SELECT * FROM pets";
$petsView_result = mysqli_query($db, $petsView);
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

		<h2 class="admin_title">Все питомцы</h2>
		<table>
			<tr>
				<th>ID_pets</th>
				<th>Имя</th>
				<th>Возраст</th>
				<th>Пол</th>
				<th>Сост. здоровья</th>
				<th>История</th>
				<th>Особенности</th>
				<th>Фото</th>
				<th>Статус</th>
				<th>Дата приема</th>
				<th>ID_volunteer</th>
				<th>ID_family</th>
				<th>Вид</th>
			</tr>
			<?php while ($row = mysqli_fetch_assoc($petsView_result)) { ?>
				<tr>
					<td><?= $row['ID_pets'] ?></td>
					<td><?= $row['name'] ?></td>
					<td><?= $row['age'] ?></td>
					<td><?= $row['floor'] ?></td>
					<td><?= $row['ID_healthConditions'] ?></td>
					<td><?= $row['history'] ?></td>
					<td><?= $row['features'] ?></td>
					<td><?= $row['photo'] ?></td>
					<td><?= $row['status'] ?></td>
					<td><?= $row['dateReceipt'] ?></td>
					<td><?= $row['ID_volunteer'] ?></td>
					<td><?= $row['ID_family'] ?></td>
					<td><?= $row['kind'] ?></td>
				</tr>
			<?php } ?>
		</table>
		<button class="exit view_exit" onclick="history.back()">Вернуться назад</button>
	</div>
</body>

</html>