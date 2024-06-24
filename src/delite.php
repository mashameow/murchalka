<?php
// Подключение к базе данных
$db = mysqli_connect('localhost', 'root', '', 'murchalka');

if (!$db) {
	die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

// Удаление записи из таблицы application
if (isset($_POST['applicationDel'])) {
	$id = $_POST['applicationDel'];
	$application = "DELETE FROM application WHERE ID_application = '$id'";
	$application_result = mysqli_query($db, $application);
	if ($application_result) {
		echo
		"<script>alert('Запись успешно удалена');history.go(-1);
		</script>";
	} else {
		echo
		"<script>alert('Ошибка удаления записи');history.go(-1);</script>";
	}
}
// Удаление записи из таблицы family
if (isset($_POST['familyDel'])) {
	$id = $_POST['familyDel'];
	$family = "DELETE FROM family WHERE ID_family = '$id'";
	$family_result = mysqli_query($db, $family);
	if ($family_result) {
		echo
		"<script>alert('Запись успешно удалена');history.go(-1);</script>";
	} else {
		echo
		"<script>alert('Ошибка удаления записи');history.go(-1);</script>";
	}
}
// Удаление записи из таблицы pets
if (isset($_POST['petDel'])) {
	$id = $_POST['petDel'];
	$pets = "DELETE FROM pets WHERE ID_pets = '$id'";
	$pets_result = mysqli_query($db, $pets);
	if ($pets_result) {
		echo
		"<script>alert('Запись успешно удалена');history.go(-1);</script>";
	} else {
		echo
		"<script>alert('Ошибка удаления записи');history.go(-1);</script>";
	}
}
// Удаление записи из таблицы family
if (isset($_POST['volunteerDel'])) {
	$id = $_POST['volunteerDel'];
	$volunteer = "DELETE FROM volunteer WHERE ID_volunteer = '$id'";
	$volunteer_result = mysqli_query($db, $volunteer);
	if ($volunteer_result) {
		echo
		"<script>alert('Запись успешно удалена');history.go(-1);</script>";
	} else {
		echo
		"<script>alert('Ошибка удаления записи');history.go(-1);</script>";
	}
}
// Удаление записи из таблицы users
if (isset($_POST['userDelBtn'])) {
	$idUsers = $_POST['userDel_ID_users'];
	$userDel = "DELETE FROM users WHERE ID_users = '$idUsers'";
	$userDel_result = mysqli_query($db, $userDel);
	if ($userDel_result) {
		echo
		"<script>alert('Пользователь успешно удален');history.go(-1);
        </script>";
	} else {
		echo
		"<script>alert('Ошибка удаления пользователя');history.go(-1);</script>";
	}
}
if (isset($_POST['healthDelBtn'])) {
	$idhealthDelInp = $_POST['healthDelInp'];
	$healthDelInpDel = "DELETE FROM healthConditions WHERE ID_healthConditions = '$idhealthDelInp'";
	$healthDelInpDel_result = mysqli_query($db, $healthDelInpDel);
	if ($healthDelInpDel_result) {
		echo
		"<script>alert('Пользователь успешно удален');history.go(-1);
        </script>";
	} else {
		echo
		"<script>alert('Ошибка удаления пользователя');history.go(-1);</script>";
	}
}
if (isset($_POST['sessionDelBtn'])) {
	$idsessionDelInp = $_POST['sessionDelInp'];
	$sessionDelInpDel = "DELETE FROM session WHERE ID_session = '$idsessionDelInp'";
	$sessionDelInpDel_result = mysqli_query($db, $sessionDelInpDel);
	if ($sessionDelInpDel_result) {
		echo
		"<script>alert('Пользователь успешно удален');history.go(-1);
        </script>";
	} else {
		echo
		"<script>alert('Ошибка удаления пользователя');history.go(-1);</script>";
	}
}
if (isset($_POST['stausDelBtn'])) {
	$idstatusDelInp = $_POST['stausDelInp'];
	$statusDelInpDel = "DELETE FROM statusApp WHERE ID_statusApp = '$idsessionDelInp'";
	$statusDelInpDel_result = mysqli_query($db, $statusDelInpDel);
	if ($statusDelInpDel_result) {
		echo
		"<script>alert('Пользователь успешно удален');history.go(-1);
        </script>";
	} else {
		echo
		"<script>alert('Ошибка удаления пользователя');history.go(-1);</script>";
	}
}
