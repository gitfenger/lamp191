<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo e(asset('resources/views/admin/style/css/ch-ui.admin.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('resources/views/admin/style/font/css/font-awesome.min.css')); ?>">


    <script src="https://cdn.bootcss.com/jquery/2.2.3/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo e(asset('resources/views/admin/style/js/ch-ui.admin.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('resources/org/layer-v2.2/layer/layer.js')); ?>"></script>
</head>
<body>
 <?php echo $__env->yieldContent('content'); ?>
</body>
</html>