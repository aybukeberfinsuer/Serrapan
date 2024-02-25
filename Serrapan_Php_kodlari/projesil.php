<?php
require_once "init.php";

if (!$visitor) {
    header("Location: login.php");
    exit();
}
$proje_id = $_GET["proje_id"];


if(empty($proje_id))
{
    $_SESSION["errors"][] = "ad";
    header("Location: projelergoster.php");
    exit();
}

else {
    $delete_data = $db->prepare("DELETE FROM proje WHERE proje_id = ?");
    $delete_data->execute([$proje_id]);

    $query = $db->query("SELECT COUNT(*) FROM proje");
    $count = $query->fetchColumn();

    if($count!=0) {
        $_SESSION["errors"][] = "Proje silindi";
        header("Location: projelergoster.php");
        exit();
    }
    else{
        header("Location: projelergoster.php");
        exit();
    }

}
include "header.php";
?>



<?php
include "footer.php";
?>