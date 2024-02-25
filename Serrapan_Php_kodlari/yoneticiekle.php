<?php
require_once "init.php";
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["inputName"]);
    $email = trim($_POST["inputEmail"]);
    $password = trim($_POST["inputPassword"]);
    $control_password=trim($_POST["controlPassword"]);

    if (empty($username) || empty($email) || empty($password) ) {
        $_SESSION["errors"][] = "Lütfen boş alan bırakmayınız.";
        header("Location: yoneticiekle.php");
        exit();
    }
    if(strlen($username)>20){
        $_SESSION["errors"][] = "Kullanıcı adı 20 karakterden fazla olamaz.";
        header("Location: yoneticiekle.php");
        exit();
    }
    $query2 = $db->prepare("SELECT * FROM users WHERE username = ?");
    $query2->execute([$username]);
    $user = $query2->fetch();
    if($user)
    {
        $_SESSION["errors"][] = "Girmiş olduğunuz kullanıcı adı kullanılmaktadır.";
        header("Location: yoneticiekle.php");
        exit();
    }
    if(strlen($password<4)){
        $_SESSION["errors"][] = "Şifre 4 karakterden az olamaz.";
        header("Location: yoneticiekle.php");
        exit();
    }
    if(strlen($password)>20){
        $_SESSION["errors"][] = "Şifre 20 karakterden fazla olamaz.";
        header("Location: yoneticiekle.php");
        exit();
    }
    if($password!=$control_password){
        $_SESSION["errors"][] = "Girmiş olduğunuz şifreler farklıdır.";
        header("Location: yoneticiekle.php");
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("<p>Lütfen geçerli bir e-posta adresin girin!</p>");
    }
    $query3 = $db->prepare("SELECT * FROM users WHERE email = ?");
    $query3->execute([$email]);
    $user2 = $query3->fetch();
    if($user2)
    {
        $_SESSION["errors"][] = "Girmiş olduğunuz email kullanılmaktadır.";
        header("Location: yoneticiekle.php");
        exit();
    }

    $query= $db->prepare("insert into users set username=:username,email=:email,password=:password");
    $sifre_kodu=password_hash($password, PASSWORD_DEFAULT);
    $query->execute(array(
        "username" => $username,
        "email" => $email,
        "password"=>$sifre_kodu
    ));
}
include "header.php";
?>
    <div class="container px-5">
            <!-- breadcrumb -->
            <div class="breadcrumb-header justify-content-between">
                <div class="my-auto">
                    <div class="d-flex">
                        <h4 class="content-title mb-0 my-auto">Yönetici Ekle</h4>
                    </div>
                </div>
            </div>
            <div class="row row-sm">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="card  box-shadow-0 ">
                        <div class="card-header">
                            <h4 class=" mb-1">Yönetici Ekleme Formu</h4>
                            <p class="mb-2">Web sitenizin kontrolü için yönetici ekleyebilirsiniz.</p>

                            <?php if(isset($_SESSION["errors"])) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php
                                    echo implode("<br />", $_SESSION["errors"]);
                                    unset($_SESSION["errors"]);
                                    ?>
                                </div>
                            <?php } ?>

                        </div>
                        <div class="card-body pt-0">
                            <form class="form-horizontal" method="POST">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="inputName" name="inputName" placeholder="Kullanıcı Adı">
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Şifre">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" id="inputPassword" name="controlPassword" placeholder="Şifrenizi yeniden giriniz.">
                                </div>

                                <div class="form-group mb-0 mt-3 justify-content-end">
                                    <div>
                                        <button type="submit" class="btn btn-primary">KAYIT</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            <!-- /Container -->
        </div>
        <!-- /main-content -->

        <!-- Sidebar-right-->
        <div class="sidebar sidebar-right sidebar-animate">
            <div class="panel panel-primary card mb-0 box-shadow">
                <div class="tab-menu-heading border-0 p-3">
                    <div class="card-title mb-0">Notifications</div>
                    <div class="card-options ml-auto">
                        <a href="#" class="sidebar-remove"><i class="fe fe-x"></i></a>
                    </div>
                </div>
                <div class="panel-body tabs-menu-body latest-tasks p-0 border-0">
                    <div class="tabs-menu ">
                        <!-- Tabs -->
                        <ul class="nav panel-tabs">
                            <li class=""><a href="#side1" class="active" data-toggle="tab"><i class="ion ion-md-chatboxes tx-18 mr-2"></i> Chat</a></li>
                            <li><a href="#side2" data-toggle="tab"><i class="ion ion-md-notifications tx-18  mr-2"></i> Notifications</a></li>
                            <li><a href="#side3" data-toggle="tab"><i class="ion ion-md-contacts tx-18 mr-2"></i> Friends</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active " id="side1">
                            <div class="list d-flex align-items-center border-bottom p-3">
                                <div class="">
                                    <span class="avatar bg-primary brround avatar-md">CH</span>
                                </div>
                                <a class="wrapper w-100 ml-3" href="#" >
                                    <p class="mb-0 d-flex ">
                                        <b>New Websites is Created</b>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="mdi mdi-clock text-muted mr-1"></i>
                                            <small class="text-muted ml-auto">30 mins ago</small>
                                            <p class="mb-0"></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="list d-flex align-items-center border-bottom p-3">
                                <div class="">
                                    <span class="avatar bg-danger brround avatar-md">N</span>
                                </div>
                                <a class="wrapper w-100 ml-3" href="#" >
                                    <p class="mb-0 d-flex ">
                                        <b>Prepare For the Next Project</b>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="mdi mdi-clock text-muted mr-1"></i>
                                            <small class="text-muted ml-auto">2 hours ago</small>
                                            <p class="mb-0"></p>
                                        </div>
                                    </div>
                            </div>
                            </a>
                        </div>
                        <div class="list d-flex align-items-center border-bottom p-3">
                            <div class="">
                                <span class="avatar bg-info brround avatar-md">S</span>
                            </div>
                            <a class="wrapper w-100 ml-3" href="#" >
                                <p class="mb-0 d-flex ">
                                    <b>Decide the live Discussion</b>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-clock text-muted mr-1"></i>
                                        <small class="text-muted ml-auto">3 hours ago</small>
                                        <p class="mb-0"></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="list d-flex align-items-center border-bottom p-3">
                            <div class="">
                                <span class="avatar bg-warning brround avatar-md">K</span>
                            </div>
                            <a class="wrapper w-100 ml-3" href="#" >
                                <p class="mb-0 d-flex ">
                                    <b>Meeting at 3:00 pm</b>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-clock text-muted mr-1"></i>
                                        <small class="text-muted ml-auto">4 hours ago</small>
                                        <p class="mb-0"></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="list d-flex align-items-center border-bottom p-3">
                            <div class="">
                                <span class="avatar bg-success brround avatar-md">R</span>
                            </div>
                            <a class="wrapper w-100 ml-3" href="#" >
                                <p class="mb-0 d-flex ">
                                    <b>Prepare for Presentation</b>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-clock text-muted mr-1"></i>
                                        <small class="text-muted ml-auto">1 days ago</small>
                                        <p class="mb-0"></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="list d-flex align-items-center border-bottom p-3">
                            <div class="">
                                <span class="avatar bg-pink brround avatar-md">MS</span>
                            </div>
                            <a class="wrapper w-100 ml-3" href="#" >
                                <p class="mb-0 d-flex ">
                                    <b>Prepare for Presentation</b>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-clock text-muted mr-1"></i>
                                        <small class="text-muted ml-auto">1 days ago</small>
                                        <p class="mb-0"></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="list d-flex align-items-center border-bottom p-3">
                            <div class="">
                                <span class="avatar bg-purple brround avatar-md">L</span>
                            </div>
                            <a class="wrapper w-100 ml-3" href="#" >
                                <p class="mb-0 d-flex ">
                                    <b>Prepare for Presentation</b>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-clock text-muted mr-1"></i>
                                        <small class="text-muted ml-auto">45 mintues ago</small>
                                        <p class="mb-0"></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="list d-flex align-items-center p-3">
                            <div class="">
                                <span class="avatar bg-blue brround avatar-md">U</span>
                            </div>
                            <a class="wrapper w-100 ml-3" href="#" >
                                <p class="mb-0 d-flex ">
                                    <b>Prepare for Presentation</b>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-clock text-muted mr-1"></i>
                                        <small class="text-muted ml-auto">2 days ago</small>
                                        <p class="mb-0"></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
include "footer.php";
?>