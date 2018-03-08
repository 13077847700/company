<!DOCTYPE html>
<html>
<head>
	<base href="<?php echo base_url();?>" />

  <meta charset="utf-8">
  <meta name="renderer" content="webkit">
  <!--<meta http-equiv="X-UA-Compatible" content="IE=edge">-->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title><?= WEB_SITE_TITLE ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="public/Resources/css/bootstrap.min.css" media="screen">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="public/Resources/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="public/Resources/dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <!--<link rel="stylesheet" href="public/Resources/plugins/iCheck/flat/blue.css">-->
  <link rel="stylesheet" href="public/Resources/plugins/ICheck/purple.css">

  <!-- 日期样式 -->
  <link rel="stylesheet" href="public/daterangepicker/daterangepicker.css">

  <!--bootstrap-table.css-->
  <link rel="stylesheet" href="public/Resources/css/bootstrap-table.css">
  <link rel="stylesheet" href="public/editable/bootstrap-editable.css">
  <!--<link rel="stylesheet" href="//rawgit.com/vitalets/x-editable/master/dist/bootstrap3-editable/css/bootstrap-editable.css">-->

  <!-- 我的css -->
  <link rel="stylesheet" href="public/Resources/css/my.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<style>

  body
  {
  	font-family: "微软雅黑";
  }

</style>



<body class="hold-transition skin-blue sidebar-mini">

<header class="main-header">
  <!-- Logo -->
  <a href="index2.html" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><img src="public/Resources/dist/img/logo1.png" alt="logo"></span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="public/Resources/dist/img/user.png" class="user-image" alt="User Image">
            <span class="hidden-xs"><?=$username?>&nbsp;&nbsp;<i class="fa fa-chevron-down"></i></span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="public/Resources/dist/img/user.png" class="img-circle" alt="User Image">

              <p>
                你信不信
              </p>
              <p>
                <small>我叫一车面包人来打你</small>
              </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="<?php echo site_url('admin/Setting/index') ?>" class="btn btn-info btn-flat">修改密码</a>
              </div>
              <div class="pull-right">
                <a href="<?php echo site_url('admin/Logout/index') ?>" class="btn btn-info btn-flat">注销登录</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>