@extends('layouts.master')

@section('content')

<div id="large-header" class="large-header">
    <canvas id="demo-canvas"></canvas>

    <div class="limiter main-title">
        <div class="container-login100 w3-animate-top">
            <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
                <span class="login100-form-title p-b-49">รีเช็ตรหัสผ่าน</span>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="wrap-input100">
                            <label class="w3-left w3-text-black">อีเมล</label>
                            <input id="email" type="email" class="input100 @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus readonly>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            <span class="focus-input100" data-symbol="📧"></span>
                        </div>

                        <div class="wrap-input100">
                            <label class="w3-left w3-text-black">รหัสผ่านใหม่</label>
                            <input id="password" type="password" class="input100 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            <span class="focus-input100" data-symbol="🔑"></span>
                        </div>

                        <div class="wrap-input100">
                            <label class="w3-left w3-text-black">ยืนยันรหัสผ่าน</label>
                            <input id="password-confirm" type="password" class="input100" name="password_confirmation" required autocomplete="new-password">
                            <span class="focus-input100" data-symbol="🔑"></span>
                        </div>

                        <div class="container-login100-form-btn">
                            <div class="wrap-login100-form-btn" style="margin-top: 20px;">
                                <div class="login100-form-bgbtn"></div>
                                <button class="login100-form-btn" type="submit">รีเซ็ตรหัสผ่าน</button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>

@endsection
