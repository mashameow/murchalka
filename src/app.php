<style>
	body {
		color: #fffbf2;
	}
</style>
<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'murchalka');
if (!$db) {
	die("Ошибка подключения к базе данных" . mysqli_connect_error());
}
// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$name = $_POST["name"];
	$phone = $_POST["phone"];
	$email = $_POST["email"];
	$comment = $_POST["comment"];
	function generateRandomNumber($length)
	{
		$characters = '0123456789';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}

	// Generate a random number
	$number = generateRandomNumber(10); // generate a 10-digit random number

	// Check if the number already exists in the database
	$query = "SELECT * FROM application WHERE number = '$number'";
	$result = mysqli_query($db, $query);

	// If the number already exists, generate a new one
	while (mysqli_num_rows($result) > 0) {
		$number = generateRandomNumber(10);
		$query = "SELECT * FROM application WHERE number = '$number'";
		$result = mysqli_query($db, $query);
	}

	// Insert data into application table
	$query = "INSERT INTO application (ID_application,  comment, ID_users, ID_pets, ID_statusApp, number) VALUES (Null, '$comment', '" . $_SESSION['user_id'] . "', '" . $_SESSION['pet_id'] . "', 1, '$number')";
	echo	"<script>alert('Заявка успешно оставлена! Скоро она появится в личном кабинете.');history.go(-1);</script>";
	mysqli_query($db, $query);

	// Close database connection
	mysqli_close($db);

	exit();
}
