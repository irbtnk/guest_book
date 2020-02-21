<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include_once(__DIR__ . "/classes/DB.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Comment.php");
define("HOST", "localhost");
define("USER", "root");
define("PASSWORD", "");
define("DBNAME", "guestbook");
define("CHARSET", "utf8");
define("SALT", "webDEVblog"); //хеширует пароль в бд

