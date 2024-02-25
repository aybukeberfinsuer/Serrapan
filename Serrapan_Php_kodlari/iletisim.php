<?php
include "init.php";
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $ad_soyad = trim($_POST["ad_soyad"]);
    $iletisim_mail = trim($_POST["iletisim_mail"]);
    $telefon = trim($_POST["telefon"]);
    $aciklama = trim($_POST["aciklama"]);
    $tarih=date("Y-m-d h:i:s");

    if(empty($ad_soyad || $iletisim_mail ||$telefon || $aciklama)){
        $_SESSION["errors"][] = "Lütfen boş alan bırakmayınız.";
        header("Location: ../index.php#iletisim");
        exit();

    }
    if (!filter_var($iletisim_mail, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["errors"][] = "Lütfen geçerli bir mail adresi giriniz.";
        header("Location: ../index.php#iletisim");
        exit();
    }
    if(strlen($aciklama)>300){
        $_SESSION["errors"][] = "Girdiğiniz dizin 300 karakterden az olmalı.";
        header("Location: ../index.php#iletisim");
        exit();
    }
    if(strlen($telefon)>11){
        $_SESSION["errors"][] = "Telefon numara hanesini kontrol ediniz.";
        header("Location: ../index.php#iletisim");
        exit();
    }

    $query = $db->prepare("INSERT INTO iletisim (ad_soyad, iletisim_mail, telefon, aciklama,tarih) VALUES (:ad_soyad, :iletisim_mail, :telefon, :aciklama, :tarih)");
    $query->execute(array(
        "ad_soyad" => $ad_soyad,
        "iletisim_mail" => $iletisim_mail,
        "telefon" => $telefon,
        "aciklama" => $aciklama,
        "tarih" =>$tarih
    ));
    header("Location: ../index.php");

}

$query2 = $db->prepare("SELECT * FROM iletisim");
$query2->execute();
$personelList = $query2->fetchAll(PDO::FETCH_OBJ);



include "header.php";
?>

<div class="row row-sm" style="margin: 20px" >
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">Mesajlar Listesi</h4>
                </div>
                <div class="col-lg-6" style="padding: 0">
                <?php if(isset($_SESSION["errors"])) { ?>
                    <div class="alert alert-danger" role="alert" style=" margin-top: 16px">
                        <?php
                        echo implode("<br />", $_SESSION["errors"]);
                        unset($_SESSION["errors"]);
                        ?>
                    </div>
                <?php } ?>

                </div>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped mg-b-0 text-md-nowrap">
                        <thead>
                        <tr>
                            <th>Mesaj ID</th>
                            <th>AD & SOYAD</th>
                            <th>MAİL ADRESİ</th>
                            <th>TELEFON</th>
                            <th>TARİH & SAAT</th>
                            <th>MESAJ</th>
                        </tr>
                        </thead>
                        <?php if($personelList==null){ ?>
                            <td colspan="6"><div style="padding-bottom: 15px; width: 100%; height: 25px"> <p style="text-align: center">⚠️Hiç Mesajınız Yoktur.</p></div></td>

                        <?php } ?>

                        <tbody>
                        <?php foreach ($personelList as $person) {?>
                            <tr>
                                <td scope="row"> <?= $person->kullanici_id ?> </td>
                                <td> <?= $person->ad_soyad ?></td>
                                <td> <?= $person->iletisim_mail ?></td>
                                <td> <?= $person->telefon ?></td>
                                <td> <?= $person->tarih ?></td>
                                <td>
                                    <a href="mesajdetay.php?kullanici_id=<?= $person->kullanici_id ?>" class="btn btn-primary btn-sm">Mesajı Gör</a>
                                    <a href="mesajsil.php?kullanici_id=<?= $person->kullanici_id ?>" class="btn btn-danger btn-sm">Sil</a>

                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>

                    </table>
                </div><!-- bd -->
            </div><!-- bd -->
        </div><!-- bd -->
    </div>
</div>



<?php
include "footer.php";
?>
