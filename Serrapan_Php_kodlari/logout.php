<?php
require_once "init.php";

unset($_SESSION["user"]);
session_destroy();
header("Location: login.php");