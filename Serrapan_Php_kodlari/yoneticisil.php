    <?php
    require_once "init.php";

    if (!$visitor) {
        header("Location: login.php");
        exit();
    }
    $userId = $_GET["user_id"];


    if(empty($userId))
    {   $_SESSION["errors"][] = "Kullanıcı bulunamadı.";
        header("Location: yoneticigoster.php");
        exit();
    }

    else {
        $delete_data = $db->prepare("DELETE FROM users WHERE user_id = ?");
        $delete_data->execute([$userId]);
        $_SESSION["errors"][] = "Kullanıcı silindi";
        header("Location: yoneticigoster.php");
        exit();
    }

    include "header.php";
    ?>




<?php
include "footer.php";
?>

