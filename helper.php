<?php
session_start();


if (!isset($_SESSION['messaging_username']) || $_SESSION['messaging_username'] == "") {
	header('location: logout');
}

// if ($_SESSION['messaging_username'] == "") {
// 	header('location: logout');
// }

include_once(__DIR__."/dashboard/controller/controller.php");
include_once(__DIR__."/dashboard/controller/boot.php");
include_once(__DIR__."/dashboard/settings/class/SecurityService.php");


$antiCSRF = new \HCI\SecurityService\securityService();
$csrfResponse = json_decode($antiCSRF->validate(), true);
// var_dump($csrfResponse);exit;

if ($csrfResponse['valid'] == false) {
	return json_encode(array('response_code' => 20, 'response_message' => $csrfResponse['response_message']));
}

foreach (glob(__DIR__."/dashboard/settings/class/*.php") as $class) {
	include_once($class);
}

$controller = new Controller();

// echo $controller->GrantPermission();
echo $controller->autoLoader($_REQUEST);