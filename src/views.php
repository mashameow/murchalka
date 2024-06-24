<?php
$db = mysqli_connect('localhost', 'root', '', 'murchalka');

if (!$db) {
	die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../src/scss/style.css" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Представления</title>
</head>

<body class="views">
	<div class="container views__container">
		<div class="views__block">
			<div class="views__text">
				<h2 class="admin_title views_title">Какое представление вывести?</h2>
				<button class="views__text-request" onclick="document.querySelector('.requestPopup').classList.remove('none')">1. Получить список всех животных в приюте определенного вида.</button>
				<form method="post" class="views__text-form">

					<button type="submit" name="request2" class="views__text-request">2. Получить список всех волонтеров, работающих в приюте.</button>
					<button type="submit" name="request3" class="views__text-request">3. Получить список всех видов животных, доступных для усыновления.</button>
					<button type="submit" name="request4" class="views__text-request">4. Получить список всех животных, у которых превышен лимит времени
						пребывания в приюте.</button>
					<button type="submit" name="request5" class="views__text-request">5. Получить список всех животных, которым требуется медицинское лечение.</button>
					<button type="submit" name="request6" class="views__text-request">6. Получить список всех животных, которые уже были усыновлены.</button>
					<button type="submit" name="request7" class="views__text-request">7. Получить список всех животных, отсортированных по возрастанию возраста.</button>
				</form>

				<button type="submit" name="request8" class="views__text-request" onclick="document.querySelector('.request8Popup').classList.remove('none')">8. Получить список всех волонтеров, которые занимаются определенным видом
					животных.</button>
				<form method="post" class="views__text-form">

					<button type="submit" name="request9" class="views__text-request">9. Получить список всех животных, которые находятся на карантине.</button>
					<button type="submit" name="request10" class="views__text-request">10. Получить список всех животных, у которых есть братья или сестры в приюте.</button>
				</form>
				<button onclick="redirectToAdmPage()" class=" exit-views exit">
					Выйти
				</button>
			</div>
			<div class="answer">
				<?php
				if (isset($_POST['cat'])) {
					$request1Cat = $_POST['cat'];
					$query1Cat = "SELECT * FROM pets WHERE kind = 'к'";

					// Execute the query
					$result1Cat = mysqli_query($db, $query1Cat);

					// Check if the query was successful
					if (!$result1Cat) {
						die("Query failed: " . mysqli_error($db));
					}

					// Display the results
					echo "<h2 class='admin_title views_rez'>Результат:</h2>";
					echo "<ul class='rez-ul'>";
					while ($row = mysqli_fetch_assoc($result1Cat)) {
						echo "<li class='popup__block-text'>";
						echo "Вид: " . $row['kind'] . ", ID: " . $row['ID_pets'] . ", Имя: " . $row['name'] . ", Возраст: " . $row['age'];
						echo "</li>";
					}
					echo "</ul>";
				} elseif (isset($_POST['dog'])) {
					$request1Dog = $_POST['dog'];
					$query1Dog = "SELECT * FROM pets WHERE kind = 'с'";

					// Execute the query
					$result1Dog = mysqli_query($db, $query1Dog);

					// Check if the query was successful
					if (!$result1Dog) {
						die("Query failed: " . mysqli_error($db));
					}

					// Display the results
					echo "<h2 class='admin_title views_rez'>Результат:</h2>";
					echo "<ul class='rez-ul'>";
					while ($row = mysqli_fetch_assoc($result1Dog)) {
						echo "<li class='popup__block-text'>";
						echo "Вид: " . $row['kind'] . ", ID: " . $row['ID_pets'] . ", Имя: " . $row['name'] . ", Возраст: " . $row['age'];
						echo "</li>";
					}
					echo "</ul>";
				} elseif (isset($_POST['request2'])) {
					$request2 = $_POST['request2'];
					$query2 = "SELECT * FROM volunteer;";

					// Execute the query
					$result2 = mysqli_query($db, $query2);

					// Check if the query was successful
					if (!$result2) {
						die("Query failed: " . mysqli_error($db));
					}

					// Display the results
					echo "<h2 class='admin_title views_rez'>Результат:</h2>";
					echo "<ul class='rez-ul'>";
					while ($row = mysqli_fetch_assoc($result2)) {
						echo "<li class='popup__block-text'>";
						echo  "ID: " . $row['ID_volunteer'] . ", FIO: " . $row['FIO'] . ", phone: " . $row['phone'] . ", email: " . $row['email'] . ", specialization: " . $row['specialization'];
						echo "</li>";
					}
					echo "</ul>";
				} elseif (isset($_POST['request3'])) {
					$request3 = $_POST['request3'];
					$query3 = "SELECT * FROM pets WHERE status = 'в приюте';";

					// Execute the query
					$result3 = mysqli_query($db, $query3);

					// Check if the query was successful
					if (!$result3) {
						die("Query failed: " . mysqli_error($db));
					}

					// Display the results
					echo "<h2 class='admin_title views_rez'>Результат:</h2>";
					echo "<ul class='rez-ul'>";
					while ($row = mysqli_fetch_assoc($result3)) {
						echo "<li class='popup__block-text'>";
						echo "Status: " . $row['status'] . ", Вид: " . $row['kind'] . ", ID: " . $row['ID_pets'] . ", Имя: " . $row['name'] . ", Возраст: " . $row['age'] . ", ID_family: " . $row['ID_family'];
						echo "</li>";
					}
					echo "</ul>";
				} elseif (isset($_POST['request3'])) {
					$request3 = $_POST['request3'];
					$query3 = "SELECT * FROM pets WHERE status = 'в приюте';";

					// Execute the query
					$result3 = mysqli_query($db, $query3);

					// Check if the query was successful
					if (!$result3) {
						die("Query failed: " . mysqli_error($db));
					}

					// Display the results
					echo "<h2 class='admin_title views_rez'>Результат:</h2>";
					echo "<ul class='rez-ul'>";
					while ($row = mysqli_fetch_assoc($result3)) {
						echo "<li class='popup__block-text'>";
						echo "ID: " . $row['ID_pets'] . ", Status: " . $row['status'] . ", Вид: " . $row['kind'] .  ", Имя: " . $row['name'] . ", Возраст: " . $row['age'] . ", ID_family: " . $row['ID_family'];
						echo "</li>";
					}
					echo "</ul>";
				} elseif (isset($_POST['request4'])) {
					$request4 = $_POST['request4'];
					$query4 = "SELECT * FROM pets WHERE DATEDIFF(CURDATE(), dateReceipt) > 30;";

					// Execute the query
					$result4 = mysqli_query($db, $query4);

					// Check if the query was successful
					if (!$result4) {
						die("Query failed: " . mysqli_error($db));
					}

					// Display the results
					echo "<h2 class='admin_title views_rez'>Результат:</h2>";
					echo "<ul class='rez-ul'>";
					while ($row = mysqli_fetch_assoc($result4)) {
						echo "<li class='popup__block-text'>";
						echo "ID: " . $row['ID_pets'] .  ", Имя: " . $row['name'] . ", dateReceipt: " . $row['dateReceipt'];
						echo "</li>";
					}
					echo "</ul>";
				} elseif (isset($_POST['request5'])) {
					$request5 = $_POST['request5'];
					$query5 = "SELECT * FROM pets WHERE ID_healthConditions IN (SELECT ID_healthConditions FROM healthConditions WHERE descriptionHealth = 'требуется лечение')";

					// Execute the query
					$result5 = mysqli_query($db, $query5);

					// Check if the query was successful
					if (!$result5) {
						die("Query failed: " . mysqli_error($db));
					}

					// Display the results
					echo "<h2 class='admin_title views_rez'>Результат:</h2>";
					echo "<ul class='rez-ul'>";
					while ($row = mysqli_fetch_assoc($result5)) {
						echo "<li class='popup__block-text'>";
						echo "ID: " . $row['ID_pets'] .  ", Имя: " . $row['name'] . ", dateReceipt: " . $row['dateReceipt'] . ", ID_healthConditions: " . $row['ID_healthConditions'] . ", ID_volunteer: " . $row['ID_volunteer'];
						echo "</li>";
					}
					echo "</ul>";
				} elseif (isset($_POST['request6'])) {
					$request6 = $_POST['request6'];
					$query6 = "SELECT * FROM pets WHERE status = 'усыновлен';";

					// Execute the query
					$result6 = mysqli_query($db, $query6);

					// Check if the query was successful
					if (!$result6) {
						die("Query failed: " . mysqli_error($db));
					}

					// Display the results
					echo "<h2 class='admin_title views_rez'>Результат:</h2>";
					echo "<ul class='rez-ul'>";
					while ($row = mysqli_fetch_assoc($result6)) {
						echo "<li class='popup__block-text'>";
						echo "ID: " . $row['ID_pets'] .  ", Имя: " . $row['name'] . ", dateReceipt: " . $row['dateReceipt'] . ", ID_healthConditions: " . $row['ID_healthConditions'] . ", ID_volunteer: " . $row['ID_volunteer'];
						echo "</li>";
					}
					echo "</ul>";
				} elseif (isset($_POST['request7'])) {
					$request7 = $_POST['request7'];
					$query7 = "SELECT * FROM pets ORDER BY IF(LENGTH(age) > 1, CONCAT(SUBSTRING(age, 1, 1), SUBSTRING(age, 2, 1), SUBSTRING(age, 3, 1)), age) ASC;";

					// Execute the query
					$result7 = mysqli_query($db, $query7);

					// Check if the query was successful
					if (!$result7) {
						die("Query failed: " . mysqli_error($db));
					}

					// Display the results
					echo "<h2 class='admin_title views_rez'>Результат:</h2>";
					echo "<ul class='rez-ul'>";
					while ($row = mysqli_fetch_assoc($result7)) {
						echo "<li class='popup__block-text'>";
						echo "ID: " . $row['ID_pets'] .  ", Имя: " . $row['name'] . ", Возраст: " . $row['age'];
						echo "</li>";
					}
					echo "</ul>";
				} elseif (isset($_POST['cat8'])) {
					$request8Cat = $_POST['cat8'];
					$query8Cat = "SELECT * FROM volunteer WHERE specialization = 'Кошки'";

					// Execute the query
					$result8Cat = mysqli_query($db, $query8Cat);

					// Check if the query was successful
					if (!$result8Cat) {
						die("Query failed: " . mysqli_error($db));
					}

					// Display the results
					echo "<h2 class='admin_title views_rez'>Результат:</h2>";
					echo "<ul class='rez-ul'>";
					while ($row = mysqli_fetch_assoc($result8Cat)) {
						echo "<li class='popup__block-text'>";
						echo "ID_volunteer: " . $row['ID_volunteer'] . ", 	FIO: " . $row['FIO'] . ", phone: " . $row['phone'] . ", email: " . $row['email'] . ", specialization: " . $row['specialization'];
						echo "</li>";
					}
					echo "</ul>";
				} elseif (isset($_POST['dog8'])) {
					$request8Dog = $_POST['dog8'];
					$query8Dog = "SELECT * FROM volunteer WHERE specialization = 'Собаки'";

					// Execute the query
					$result8Dog = mysqli_query($db, $query8Dog);

					// Check if the query was successful
					if (!$result8Dog) {
						die("Query failed: " . mysqli_error($db));
					}

					// Display the results
					echo "<h2 class='admin_title views_rez'>Результат:</h2>";
					echo "<ul class='rez-ul'>";
					while ($row = mysqli_fetch_assoc($result8Dog)) {
						echo "<li class='popup__block-text'>";
						echo "ID_volunteer: " . $row['ID_volunteer'] . ", 	FIO: " . $row['FIO'] . ", phone: " . $row['phone'] . ", email: " . $row['email'] . ", specialization: " . $row['specialization'];
						echo "</li>";
					}
					echo "</ul>";
				} elseif (isset($_POST['dog8'])) {
					$request8Dog = $_POST['dog8'];
					$query8Dog = "SELECT * FROM volunteer WHERE specialization = 'Собаки'";

					// Execute the query
					$result8Dog = mysqli_query($db, $query8Dog);

					// Check if the query was successful
					if (!$result8Dog) {
						die("Query failed: " . mysqli_error($db));
					}

					// Display the results
					echo "<h2 class='admin_title views_rez'>Результат:</h2>";
					echo "<ul class='rez-ul'>";
					while ($row = mysqli_fetch_assoc($result8Dog)) {
						echo "<li class='popup__block-text'>";
						echo "ID_volunteer: " . $row['ID_volunteer'] . ", 	FIO: " . $row['FIO'] . ", phone: " . $row['phone'] . ", email: " . $row['email'] . ", specialization: " . $row['specialization'];
						echo "</li>";
					}
					echo "</ul>";
				} elseif (isset($_POST['request9'])) {
					$request9 = $_POST['request9'];
					$query9 = "SELECT * FROM pets WHERE ID_healthConditions IN (SELECT ID_healthConditions FROM healthConditions WHERE descriptionHealth = 'на карантине');";

					// Execute the query
					$result9 = mysqli_query($db, $query9);

					// Check if the query was successful
					if (!$result9) {
						die("Query failed: " . mysqli_error($db));
					}

					// Display the results
					echo "<h2 class='admin_title views_rez'>Результат:</h2>";
					echo "<ul class='rez-ul'>";
					while ($row = mysqli_fetch_assoc($result9)) {
						echo "<li class='popup__block-text'>";
						echo "ID: " . $row['ID_pets'] .  ", Имя: " . $row['name'] . ", dateReceipt: " . $row['dateReceipt'] . ", ID_healthConditions: " . $row['ID_healthConditions'] . ", ID_volunteer: " . $row['ID_volunteer'] . ", descriptionHealth: на карантине";
						echo "</li>";
					}
					echo "</ul>";
				} elseif (isset($_POST['request10'])) {
					$request10 = $_POST['request10'];
					$query10 = "SELECT * FROM pets WHERE ID_family IS NOT NULL ORDER BY ID_family ASC;";

					// Execute the query
					$result10 = mysqli_query($db, $query10);

					// Check if the query was successful
					if (!$result10) {
						die("Query failed: " . mysqli_error($db));
					}

					// Display the results
					echo "<h2 class='admin_title views_rez'>Результат:</h2>";
					echo "<ul class='rez-ul'>";
					while ($row = mysqli_fetch_assoc($result10)) {
						echo "<li class='popup__block-text'>";
						echo "ID: " . $row['ID_pets'] .  ", Имя: " . $row['name'] . ", dateReceipt: " . $row['dateReceipt'] .  ", ID_family: " . $row['ID_family'];
						echo "</li>";
					}
					echo "</ul>";
				}
				?>
			</div>
		</div>
	</div>
	<script>
		const buttons = document.querySelectorAll('.views__text-request');

		buttons.forEach(button => {
			button.addEventListener('click', handleButtonClick);
		});
	</script>
	<div class="requestPopup addingPopup popup none">
		<form method="post" action="" class="popup__block requestPopup__form">
			<p class="popup__block-title">кого показать:</p>
			<button name="cat" class="views__text-request oror">кошек</button>
			<button name="dog" class="views__text-request oror">собак</button>
			<button type="reset" class="popup__block-close closeAdminPopup close" onclick="document.querySelector('.requestPopup').classList.add('none')">
				✖
			</button>
		</form>
	</div>
	<div class="request8Popup addingPopup popup none">
		<form method="post" action="" class="popup__block request8Popup__form">
			<p class="popup__block-title">кем волонтер должен заниматься:</p>
			<button name="cat8" class="views__text-request oror">кошками</button>
			<button name="dog8" class="views__text-request oror">собаками</button>
			<button type="reset" class="popup__block-close closeAdminPopup close" onclick="document.querySelector('.requestPopup').classList.add('none')">
				✖
			</button>
		</form>
	</div>
	<script>
		function redirectToAdmPage() {
			window.location.replace('../page/admin.html');
		}
	</script>
</body>

</html>