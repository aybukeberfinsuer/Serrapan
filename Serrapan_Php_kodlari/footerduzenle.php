<?php
include "init.php";

if(!$visitor)
{
    header("Location: login.php");
    exit();
}
if($_SERVER["REQUEST_METHOD"]=="POST"){

    $aciklama= trim($_POST["aciklama"]);
    $telefon= ($_POST["telefon"]);
    $mail= trim($_POST["mail"]);
    $adres= trim($_POST["adres"]);
    $calisma=($_POST["calisma"]);

if(!empty($mail)) {
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["errors"][] = "Lütfen geçerli bir mail adresi giriniz..";
        header("Location: footerduzenle.php");
        exit();
    }
}

    if(strlen($adres)>100){
        $_SESSION["errors"][] = "Girdiğiniz adres 100 karakteri aşmaktadır..";
        header("Location: footerduzenle.php");
        exit();
    }
    if(strlen($telefon)<11 && strlen($telefon)>0){
        $_SESSION["errors"][] = "Geçerli bir telefon hanesi girin.";
        header("Location: footerduzenle.php");
        exit();
    }

    if(strlen($aciklama)>120){
        $_SESSION["errors"][] = "Girdiğiniz açıklama yazısı 120 karakteri aşmaktadır. .";
        header("Location: footerduzenle.php");
        exit();
    }

    $query=$db->prepare("update footer set aciklama=:aciklama,calisma=:calisma,telefon=:telefon,mail=:mail,adres=:adres where footer_id=1");
    $query->execute(array(
            "aciklama"=>$aciklama,
            "calisma" =>$calisma,
            "telefon"=>$telefon,
            "mail"=>$mail,
            "adres"=>$adres
    ));
}
$data = $db->query("SELECT * FROM footer WHERE footer_id = 1")->fetch();
include "header.php";
?>

<div style="margin: 10px " class="row">
    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
        <!--div-->
        <div class="card" style="padding: 5px; margin-top:10px">
            <div class="card-body">
                <div class="main-content-label mg-b-5" style="margin-bottom: 20px">
                    Footer Bölümü Düzenleme
                </div>
                <?php if(isset($_SESSION["errors"])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php
                        echo implode("<br />", $_SESSION["errors"]);
                        unset($_SESSION["errors"]);
                        ?>
                    </div>
                <?php } ?>
                <form action="<?= $_SERVER["PHP_SELF"]; ?>" method="post">
                    <p  style="margin-left: 14px">Telefon Numarası</p>
                    <div class="row row-sm mg-t-20 col-lg-8">
                        <div class="col-lg" style="margin-bottom: 20px;">
                            <input name="telefon" class="form-control" placeholder="Input box" type="text" value="<?= $data->telefon; ?>" >
                        </div>
                    </div>

                    <p  style="margin-left: 14px; margin-top: 20px;">Çalışma Saatleri</p>
                    <div class="row row-sm mg-t-20 col-lg-8">
                        <div class="col-lg" style="margin-bottom: 20px;">
                            <textarea name="calisma" class="form-control" placeholder="Textarea" rows="3"><?= $data->calisma; ?></textarea>
                        </div>
                    </div>

                    <p  style="margin-left: 14px; margin-top: 20px;">Açıklama</p>
                    <div class="row row-sm mg-t-20 col-lg-8">
                        <div class="col-lg" style="margin-bottom: 20px;">
                            <textarea name="aciklama" class="form-control" placeholder="Textarea" rows="3"><?= $data->aciklama; ?></textarea>
                        </div>
                    </div>

                    <p  style="margin-left: 14px">Mail Adresi</p>
                    <div class="row row-sm mg-t-20 col-lg-8">
                        <div class="col-lg" style="margin-bottom: 20px;">
                            <input name="mail" class="form-control" placeholder="Input box" type="text" value="<?= $data->mail; ?>">
                        </div>
                    </div>

                    <p  style="margin-left: 14px">Adres Bilgisi</p>
                    <div class="row row-sm mg-t-20 col-lg-8">
                        <div class="col-lg" style="margin-bottom: 20px;">
                            <textarea name="adres" class="form-control" placeholder="Textarea" rows="3"><?= $data->adres; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group mb-0 mt-3 justify-content-end">
                        <div style="margin-left: 10px" >
                            <button type="submit" class="btn btn-primary">KAYDET</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>









<?php include "footer.php"; ?>






