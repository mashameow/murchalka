<?php
session_start();


$application_stmt = $db->prepare("SELECT  ID_pets FROM application WHERE ID_users =?");
$application_stmt->bind_param("i", $_SESSION['user_id']);
$application_stmt->execute();
$application_result = $application_stmt->get_result();

if ($application_result->num_rows > 0) {
	$application_data = $application_result->fetch_assoc();
	$_SESSION['user_pet'] = $application_data['ID_pets'];
}
