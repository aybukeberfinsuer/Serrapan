<?php
require_once "init.php";

if(!$visitor)
{
    header("Location: login.php");
    exit();
}


$read_data = $db->prepare("SELECT * FROM users");
$read_data->execute();
$personelList=$read_data->fetchAll(PDO::FETCH_OBJ);

include "header.php";

?>

 <div class="row row-sm" style="margin: 20px" >
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">Yöneticilerin Listesi</h4>

                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">Yönetici bilgilerini buradan görüntüleyebilirsiniz.</p>
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
                                <th>ID</th>
                                <th>KULLANICI ADI</th>
                                <th>MAİL ADRESİ</th>
                                <th>İşlemler</th>

                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach ( $personelList as $person) {?>
                                    <tr>
                                        <td scope="row"> <?= $person->user_id ?> </td>
                                        <td> <?= $person->username ?></td>
                                        <td> <?= $person->email ?></td>
                                        <td>
                                            <a href="yoneticiduzenle.php?user_id=<?= $person->user_id ?>" class="btn btn-primary btn-sm">Düzenle</a>
                                           <?php if($person->user_id != $visitor->user_id) { ?>
                                            <a href="yoneticisil.php?user_id=<?= $person->user_id ?>" class="btn btn-danger btn-sm">Sil</a>
                                            <?php } ?>
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