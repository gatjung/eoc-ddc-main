<?php $__env->startSection('content'); ?>
<div id="large-header" class="large-header">
	<canvas id="demo-canvas"></canvas>

	<div class="limiter main-title">
		<div class="container-login100 w3-animate-top">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
				<span class="login100-form-title p-b-49">รีเซ็ตรหัสผ่าน</span>

				<?php if(session('status')): ?>
                    <div class="alert alert-success" role="alert">
                        <strong style="color: #61b15A;"><?php echo e(session('status')); ?></strong>
                    </div>
                <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('password.email')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="wrap-input100">
							<label class="w3-left w3-text-black">อีเมล</label>
							<input id="email" type="email" class="input100 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus>

	                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><p style="color: red;"><?php echo e($message); ?></p></strong>
                                    </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
							<span class="focus-input100" data-symbol="📧"></span>
						</div>

                        <div class="container-login100-form-btn">
							<div class="wrap-login100-form-btn" style="margin-top: 20px;">
								<div class="login100-form-bgbtn"></div>
								<button class="login100-form-btn" type="submit">ส่งลิงค์สำหรับรีเซ็ตรหัสผ่าน</button>
							</div>
						</div>
					</form>
				<div class="w3-text-black" style="margin-top: 10px;">
					<a href="<?php echo e(route('login.ecosystem')); ?>">กลับหน้าแรก</a>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/resetpass.blade.php ENDPATH**/ ?>