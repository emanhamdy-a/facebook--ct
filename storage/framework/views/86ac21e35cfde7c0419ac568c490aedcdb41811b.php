<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title><?php echo e(config('app.name', 'Laravel')); ?></title>
  <!-- Scripts -->
  <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>
  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
  <!-- Styles -->
  <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
  <!-- <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"> -->
</head>

<body class="bg-gray-200 text-gray-800 antialiased font-sans">
  <div id="app">
    <main class="h-screen">
      <?php echo $__env->yieldContent('content'); ?>
    </main>
  </div>
  <!-- <script src="<?php echo e(asset('js/app.js')); ?>"></script> -->
</body>

</html>
<?php /**PATH C:\xampp\htdocs\facebook-ct\resources\views/layouts/app.blade.php ENDPATH**/ ?>