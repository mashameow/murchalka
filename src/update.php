<?php
$db = mysqli_connect('localhost', 'root', '', 'murchalka');

if (!$db) {
	die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}
// изменяем в application
if (isset($_POST['applicationUpBtn'])) {
	$idApplication = $_POST['applicationUp_ID_application']; // ID_aplication
	$comment = $_POST['applicationUp_comment']; // comment
	$idUser = $_POST['applicationUp_ID_users']; // ID_users
	$idPet = $_POST['applicationUp_ID_pets']; // ID_pets
	$idStatus = $_POST['applicationUp_ID_status']; // ID_statusApp
	$number = $_POST['applicationUp_number']; // number

	$updateQuery = "UPDATE application SET ";
	$updateValues = array();

	if (!empty($comment)) {
		$updateValues[] = "comment = '$comment'";
	}
	if (!empty($idUser)) {
		$updateValues[] = "ID_users = '$idUser'";
	}
	if (!empty($idPet)) {
		$updateValues[] = "ID_pets = '$idPet'";
	}
	if (!empty($idStatus)) {
		$updateValues[] = "ID_statusApp = '$idStatus'";
	}
	if (!empty($number)) {
		$updateValues[] = "number = '$number'";
	}

	if (!empty($updateValues)) {
		$updateQuery .= implode(', ', $updateValues);
		$updateQuery .= " WHERE ID_application = '$idApplication'";

		$result = mysqli_query($db, $updateQuery);
		if ($result) {
			echo "<script>alert('Данные успешно изменены');history.go(-1);</script>";
		} else {
			echo "<script>alert('Ошибка изменения данных');history.go(-1);</script>";
		}
	} else {
		echo "<script>alert('Нет данных для изменения');history.go(-1);</script>";
	}
}
// изменяем в family
if (isset($_POST['familyUpBtn'])) {
	$idFamily = $_POST['familyUp_ID_family']; // ID_family
	$number = $_POST['familyUp_number']; // number

	$updateQuery = "UPDATE family SET ";
	$updateValues = array();

	if (!empty($number)) {
		$updateValues[] = "number = '$number'";
	}

	if (!empty($updateValues)) {
		$updateQuery .= implode(', ', $updateValues);
		$updateQuery .= " WHERE ID_family = '$idFamily'";

		$result = mysqli_query($db, $updateQuery);
		if ($result) {
			echo "<script>alert('Данные успешно изменены');history.go(-1);</script>";
		} else {
			echo "<script>alert('Ошибка изменения данных');history.go(-1);</script>";
		}
	} else {
		echo "<script>alert('Нет данных для изменения');history.go(-1);</script>";
	}
}
// изменяем в pets
if (isset($_POST['petUpBtn'])) {
	$idPet = $_POST['petUp_ID_pets']; // ID_pets
	$name = $_POST['petUp_name']; // name
	$age = $_POST['petUp_age']; // age
	$floor = $_POST['petUp_floor']; // floor
	$idHealthConditions = $_POST['petUp_ID_healthConditions']; // ID_healthConditions
	$history = $_POST['petUp_history']; // history
	$features = $_POST['petUp_features']; // features
	$photo = $_POST['petUp_photo']; // photo
	$status = $_POST['petUp_status']; // status
	$dateReceipt = $_POST['petUp_dateReceipt']; // dateReceipt
	$idVolunteer = $_POST['petUp_ID_volunteer']; // ID_volunteer
	$idFamily = $_POST['petUp_ID_family']; // ID_family
	$kind = $_POST['petUp_kind']; // kind

	$updateQuery = "UPDATE pets SET ";
	$updateValues = array();

	if (!empty($name)) {
		$updateValues[] = "name = '$name'";
	}
	if (!empty($age)) {
		$updateValues[] = "age = '$age'";
	}
	if (!empty($floor)) {
		$updateValues[] = "floor = '$floor'";
	}
	if (!empty($idHealthConditions)) {
		$updateValues[] = "ID_healthConditions = '$idHealthConditions'";
	}
	if (!empty($history)) {
		$updateValues[] = "history = '$history'";
	}
	if (!empty($features)) {
		$updateValues[] = "features = '$features'";
	}
	if (!empty($photo)) {
		$updateValues[] = "photo = '$photo'";
	}
	if (!empty($status)) {
		$updateValues[] = "status = '$status'";
	}
	if (!empty($dateReceipt)) {
		$updateValues[] = "dateReceipt = '$dateReceipt'";
	}
	if (!empty($idVolunteer)) {
		$updateValues[] = "ID_volunteer = '$idVolunteer'";
	}
	if (!empty($idFamily)) {
		$updateValues[] = "ID_family = '$idFamily'";
	}
	if (!empty($kind)) {
		$updateValues[] = "kind = '$kind'";
	}

	if (!empty($updateValues)) {
		$updateQuery .= implode(', ', $updateValues);
		$updateQuery .= " WHERE ID_pets = '$idPet'";

		$result = mysqli_query($db, $updateQuery);
		if ($result) {
			echo "<script>alert('Данные успешно изменены');history.go(-1);</script>";
		} else {
			echo "<script>alert('Ошибка изменения данных');history.go(-1);</script>";
		}
	} else {
		echo "<script>alert('Нет данных для изменения');history.go(-1);</script>";
	}
}

