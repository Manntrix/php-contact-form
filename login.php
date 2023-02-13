<?php
session_start();
require_once './backoffice/config/db/config.php';
$token = bin2hex(openssl_random_pseudo_bytes(16));
include('./backoffice/languages/lang_config.php');
$db = getDbInstance();
$db->where ("setting_name", 'change_language');
$res = $db->getOne("settings");
$changelanguage = $res['setting_value'];

if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === TRUE)
{
	header('Location: ./backoffice/index.php');
}

if (isset($_COOKIE['series_id']) && isset($_COOKIE['remember_token']))
{
    $series_id = filter_var($_COOKIE['series_id']);
    $remember_token = filter_var($_COOKIE['remember_token']);
    $db = getDbInstance();
    $db->where('series_id', $series_id);
    $row = $db->getOne('users');

    if ($db->count >= 1)
    {
        if (password_verify($remember_token, $row['remember_token']))
        {
            $expires = strtotime($row['expires']);

            if (strtotime(date()) > $expires)
            {
                clearAuthCookie();
                header('Location:login.php');
                exit;
            }

            $_SESSION['user_logged_in'] = TRUE;
            $_SESSION['user_id'] = $row[0]['id'];
            $_SESSION['admin_type'] = $row['u_userrole'];
            header('Location: ./backoffice/index.php');
            exit;
        }
        else
        {
            clearAuthCookie();
            header('Location:login.php');
            exit;
        }
    }
    else
    {
        clearAuthCookie();
        header('Location:login.php');
        exit;
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $lang['bakecake']?> | <?php echo $lang['log_in']?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./backoffice/ui/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="./backoffice/ui/icheck-bootstrap.min.css">
    <?php if($_SESSION['lang'] == 'ar' || $_SESSION['lang'] == 'he'){
        ?>
        <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.5.3/css/bootstrap.min.css" >
        <link rel="stylesheet" href="./backoffice/ui/rtl.css">
        <?php
    } ?>
  <!-- Theme style -->
  <link rel="stylesheet" href="./backoffice/ui/adminlte.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.1.0/css/flag-icon.min.css" rel="stylesheet">
</head>
<body class="hold-transition login-page">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="display: <?php echo $changelanguage == 1 ? 'none' : '' ?>">

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown" >
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown09" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="flag-icon <?php echo $_SESSION['lang'] == 'he' ? 'flag-icon-il' : ($_SESSION['lang'] == 'ar' ? "flag-icon-sa" : 'flag-icon-us') ?>"> </span> <?php echo $_SESSION['lang'] == 'he' ? 'Hebrew' : ($_SESSION['lang'] == 'ar' ? "Arabic" : 'English') ?></a>
                    <div class="dropdown-menu" aria-labelledby="dropdown09">
                        <a class="dropdown-item" style="<?php echo $_SESSION['lang'] == 'en'? 'display:none': ''?>" href="<?php echo addOrUpdateUrlParam('lang', 'en') ?>"><span class="flag-icon flag-icon-us"> </span>   English</a>
                        <a class="dropdown-item" style="<?php echo $_SESSION['lang'] == 'ar'? 'display:none': ''?>" href="<?php echo addOrUpdateUrlParam('lang', 'ar') ?>"><span class="flag-icon flag-icon-sa"> </span>  Arabic</a>
                        <a class="dropdown-item" style="<?php echo $_SESSION['lang'] == 'he'? 'display:none': ''?>" href="<?php echo addOrUpdateUrlParam('lang', 'he') ?>"><span class="flag-icon flag-icon-il"> </span>  Hebrew</a>
                    </div>
                </li>

            </ul>


        </nav>

<div class="login-box">
  <div class="login-logo">
    <a href=""><b><img src="./backoffice/assets/img/logo.png" alt=""></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg"><?php echo $lang['sign_in_session']?></p>

      <form method="POST" action="authenticate.php">
          <?php if (isset($_SESSION['login_failure'])): ?>
              <div class="alert alert-danger alert-dismissable">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <?php
                  echo $_SESSION['login_failure'];
                  unset($_SESSION['login_failure']);
                  ?>
              </div>
          <?php endif; ?>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username" name="username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="passwd">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="remember" value="1">
              <label for="remember">
                  <?php echo $lang['remember_me']?>
              </label>
            </div>
          </div>

          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block"><?php echo $lang['sign_in']?></button>
          </div>
          <!-- /.col -->
        </div>
      </form>

     

      <p class="mb-1">
        <a href="agent-login.php"><?php echo $lang['agent_login']?></a>
      </p>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="./backoffice/js/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./backoffice/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./backoffice/js/adminlte.min.js"></script>
</body>
</html>
