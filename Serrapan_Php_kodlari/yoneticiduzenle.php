<?php
require_once "init.php";

if (!$visitor) {
    header("Location: login.php");
    exit();
}

$userId = $_GET["user_id"];

if(empty($userId))
{
    header("Location: yoneticigoster.php");
    exit();
}

$query = $db->prepare("SELECT * FROM users WHERE user_id = ?");
$query->execute([$userId]);
$user = $query->fetch();


if (!$user) {
    $_SESSION["errors"][] = "Kullanıcı bulunamadı.";
    header("Location: yoneticigoster.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["kullanici_adi"]);
    $email = trim($_POST["email"]);
    $new_password = trim($_POST["yeni_sifre"]);
    $control_password = trim($_POST["yeni_sifre_tekrar"]);

    if (empty($username) || empty($email)) {
        $_SESSION["errors"][] = "Boş alan bırakmayınız.";
        header("Location: yoneticiduzenle.php?user_id={$user->user_id}");
        exit();
    }

    $query2 = $db->prepare("SELECT * FROM users WHERE username = ? AND user_id != ?");
    $query2->execute([$username, $userId]);
    if($query2->fetch())
    {
        $_SESSION["errors"][] = "Girmiş olduğunuz kullanıcı adı kullanılmaktadır.";
        header("Location: yoneticiduzenle.php?user_id={$user->user_id}");
        exit();
    }

    $query3 = $db->prepare("SELECT * FROM users WHERE email = ? AND user_id != ?");
    $query3->execute([$email, $userId]);
    if($query3->fetch())
    {
        $_SESSION["errors"][] = "Girmiş olduğunuz email kullanılmaktadır.";
        header("Location: yoneticiduzenle.php?user_id={$user->user_id}");
        exit();
    }

    if (!empty($new_password))
    {
        if (strlen($new_password) < 4) {
            $_SESSION["errors"][] = "Şifre 4 karakterden az olamaz.";
            header("Location: yoneticiduzenle.php?user_id={$user->user_id}");
            exit();
        }
        if (strlen($new_password) > 20) {
            $_SESSION["errors"][] = "Şifre 20 karakterden fazla olamaz.";
            header("Location: yoneticiduzenle.php?user_id={$user->user_id}");
            exit();
        }
        if (strcmp($new_password, $control_password) !== 0) {
            $_SESSION["errors"][] = "Girmiş olduğunuz şifreler farklıdır.";
            header("Location: yoneticiduzenle.php?user_id={$user->user_id}");
            exit();
        }
    }

    $sorgu = "UPDATE users SET username = :username, email = :email ";
    $values = ['username' => $username, 'email' => $email, 'user_id' => $user->user_id];

    if (!empty($new_password))
    {
        $sorgu.= ", password = :password ";
        $values['password'] = password_hash($new_password, PASSWORD_DEFAULT);
    }

    $sorgu.= " WHERE user_id = :user_id ";

    $query = $db->prepare($sorgu);
    if(!$query->execute($values))
    {
        $_SESSION["errors"][] = "Yönetici hesabı güncelleştirilemedi.";
        header("Location: yoneticiduzenle.php?user_id={$user->user_id}");
        exit();
    }

    $_SESSION["success"][] = "Yönetici hesabı başarıyla düzenlendi.";
    header("Location: yoneticigoster.php");
    exit();
}
include "header.php";
?>

<div class="row row-sm" style="margin: 20px" >
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Yöneticilerin Listesi</h4>

                        </div>
                        <p class="tx-12 tx-gray-500 mb-2">Yönetici bilgilerini buradan düzenleyebilirsiniz.</p>
                        <div class="card-body">
                        </div><!-- bd -->
                        <?php if(isset($_SESSION["errors"])) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php
                                echo implode("<br />", $_SESSION["errors"]);
                                unset($_SESSION["errors"]);
                                ?>
                            </div>
                        <?php } ?>
                        <div class="card-body pt-0 col-lg-12" >
                            <form class="form-horizontal" action="<?= $_SERVER["PHP_SELF"].'?user_id='.$user->user_id; ?>" method="POST">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="inputName" name="kullanici_adi" value="<?= $user->username; ?>" placeholder="Kullanıcı Adı">

                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" id="inputEmail" name="email" value="<?= $user->email; ?>" placeholder="Email">
                                </div>

                                <div class="form-group">
                                    <input type="password" class="form-control" id="inputPassword" name="yeni_sifre" placeholder="Yeni şifrenizi giriniz.">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" id="inputPassword" name="yeni_sifre_tekrar" placeholder="Yeni şifrenizi tekrar giriniz.">
                                </div>
                                <div class="form-group mb-0 mt-3 justify-content-end">
                                    <div>
                                        <button type="submit" class="btn btn-primary">GÜNCELLE</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div><!-- bd -->
            </div>
        </div>

<?php
include "footer.php";
?>