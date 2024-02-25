<?php
include "init.php";

if(!$visitor)
{
    header("Location: login.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $misyon=$_POST["misyon"];
    $vizyon=$_POST["vizyon"];

    $query=$db->prepare("update hakkimizda set misyon=:misyon,vizyon=:vizyon where hakkimizda_id=1");
    $query->execute(array(
            "misyon"=>$misyon,
            "vizyon"=>$vizyon
   ));
    $data = $db->query("SELECT * FROM hakkimizda WHERE hakkimizda_id = 1")->fetch();

}
include "header.php";
?>
<div style="margin: 10px " class="row">
    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
        <!--div-->
        <div class="card" style="padding: 5px; margin-top:10px">
            <div class="card-body">
                <div class="main-content-label mg-b-5">
                    Misyonumuz & Vizyonumuz
                </div>
                <p class="mg-b-20">Hakkımızda bölümündeki yazı düzenlemesini buradan yapabilirsiniz.</p>
                <form action="<?= $_SERVER["PHP_SELF"]; ?>" method="post">

                    <p class="mg-b-20" style="margin-left: 14px">Misyonumuz:</p>

                    <div class="row row-sm mg-t-20 col-lg-8">
                        <div class="col-lg">
                            <textarea name="misyon" class="form-control" placeholder="Textarea" rows="3"><?= $data->misyon; ?></textarea>
                        </div>
                    </div>
                    <p class="mg-b-20" style="margin-top: 20px; margin-left: 14px">Vizyonumuz:</p>

                    <div class="row row-sm mg-t-20 col-lg-8">
                        <div class="col-lg">
                            <textarea name="vizyon" class="form-control" placeholder="Textarea" rows="3"><?= $data->vizyon; ?></textarea>
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

<?php include "footer.php"; ?>
