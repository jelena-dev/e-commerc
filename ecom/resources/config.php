<?php
ob_start();
session_start();
//session_destroy();

//definisanje path
//znak ? se tumaci ovako: ako je definisano onda je null ako nije definisi
defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);

defined("TEMPLATE_FRONT") ?     null : define("TEMPLATE_FRONTEND", __DIR__ . DS . "templates/frontend");
defined("TEMPLATE_FRONT") ?     null : define("TEMPLATE_BACKEND", __DIR__ . DS . "templates/backend");
defined("UPLOAD_DIRECTORY") ? null : define("UPLOAD_DIRECTORY", __DIR__ . DS . "uploads");

defined("DB_HOST") ?     null : define("DB_HOST", "localhost");
defined("DB_USER") ?     null : define("DB_USER", "root");
defined("DB_PASS") ?     null : define("DB_PASS", "");
defined("DB_NAME") ?     null : define("DB_NAME", "ecom");



$connection=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

require_once('functions.php');
require_once('cart.php');



?>