@extends('layouts.master')
@section('content')
<div id="large-header" class="large-header">
	<canvas id="demo-canvas"></canvas>

	<div class="limiter main-title">
		<div class="container-login100 w3-animate-top">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
				<span class="login100-form-title p-b-49">รีเซ็ตรหัสผ่าน</span>

				@if (session('status'))
                    <div class="alert alert-success" role="alert">
                        <strong style="color: #61b15A;">{{ session('status') }}</strong>
                    </div>
                @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="wrap-input100">
							<label class="w3-left w3-text-black">อีเมล</label>
							<input id="email" type="email" class="input100 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

	                        @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong><p style="color: red;">{{ $message }}</p></strong>
                                    </span>
                            @enderror
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
					<a href="{{ route('login.ecosystem') }}">กลับหน้าแรก</a>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection