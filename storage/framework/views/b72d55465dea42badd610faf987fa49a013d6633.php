<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo e(config('app.name','Laravel')); ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo e(asset('bower_components/admin-lte/plugins/fontawesome-free/css/all.min.css')); ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo e(asset('bower_components/admin-lte/dist/css/adminlte.min.css')); ?>">
  <!-- Google Font: Sarabun -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Sarabun:300,400,400i,700" rel="stylesheet"> -->
  <?php echo $__env->yieldContent('custom-css-script'); ?>
  <?php echo $__env->yieldContent('custom-css'); ?>

<!-- Start font thai sarabun -->
  <link href="https://cdn.lazywasabi.net/fonts/Sarabun/Sarabun.css" rel="stylesheet">
  <style type="text/css">
  @font-face {
    font-family: 'Sarabun';
    src:
      url('https://cdn.lazywasabi.net/fonts/Sarabun/Sarabun-Regular.woff2')
      format('woff2'),
      url('https://cdn.lazywasabi.net/fonts/Sarabun/Sarabun-Regular.woff') format('woff');
    font-style: normal;
    font-weight: normal;
    font-display: swap;
  }

  @font-face {
    font-family: 'Sarabun';
    src:
      url('https://cdn.lazywasabi.net/fonts/Sarabun/Sarabun-Bold.woff2')
      format('woff2'),
      url('https://cdn.lazywasabi.net/fonts/Sarabun/Sarabun-Bold.woff') format('woff');
    font-style: normal;
    font-weight: bold;
    font-display: swap;
  }
  body {
  	font-family: 'Sarabun', sans-serif;
  }
  </style>
  <!-- END font thai sarabun -->

</head>
<body class="hold-transition sidebar-mini layout-navbar-fixed">
<!-- Site wrapper -->
<div>



  <!-- Content Wrapper. Contains page content -->
  <div>
    <!-- Main content -->
    <?php echo $__env->yieldContent('content'); ?>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- footer -->

  <!-- /.footer -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo e(asset('bower_components/admin-lte/plugins/jquery/jquery.min.js')); ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo e(asset('bower_components/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo e(asset('bower_components/admin-lte/dist/js/adminlte.min.js')); ?>"></script>
<?php echo $__env->yieldContent('custom-js-script'); ?>
<?php echo $__env->yieldContent('custom-js-code'); ?>
</body>
</html>
<?php /**PATH /var/www/Modules/Member/Resources/views/layouts/blank.blade.php ENDPATH**/ ?>