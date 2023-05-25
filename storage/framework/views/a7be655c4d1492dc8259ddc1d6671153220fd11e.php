<?php $__env->startSection('content'); ?>
<div id="large-header" class="large-header">
	<canvas id="demo-canvas"></canvas>

	<div class="limiter main-title">
		<div class="container-login100 w3-animate-top">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
				<img src="<?php echo e(asset('img/ddc_logo_250.png')); ?>" class="w3-image">
				<span class="login100-form-title p-b-49">ECOSYSTEM</span>
				<form class="login100-form" method="POST" action="<?php echo e(route('login')); ?>">
					<?php echo csrf_field(); ?>
					<div class="wrap-input100 m-b-23">
						<label class="w3-left w3-text-black">ชื่อผู้ใช้หรืออีเมล์</label>
						<input class="input100 <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="username" value="<?php echo e(old('username')); ?>" placeholder="" required autocomplete="username" autofocus>
                        <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback" role="alert">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
						<span class="focus-input100" data-symbol="🤵"></span>
					</div>

					<div class="wrap-input100">
						<label class="w3-left w3-text-black">รหัสผ่าน</label>
						<input class="input100 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="password" name="password" placeholder="" required autocomplete="current-password">
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback" role="alert">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
						<span class="focus-input100" data-symbol="🔑"></span>
					</div>

					<?php if(session()->has('success')): ?>
					    <div class="alert alert-success w3-text-green" style="margin-top: 20px;">
					        <?php echo e(session()->get('success')); ?>

					    </div>
					<?php endif; ?>

					<?php if(session()->has('error')): ?>
					    <div class="alert alert-danger w3-text-red" style="margin-top: 20px;">
					        <?php echo e(session()->get('error')); ?>

					    </div>
					<?php endif; ?>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn" style="margin-top: 20px;">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" type="submit">เข้าสู่ระบบ</button>
						</div>
					</div>
				</form>
				<div class="container-login100-form-btn">
					<div class="wrap-login100-form-btn" style="margin-top: 10px;">
						<div class="login100-form-bgbtn"></div>
						<button class="login100-form-btn" onclick="window.location='<?php echo e(url("member/register")); ?>'">สมัครสมาชิก</button>
					</div>

					<div class="w3-right-align w3-text-black" style="margin-top: 10px;">
						<div><a href="<?php echo e(route('resetpass.ecosystem')); ?>">ลืมรหัสผ่าน</a> | <a href="https://www.youtube.com/channel/UCXgD1bkMgygi226vaE8cNbg/" target="_blank">คู่มือการใช้งานออนไลน์</a></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/login.blade.php ENDPATH**/ ?>