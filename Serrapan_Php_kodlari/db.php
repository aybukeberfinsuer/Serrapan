<?php
$db = null;
$dbname = 'dbdeneme';
try {
    $db = new PDO("mysql:host=localhost;dbname={$dbname};charset=utf8", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
}
catch(PDOException $e)
{
    exit( $e->getMessage());
}