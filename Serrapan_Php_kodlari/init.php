<?php
if(!session_id())
{
	session_start();
}

require_once "db.php";
date_default_timezone_set('Europe/Istanbul');
$visitor = null;
date_default_timezone_set('Europe/Istanbul');date_default_timezone_set('Europe/Istanbul');
if(isset($_SESSION["user"]))
{
	$query = $db->prepare("SELECT * FROM users WHERE user_id = ?");
	$query->execute([$_SESSION["user"]]);
	$visitor = $query->fetch();
}