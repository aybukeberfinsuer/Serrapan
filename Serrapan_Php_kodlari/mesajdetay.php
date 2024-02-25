<?php
require_once "init.php";



if (!$visitor) {
    header("Location: login.php");
    exit();
}
$kullanici_id = $_GET["kullanici_id"];

if(empty($kullanici_id))
{
    $_SESSION["errors"][] = "Mesaj bulunamadı.";
    header("Location: yoneticigoster.php");
    exit();
}


$query=$db->prepare("select * from iletisim where kullanici_id=?");
$query->execute(["$kullanici_id"]);
$user = $query->fetch();


include "header.php";
?>
<div class="col-md-12 mg-md-t-0" style="margin-top: 20px">
    <div class="card">
        <div class="card-header tx-medium bd-0 tx-white bg-primary">
            <?= $user->kullanici_id; ?>
            <?php echo ')'; ?>
            <?= $user->ad_soyad; ?>
        </div>
        <div class="card-body ">
            <p class="mg-b-0"><?php echo 'Metin:'; ?></p>
            <p class="mg-b-0"><?= $user->aciklama; ?></p>
            <p class="mg-b-0" style="margin-top: 10px"><?php echo 'İletişim Bilgileri:'; ?></p>
            <p class="mg-b-0"><?= $user->iletisim_mail; ?></p>
            <p class="mg-b-0"><?= $user->telefon; ?></p>
            <p class="mg-b-0"><?= $user->tarih; ?></p>
        </div>
        <a href="iletisim.php" class="btn btn-primary-gradient btn-sm " style="width: 50%; margin-left: 20%; margin-bottom: 20px">Geri</a>

    </div>
</div>


<?php
include "footer.php";
?>

