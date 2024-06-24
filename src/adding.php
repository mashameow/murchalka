<?php
// Подключение к базе данных
$db = mysqli_connect('localhost', 'root', '', 'murchalka');

if (!$db) {
	die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

// Добавление записи в таблицу application
if (isset($_POST['applicationAddBtn'])) {
	$_POST['applicationAddBtn'];
	$applicationAdd =
		"INSERT INTO application (comment, ID_users, ID_pets, ID_statusApp, number) VALUES ('" . $_POST['applicationAdd_comment'] . "',
		'" . $_POST['applicationAdd_ID_users'] . "', 
		'" . $_POST['applicationAdd_ID_pets'] . "', 
		'" . $_POST['applicationAdd_ID_status'] . "', 
		'" . $_POST['applicationAdd_number'] . "')";
	$applicationAdd_result = mysqli_query($db, $applicationAdd);
	if ($applicationAdd_result) {
		echo
		"<script>alert('Запись успешно добавлена');history.go(-1);
		</script>";
	} else {
		echo
		"<script>alert('Ошибка добавления записи');history.go(-1);</script>";
	}
}
// Добавление записи в таблицу family
if (isset($_POST['familyAddBtn'])) {
	$_POST['familyAddBtn'];
	$familyAdd =
		"INSERT INTO family (number) VALUES ('" . $_POST['familyAdd_number'] . "')";
	$familyAdd_result = mysqli_query($db, $familyAdd);
	if ($familyAdd_result) {
		echo
		"<script>alert('Запись успешно добавлена');history.go(-1);
		</script>";
	} else {
		echo
		"<script>alert('Ошибка добавления записи');history.go(-1);</script>";
	}
}
// Добавление записи в таблицу pets
if (isset($_POST['petAddBtn'])) {
	$petAdd =
		"INSERT INTO pets (name, age, floor, ID_healthConditions, history, features, photo, status, dateReceipt, ID_volunteer, ID_family, kind) VALUES (
            '" . $_POST['petAdd_name'] . "',
            '" . $_POST['petAdd_age'] . "',
            '" . $_POST['petAdd_floor'] . "',
            '" . $_POST['petAdd_ID_healthConditions'] . "',
            '" . $_POST['petAdd_history'] . "',
            '" . $_POST['petAdd_features'] . "',
            '" . $_POST['petAdd_photo'] . "',
            '" . $_POST['petAdd_status'] . "',
            '" . $_POST['petAdd_dateReceipt'] . "',
            '" . $_POST['petAdd_ID_volunteer'] . "',
            " . ('NULL' ?? $_POST['petAdd_ID_family']) . ",
            '" . $_POST['petAdd_kind'] . "'
        )";
	$petAdd_result = mysqli_query($db, $petAdd);
	if ($petAdd_result) {
		echo "<script>alert('Запись успешно добавлена');history.go(-1);</script>";
	} else {
		echo "<script>alert('Ошибка добавления записи');history.go(-1);</script>";
	}
}
// Добавление записи в таблицу family
if (isset($_POST['volunteerAddBtn'])) {
	$_POST['volunteerAddBtn'];
	$volunteerAdd =
		"INSERT INTO volunteer (FIO, phone, email,specialization) VALUES ('" . $_POST['volunteerAdd_FIO'] . "', '" . $_POST['volunteerAdd_phone'] . "', '" . $_POST['volunteerAdd_email'] . "', '" . $_POST['volunteerAdd_specialization'] . "')";
	$volunteerAdd_result = mysqli_query($db, $volunteerAdd);
	if ($volunteerAdd_result) {
		echo
		"<script>alert('Запись успешно добавлена');history.go(-1);
		</script>";
	} else {
		echo
		"<script>alert('Ошибка добавления записи');history.go(-1);</script>";
	}
}
// Добавление записи в таблицу users
if (isset($_POST['userAddBtn'])) {
	$name = $_POST['userAdd_name']; // name
	$email = $_POST['userAdd_email']; // email
	$phone = $_POST['userAdd_phone']; // phone
	$password = $_POST['userAdd_password']; // password
	$role = $_POST['userAdd_role']; // role

	$userAdd =
		"INSERT INTO users (name, email, phone, password, role) VALUES ('$name', '$email', '$phone', '$password', '$role')";
	$userAdd_result = mysqli_query($db, $userAdd);
	if ($userAdd_result) {
		echo
		"<script>alert('Пользователь успешно добавлен');history.go(-1);
        </script>";
	} else {
		echo
		"<script>alert('Ошибка добавления пользователя');history.go(-1);</script>";
	}
}
if (isset($_POST['stausAddBtn'])) {
	$_POST['stausAddBtn'];
	$stausAdd =
		"INSERT INTO statusApp (name) VALUES ('" . $_POST['stausAdd_name'] . "')";
	$stausAdd_result = mysqli_query($db, $stausAdd);
	if ($stausAdd_result) {
		echo
		"<script>alert('Запись успешно добавлена');history.go(-1);
        </script>";
	} else {
		echo
		"<script>alert('Ошибка добавления записи');history.go(-1);</script>";
	}
}
if (isset($_POST['sessionAddBtn'])) {
	$_POST['sessionAddBtn'];
	$sessionAdd =
		"INSERT INTO session (ID_users, dateStart, dateEnd) VALUES ('" . $_POST['sessionAdd_ID_users'] . "',
        '" . $_POST['sessionAdd_dateStart'] . "', 
        '" . $_POST['sessionAdd_dateEnd'] . "')";
	$sessionAdd_result = mysqli_query($db, $sessionAdd);
	if ($sessionAdd_result) {
		echo
		"<script>alert('Запись успешно добавлена');history.go(-1);
        </script>";
	} else {
		echo
		"<script>alert('Ошибка добавления записи');history.go(-1);</script>";
	}
}
