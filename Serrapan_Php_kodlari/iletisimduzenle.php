<?php
require_once "init.php";

if(!$visitor)
{
    header("Location: login.php");
    exit();
}

$data = $db->query("SELECT * FROM iletisimaciklama WHERE id = 1")->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $baslik = $_POST["baslik"];
    $icerik = $_POST["icerik"];


    $query=$db->prepare("UPDATE iletisimaciklama SET baslik=:baslik,icerik=:icerik WHERE id = 1");
    $query->execute([
            "baslik"=>$baslik,
            "icerik" =>$icerik
    ]);

}
include "header.php";
?>
    <div style="margin: 10px " class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
            <!--div-->
            <div class="card" style="padding: 5px; margin-top:10px">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        Başlık &amp; İçerik
                    </div>
                    <p class="mg-b-20">İletişim bölümündeki formun yanındaki kısmın yazı düzenlemesini buradan yapabilirsiniz.</p>
                    <form action="<?= $_SERVER["PHP_SELF"]; ?>" method="post">
                        <div class="row row-sm col-lg-8">
                            <div class="col-lg">
                                <input name="baslik" class="form-control" placeholder="Input box" value="<?= $data->baslik; ?>" type="text">
                            </div>
                        </div>
                        <div class="row row-sm mg-t-20 col-lg-8">
                            <div class="col-lg">
                                <textarea name="icerik" class="form-control" placeholder="Textarea" rows="3"><?= $data->icerik; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group mb-0 mt-3 justify-content-end">
                            <div style="margin-left: 10px">
                                <button type="submit" class="btn btn-primary">KAYDET</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php
include "footer.php";
?>