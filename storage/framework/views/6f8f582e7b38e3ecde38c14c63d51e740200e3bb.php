<!DOCTYPE html>
<html lang="en">
<head>
	<title>ECOSYSTEM</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="#" />
	<?php echo $__env->make('layouts.css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->yieldContent('css-custom-script'); ?>
  	<?php echo $__env->yieldContent('css-custom'); ?>
</head>

<body>

<?php echo $__env->yieldContent('content'); ?>
<?php echo $__env->make('layouts.js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldContent('js-custom-script'); ?>
<?php echo $__env->yieldContent('js-custom'); ?>


</body>
</html>
<?php /**PATH /var/www/resources/views/layouts/master.blade.php ENDPATH**/ ?>