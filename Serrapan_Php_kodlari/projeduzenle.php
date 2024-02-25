<?php
include "init.php";

if (!$visitor) {
    header("Location: login.php");
    exit();
}

$proje_id = $_GET["proje_id"];

if(empty($proje_id))
{
    header("Location: projelergoster.php");
    exit();
}

$query = $db->prepare("SELECT * FROM proje WHERE proje_id = ?");
$query->execute([$proje_id]);
$proje = $query->fetch();


if (!$proje) {
    $_SESSION["errors"][] = "Proje bulunamadı.";
    header("Location: projelergoster.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $baslik = trim($_POST["baslik"]);
    $icerik = trim($_POST["icerik"]);
    $resim = $_FILES["resim"];

    $hatalar = [];

    if (empty($baslik) || empty($icerik))
    {
        $hatalar[] = "Boş alan bırakmayınız.";
    }
    if (!empty($resim["name"]))
    {
        if ($resim["error"] != 0)
        {
            $hatalar[] = "Resim yüklenemedi";
        }
        else if ($resim["size"] > 1024*1024*2)
        {
            $hatalar[] = "Dosya boyutu 2MB'dan fazla olamaz.";
        }
        else if (!in_array($resim["type"], ["image/png", "image/jpg", "image/jpeg"]))
        {
            $hatalar[] = "Sadece png ve jpg formatı desteklenir. ";
        }
        else
        {
            $uzanti = explode(".", $resim["name"])[1];
            /** dosya adını noktalara göre bölerek, adı ve uzantısını ayırır
             * ve bu iki parçayı bir dizi içinde döndürür. [1] indeksi,
             * bu dizinin ikinci elemanını yani dosya uzantısını temsil eder
             * */

            if (!in_array($uzanti, ["png", "jpg", "jpeg"]))
            {
                $hatalar[] = "Sadece png ve jpg formatı desteklenir. :(";
            }
            else
            {
                $dosyaAdi = $proje->proje_id .'-'.md5_file($resim["tmp_name"]).".{$uzanti}";
                $srcDir = dirname(__DIR__);

                if (!move_uploaded_file($resim["tmp_name"], $srcDir."/uploads/{$dosyaAdi}"))
                {
                    $hatalar[] = "Resim yüklenemedi.";
                }
                else
                {
                    @unlink($srcDir . "/uploads/{$proje->fotograf}");
                    $resim = $dosyaAdi;
                }
            }
        }
    }
    else
    {
        $resim = $proje->fotograf;
    }

    if ($hatalar)
    {
        $_SESSION["errors"] = $hatalar;
        header("Location: projeler.php");
        exit();
    }


    //$query = $db->prepare("insert into proje set baslik=:baslik, icerik=:icerik,fotograf=:fotograf");
    $query = $db->prepare("UPDATE proje SET baslik = :baslik, icerik = :icerik, fotograf = :fotograf WHERE proje_id = :proje_id");
    $result = $query->execute([
        "baslik"=>$baslik,
        "icerik"=>$icerik,
        "fotograf"=>$resim,
        "proje_id" => $proje->proje_id
    ]);

    $db = null;

    if(!$result)
    {
        $_SESSION["errors"] = "Güncelleştirilemedi.";
    }
    else
    {
        $_SESSION["success"][] = "Başarıyla düzenlendi.";
    }

    header("Location: projelergoster.php");
    exit();
}

include "header.php";
?>


    <div style="margin: 10px " class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
            <!--div-->
            <div class="card" style="padding: 5px; margin-top:20px">
                <?php if(isset($_SESSION["errors"])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php
                        echo implode("<br />", $_SESSION["errors"]);
                        unset($_SESSION["errors"]);
                        ?>
                    </div>
                <?php } ?>
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        Proje tanıtım bölümü
                    </div>
                    <p class="mg-b-20">Projeler bölümündeki yazı düzenlemesini buradan yapabilirsiniz.</p>
                    <form class="form-horizontal" action="<?= $_SERVER["PHP_SELF"].'?proje_id='.$proje->proje_id; ?>" method="POST" enctype="multipart/form-data">
                        <div class="row row-sm col-lg-8">
                            <div class="col-lg">
                                <input name="baslik" class="form-control" placeholder="Başlık" value="<?= $proje->baslik; ?>" type="text">
                            </div>
                        </div>
                        <div class="row row-sm mg-t-20 col-lg-8">
                            <div class="col-lg">
                                <textarea name="icerik" class="form-control" placeholder="İçerik" rows="3"><?= $proje->icerik; ?></textarea>
                            </div>
                        </div>
                        <?php if(!empty($proje->fotograf)) { ?>
                            <div class="row">
                                <div class="col-md-12" >
                                    <img src="../uploads/<?= $proje->fotograf; ?>" style="max-width: 150px; margin-left: 13px" />
                                </div>
                            </div>
                        <?php } ?>
                        <div class="row row-sm mg-t-20 col-lg-8 form-group">
                            <div class="col-lg custom-file" >
                                <input type="file" class="custom-file-input" name="resim"/>
                                <label class="custom-file-label"  style="width: 97%; margin-left:10px">Seçiniz</label>
                            </div>
                        </div>
                        <div class="form-group mb-0 mt-3 justify-content-end">
                            <div style="margin-left: 10px">
                                <button type="submit" class="btn btn-primary">GÜNCELLE</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php include "footer.php";
