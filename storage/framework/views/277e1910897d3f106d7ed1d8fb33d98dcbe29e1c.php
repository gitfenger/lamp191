<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <?php echo $__env->yieldContent('info'); ?>

    <link href="<?php echo e(asset('resources/views/home/css/base.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('resources/views/home/css/index.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('resources/views/home/css/news.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('resources/views/home/css/style.css')); ?>" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="<?php echo e(asset('resources/views/home/js/modernizr.js')); ?>"></script>
    <![endif]-->
</head>
<body>
<header>
    <div id="logo"><a href="<?php echo e(url('/')); ?>"></a></div>
    <nav class="topnav" id="topnav">
        <?php $__currentLoopData = $navs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(url($v->nav_url)); ?>"><span><?php echo e($v->nav_name); ?></span><span class="en"><?php echo e($v->alias); ?></span></a>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </nav>
    </nav>
</header>
<?php $__env->startSection('content'); ?>
    <h3>
        <p>最新<span>文章</span></p>
    </h3>
    <ul class="rank">
        <?php $__currentLoopData = $new; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><a href="<?php echo e(url('a/'.$n->art_id)); ?>" title="<?php echo e($n->art_title); ?>" target="_blank"><?php echo e($n->art_title); ?></a></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    <h3 class="ph">
        <p>点击<span>排行</span></p>
    </h3>
    <ul class="paih">
        <?php $__currentLoopData = $hot; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><a href="<?php echo e(url('a/'.$n->art_id)); ?>" title="<?php echo e($n->art_title); ?>" target="_blank"><?php echo e($n->art_title); ?></a></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    </div>
    <?php echo $__env->yieldSection(); ?>


<footer>
    <p><?php echo Config::get('web.copyright'); ?><?php echo Config::get('web.web_count'); ?></p>
</footer>

</body>
</html>
