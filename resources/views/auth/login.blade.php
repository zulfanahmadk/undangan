<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="login-title">Admin Login</div>
            <div class="login-subtitle">Wedding Invitation Management</div>
        </div>

        @if ($errors->any())
            <div class="error-message">
                {{ $errors->first('email') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" 
                       name="email" 
                       class="form-input" 
                       placeholder="Masukkan email Anda"
                       value="{{ old('email') }}"
                       required 
                       autofocus>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" 
                       name="password" 
                       class="form-input" 
                       placeholder="Masukkan password Anda"
                       required>
            </div>

            <button type="submit" class="login-btn">Masuk</button>
        </form>

        <div class="login-footer">
            <div class="login-footer-text">
                Kembali ke <a href="/">halaman utama</a>
            </div>
        </div>
    </div>
</body>
</html>
