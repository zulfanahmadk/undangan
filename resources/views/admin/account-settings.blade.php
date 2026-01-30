@extends('layouts.admin')

@section('title', 'Pengaturan Akun')

@section('content')
    <div class="account-settings-page">
        <div class="page-header">
            <h1>Pengaturan Akun</h1>
            <p>Kelola nama, username, email, dan password akun Anda</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                <span>{{ session('success') }}</span>
                <button class="alert-close">×</button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <div>
                    <strong>Kesalahan:</strong>
                    <ul style="margin-top: 8px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button class="alert-close">×</button>
            </div>
        @endif

        <div class="account-settings-container">
            <div class="settings-card">
                <div class="settings-header">
                    <h2>Informasi Akun</h2>
                    <p>Ubah informasi pribadi dan keamanan akun Anda</p>
                </div>

                <form id="accountSettingsForm" action="{{ route('account-settings.update') }}" method="POST" class="settings-form">
                    @csrf
                    @method('PUT')

                    <div class="settings-section">
                        <h3 class="section-title">Informasi Dasar</h3>

                        <div class="form-group">
                            <label class="form-label">Nama <span class="required-star">*</span></label>
                            <input type="text" name="name" class="form-input" placeholder="Masukkan nama Anda" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Username <span class="required-star">*</span></label>
                            <input type="text" name="username" class="form-input" placeholder="Masukkan username" value="{{ old('username', $user->username) }}" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email <span class="required-star">*</span></label>
                            <input type="email" name="email" class="form-input" placeholder="Masukkan email Anda" value="{{ old('email', $user->email) }}" required>
                        </div>
                    </div>

                    <div class="settings-section">
                        <h3 class="section-title">Ubah Password</h3>
                        <p class="section-description">Kosongkan jika tidak ingin mengubah password</p>

                        <div class="form-group">
                            <label class="form-label">Password Saat Ini</label>
                            <input type="password" name="current_password" class="form-input" placeholder="Masukkan password saat ini">
                            <p class="input-help-text">Wajib diisi jika ingin mengubah password</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="new_password" class="form-input" placeholder="Masukkan password baru (minimal 6 karakter)">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="new_password_confirmation" class="form-input" placeholder="Konfirmasi password baru">
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/account-settings.css') }}">
@endsection

@section('extra-js')
    <script src="{{ asset('js/account-settings.js') }}"></script>
@endsection