// изменяем в volunteer
if (isset($_POST['volunteerUpBtn'])) {
	$idVolunteer = $_POST['volunteerUp_ID_volunteer']; // ID_volunteer
	$fio = $_POST['volunteerUp_FIO']; // FIO
	$phone = $_POST['volunteerUp_phone']; // phone
	$email = $_POST['volunteerUp_email']; // email
	$specialization = $_POST['volunteerUp_specialization']; // specialization

	$updateQuery = "UPDATE volunteer SET ";
	$updateValues = array();

	if (!empty($fio)) {
		$updateValues[] = "FIO = '$fio'";
	}
	if (!empty($phone)) {
		$updateValues[] = "phone = '$phone'";
	}
	if (!empty($email)) {
		$updateValues[] = "email = '$email'";
	}
	if (!empty($specialization)) {
		$updateValues[] = "specialization = '$specialization'";
	}

	if (!empty($updateValues)) {
		$updateQuery .= implode(', ', $updateValues);
		$updateQuery .= " WHERE ID_volunteer = '$idVolunteer'";

		$result = mysqli_query($db, $updateQuery);
		if ($result) {
			echo "<script>alert('Данные успешно изменены');history.go(-1);</script>";
		} else {
			echo "<script>alert('Ошибка изменения данных');history.go(-1);</script>";
		}
	} else {
		echo "<script>alert('Нет данных для изменения');history.go(-1);</script>";
	}
}

// изменяем в users

if (isset($_POST['userUpBtn'])) {
	$idUsers = $_POST['userUp_ID_users']; // ID_users
	$name = $_POST['userUp_name']; // name
	$email = $_POST['userUp_email']; // email
	$phone = $_POST['userUp_phone']; // phone
	$password = $_POST['userUp_password']; // password
	$role = $_POST['userUp_role']; // role

	$updateQuery = "UPDATE users SET ";
	$updateValues = array();

	if (!empty($name)) {
		$updateValues[] = "name = '$name'";
	}
	if (!empty($email)) {
		$updateValues[] = "email = '$email'";
	}
	if (!empty($phone)) {
		$updateValues[] = "phone = '$phone'";
	}
	if (!empty($password)) {
		$updateValues[] = "password = '$password'";
	}
	if (!empty($role)) {
		$updateValues[] = "role = '$role'";
	}

	if (!empty($updateValues)) {
		$updateQuery .= implode(', ', $updateValues);
		$updateQuery .= " WHERE ID_users = '$idUsers'";

		$result = mysqli_query($db, $updateQuery);
		if ($result) {
			echo "<script>alert('Данные успешно изменены');history.go(-1);</script>";
		} else {
			echo "<script>alert('Ошибка изменения данных');history.go(-1);</script>";
		}
	} else {
		echo "<script>alert('Нет данных для изменения');history.go(-1);</script>";
	}
}
