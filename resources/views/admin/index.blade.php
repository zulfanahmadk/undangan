@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="dashboard-page">
        <div class="page-header">
            <h1>Dashboard</h1>
            <p>Ringkasan informasi manajemen undangan Anda</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                <span>{{ session('success') }}</span>
                <button class="alert-close">×</button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                <span>{!! session('error') !!}</span>
                <button class="alert-close">×</button>
            </div>
        @endif

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <div class="stat-info">
                    <div class="stat-label">Total Daftar Tamu</div>
                    <div class="stat-value">{{ $totalGuests }}</div>
                    <a href="{{ route('admin.guests') }}" class="stat-link">
                        Lihat Daftar Tamu →
                    </a>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">🎁</div>
                <div class="stat-info">
                    <div class="stat-label">Total Ucapan & Doa</div>
                    <div class="stat-value">{{ $totalWishes }}</div>
                    <a href="{{ route('admin.wishes') }}" class="stat-link">
                        Lihat Ucapan & Doa →
                    </a>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">📅</div>
                <div class="stat-info">
                    <div class="stat-label">Tamu Ditambahkan Hari Ini</div>
                    <div class="stat-value">{{ $guestsToday }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">🔗</div>
                <div class="stat-info">
                    <div class="stat-label">Link Undangan Aktif</div>
                    <div class="stat-value">{{ $totalGuests }}</div>
                    <a href="/" class="stat-link">
                        Lihat Undangan →
                    </a>
                </div>
            </div>
        </div>

        <div class="quick-actions">
            <h3>Aksi Cepat</h3>
            <div class="action-buttons">
                <a href="{{ route('admin.guests') }}" class="btn btn-primary">
                    Kelola Daftar Tamu
                </a>
                <a href="/" class="btn btn-secondary">
                    Lihat Undangan
                </a>
            </div>
        </div>

        <div class="recent-guests">
            <h3>Tamu Terbaru</h3>
            @if ($recentGuests->count() > 0)
                <div class="guests-list">
                    @foreach ($recentGuests as $guest)
                        <div class="guest-item">
                            <div class="guest-info">
                                <div class="guest-name">{{ $guest->name }}</div>
                                <div class="guest-dates">
                                    <span class="date-badge">Ditambah: {{ $guest->created_at->format('d M Y H:i') }}</span>
                                    <span class="date-badge">Update: {{ $guest->updated_at->format('d M Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <p>Belum ada daftar tamu. <a href="{{ route('admin.guests') }}">Mulai tambahkan sekarang →</a></p>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('extra-js')
    <script src="{{ asset('js/admin-dashboard-page.js') }}"></script>
@endsection
