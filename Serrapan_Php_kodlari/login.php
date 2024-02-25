<?php
require_once "init.php";

if($visitor)
{
	header("Location: index.php");
	exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$username = trim($_POST["username"]);
	$password = trim($_POST["password"]);
	
	if(empty($username) || empty($password))
	{
		$_SESSION["errors"][] = "Boş bırakmayın.";
		header("Location: login.php");
		exit();
	}
	
	$query = $db->prepare("SELECT * FROM users WHERE username = ?");
	$query->execute([$username]);
	$user = $query->fetch();

    if(!$user)
	{
		$_SESSION["errors"][] = "Kullanıcı bulunamadı. 🙄";
		header("Location: login.php");
		exit();
	}

    if(!password_verify($password, $user->password))
    {
        $_SESSION["errors"][] = "Şifreniz yanlış. 😡";
        header("Location: login.php");
        exit();
    }

    $_SESSION["user"] = $user->user_id;
	header("Location: index.php");
	exit();
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=0"
    />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="Description"
      content="Bootstrap Responsive Admin Web Dashboard HTML5 Template"
    />
    <meta name="Author" content="Spruko Technologies Private Limited" />
    <meta
      name="Keywords"
      content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4"
    />

    <!-- Title -->
    <title>
      Serrapan Giriş Paneli
    </title>

    <!-- Favicon -->
    <link
      rel="icon"
      href="./assets/img/brand/favicon.png"
      type="image/x-icon"
    />

    <!-- Icons css -->
    <link href="./assets/css/icons.css" rel="stylesheet" />

    <!--  Right-sidemenu css -->
    <link href="./assets/plugins/sidebar/sidebar.css" rel="stylesheet" />

    <!-- P-scroll bar css-->
    <link
      href="./assets/plugins/perfect-scrollbar/p-scrollbar.css"
      rel="stylesheet"
    />

    <!--  Left-Sidebar css -->
    <link rel="stylesheet" href="./assets/css/closed-sidemenu.css" />

    <!--- Style css --->
    <link href="./assets/css/style.css" rel="stylesheet" />

    <!--- Dark-mode css --->
    <link href="./assets/css/style-dark.css" rel="stylesheet" />

    <!---Skinmodes css-->
    <link href="./assets/css/skin-modes.css" rel="stylesheet" />

    <!--- Animations css-->
    <link href="./assets/css/animate.css" rel="stylesheet" />
  </head>
  <body class="error-page1 bg-light">
    <!-- Loader -->
    <div id="global-loader">
      <img src="./assets/img/loader.svg" class="loader-img" alt="Loader" />
    </div>
    <!-- /Loader -->

    <!-- Page -->
    
    <div class="page">
      <div class="container-fluid">
        <div class="row no-gutter">
          <!-- The image half -->
          <div
            class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent"
          >
            <div class="row wd-100p mx-auto text-center">
              <div
                class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p"
              >
              <img
                  src="../images/team/serrapan.png"
                  class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto"
                  alt="logo"
                  
                />
              </div>
            </div>
          </div>
          <!-- The content half -->
          <div class="col-md-6 col-lg-6 col-xl-5 bg-white">
            <div class="login d-flex align-items-center py-2">
              <!-- Demo content-->
              <div class="container p-0">
                <div class="row">
                  <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                    <div class="card-sigin">
                      <div class="mb-5 d-flex">
                        <a href="login.php"
                          ><img
                            src="../images/team/serrapanyenilogo.png"
                            class="sign-favicon ht-40"
                            alt="logo"
                            style="height: 65px; background-size: cover "
                        /></a>
                        <h1 class="main-logo1 ml-1 mr-0 my-auto tx-28" style="color: #098f41; padding-top: 2px">
                          Serrapan
                        </h1>
                      </div>
                      <div class="card-sigin">
                        <div class="main-signup-header">
                          <h2 style="color: #098f41">Hoş geldiniz!</h2>
                          <h5 class="font-weight-semibold mb-4" style="color: black">
                            Devam etmek için giriş yapınız.
                          </h5>
						  
						  <?php if(isset($_SESSION["errors"])) { ?>
							<div class="alert alert-danger" role="alert">
							<?php
 								echo implode("<br />", $_SESSION["errors"]);
								unset($_SESSION["errors"]);
							?>
							</div>
						  <?php } ?>

                          <form action="<?= $_SERVER["PHP_SELF"]; ?>" method="post">
                            <div class="form-group">
                              <label for="username">Kullanıcı Adı</label>
                              <input class="form-control" placeholder="Kullanıcı adınızı giriniz." name="username" id="username" type="text" />
                            </div>
                            
                            <div class="form-group">
                              <label>Şifre</label>
                              <input class="form-control" placeholder="Şifrenizi girin." type="password" name="password" id="password" />
                            </div>
                            <button class="btn btn-main-primary btn-block" style="background-color: #098f41">
                              Giriş Yap
                            </button>
                          </form>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End -->
            </div>
          </div>
          <!-- End -->
        </div>
      </div>
    </div>
    <!-- End Page -->

    <!-- JQuery min js -->
    <script src="./assets/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Bundle js -->
    <script src="./assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Ionicons js -->
    <script src="./assets/plugins/ionicons/ionicons.js"></script>

    <!-- Moment js -->
    <script src="./assets/plugins/moment/moment.js"></script>

    <!-- eva-icons js -->
    <script src="./assets/js/eva-icons.min.js"></script>

    <!-- Rating js-->
    <script src="./assets/plugins/rating/jquery.rating-stars.js"></script>
    <script src="./assets/plugins/rating/jquery.barrating.js"></script>

    <!-- custom js -->
    <script src="./assets/js/custom.js"></script>
  </body>
</html>
