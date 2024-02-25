<?php
require_once "init.php";

if(!$visitor)
{
    header("Location: login.php");
    exit();
}


$data = $db->prepare("SELECT * FROM proje");
$data->execute();
$projeList=$data->fetchAll(PDO::FETCH_OBJ);

include "header.php";

?>

    <div class="row row-sm" style="margin: 20px" >
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">Projelerin Listesi</h4>

                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">Projeleri buradan görüntüleyebilirsiniz.</p>
                </div>
                <div class="card-body">
                    <?php if(isset($_SESSION["errors"])) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?php
                            echo implode("<br />", $_SESSION["errors"]);
                            unset($_SESSION["errors"]);
                            ?>
                        </div>
                    <?php } ?>
                    <div class="table-responsive">
                        <table class="table table-striped mg-b-0 text-md-nowrap">
                            <thead>
                            <tr>
                                <th>FOTOĞRAF</th>
                                <th>BAŞLIK</th>
                                <th>İÇERİK</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ( $projeList as $proje) {?>
                                <tr>
                                    <td> <?php if(!empty($proje->fotograf)) { ?>
                                            <div class="row">
                                                <div class="col-md-12" >
                                                    <img src="../uploads/<?= $proje->fotograf; ?>" style="max-width: 80px; margin-left: 13px" />
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </td>

                                    <td style="padding-top: 40px;"> <?= $proje->baslik ?></td>
                                    <td style="padding-top: 40px;"> <?= $proje->icerik ?></td>
                                    <td style="padding-top: 30px;" >
                                        <a href="projeduzenle.php?proje_id=<?= $proje->proje_id ?>" class="btn btn-primary ">Düzenle</a>
                                        <a href="projesil.php?proje_id=<?= $proje->proje_id ?>" class="btn btn-danger ">Sil</a>
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