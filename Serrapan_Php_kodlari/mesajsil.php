<?php
require_once "init.php";

if (!$visitor) {
    header("Location: login.php");
    exit();
}
$kullanici_id = $_GET["kullanici_id"];


if(empty($kullanici_id))
{
    $_SESSION["errors"][] = "ad";
    header("Location: iletisim.php");
    exit();
}

else {
    $delete_data = $db->prepare("DELETE FROM iletisim WHERE kullanici_id = ?");
    $delete_data->execute([$kullanici_id]);

    $query = $db->query("SELECT COUNT(*) FROM iletisim");
    $count = $query->fetchColumn();

    if($count!=0) {
        $_SESSION["errors"][] = "Mesaj silindi";
        header("Location: iletisim.php");
        exit();
    }
    else{
        header("Location: iletisim.php");
        exit();
    }

}

include "header.php";
?>



