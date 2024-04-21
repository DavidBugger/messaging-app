<?php

session_start();
// print_r(__DIR__. "/dashboard/controller/controller.php");
include_once(__DIR__."/dashboard/controller/controller.php");
include_once(__DIR__."/dashboard/controller/boot.php");

// print_r($_REQUEST);
// exit;

// foreach (glob(__DIR__."/admin/settings/class/*.php") as $class) {
//     include_once($class);
// }


$controller = new Controller();

echo $controller->autoLoader($_REQUEST);