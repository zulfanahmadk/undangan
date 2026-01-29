@extends('layouts.admin')

@section('title', 'Ucapan & Doa')

@section('content')
    <div class="wishes-page">
        <div class="page-header">
            <h1>Ucapan & Doa</h1>
            <p>Lihat ucapan dan doa dari tamu-tamu Anda</p>
        </div>

        @if ($wishes->count() > 0)
            <div class="wishes-section">
                <div class="wishes-header">
                    <div class="stat-card">
                        <div class="stat-label">Total Ucapan</div>
                        <div class="stat-value">{{ $wishes->total() }}</div>
                    </div>
                </div>

                <div class="wishes-list">
                    @foreach ($wishes as $wish)
                        <div class="wish-card">
                            <div class="wish-header">
                                <h3 class="wish-name">{{ $wish->name }}</h3>
                                <span class="wish-date">{{ $wish->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <p class="wish-text">{{ $wish->text }}</p>
                        </div>
                    @endforeach
                </div>

                @if ($wishes->hasPages())
                    <div class="pagination">
                        @if ($wishes->onFirstPage())
                            <span class="disabled">← Sebelumnya</span>
                        @else
                            <a href="{{ $wishes->previousPageUrl() }}">← Sebelumnya</a>
                        @endif

                        @foreach ($wishes->getUrlRange(1, $wishes->lastPage()) as $page => $url)
                            @if ($page == $wishes->currentPage())
                                <span class="active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($wishes->hasMorePages())
                            <a href="{{ $wishes->nextPageUrl() }}">Selanjutnya →</a>
                        @else
                            <span class="disabled">Selanjutnya →</span>
                        @endif
                    </div>
                @endif
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">💬</div>
                <h3>Belum Ada Ucapan</h3>
                <p>Ucapan dan doa dari tamu akan muncul di sini</p>
            </div>
        @endif
    </div>

    <style>
        .wishes-page {
            max-width: 100%;
        }

        .page-header {
            background: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .page-header h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }

        .page-header p {
            color: #666;
            font-size: 14px;
        }

        .wishes-section {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .wishes-header {
            padding: 20px 30px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-card {
            background: white;
            padding: 15px;
        }

        .stat-label {
            color: #999;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 28px;
            color: #667eea;
            font-weight: 600;
        }

        .wishes-list {
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        .wish-card {
            background: #f9fafb;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
            transition: all 0.3s ease;
        }

        .wish-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .wish-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .wish-name {
            font-size: 16px;
            color: #333;
            font-weight: 600;
            margin: 0;
        }

        .wish-date {
            color: #999;
            font-size: 12px;
        }

        .wish-text {
            color: #555;
            font-size: 14px;
            line-height: 1.6;
            margin: 0;
            word-break: break-word;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state-icon {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 18px;
            margin-bottom: 8px;
            color: #666;
        }

        .empty-state p {
            font-size: 14px;
            margin-bottom: 20px;
        }

        .pagination {
            padding: 20px;
            display: flex;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
            border-top: 1px solid #e5e7eb;
        }

        .pagination a,
        .pagination span {
            padding: 8px 12px;
            border-radius: 4px;
            border: 1px solid #d0d0d0;
            text-decoration: none;
            color: #667eea;
            font-size: 12px;
        }

        .pagination a:hover {
            background: #667eea;
            color: white;
        }

        .pagination .active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .pagination .disabled {
            color: #ccc;
            cursor: not-allowed;
            border-color: #e5e7eb;
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 20px;
            }

            .page-header h1 {
                font-size: 22px;
            }

            .wish-card {
                padding: 15px;
            }

            .wish-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .wish-name {
                font-size: 14px;
            }

            .wish-text {
                font-size: 13px;
            }
        }
    </style>
@endsection
