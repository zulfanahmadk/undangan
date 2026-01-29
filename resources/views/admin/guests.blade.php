@extends('layouts.admin')

@section('title', 'Daftar Tamu')

@section('content')
    <div class="guests-page">
        <div class="page-header">
            <h1>Manajemen Daftar Tamu</h1>
            <p>Kelola daftar tamu untuk undangan pernikahan Anda</p>
            <button class="btn btn-primary" onclick="openAddModal()">
                Tambah Tamu Baru
            </button>
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

        <div class="guests-section">
            <div class="guests-header">
                <div class="stats">
                    <div class="stat-card">
                        <div class="stat-label">Total Tamu</div>
                        <div class="stat-value">{{ $guests->total() }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Halaman</div>
                        <div class="stat-value">{{ $guests->currentPage() }}/{{ $guests->lastPage() }}</div>
                    </div>
                </div>
                <div class="search-box">
                    <input type="text" class="search-input" id="searchInput" placeholder="Cari nama tamu...">
                </div>
            </div>

            @if ($guests->count() > 0)
                <div class="table-responsive">
                    <table class="guests-table">
                        <thead>
                            <tr>
                                <th>Nama Tamu</th>
                                <th>No. Telpon</th>
                                <th>URL Undangan</th>
                                <th>Status</th>
                                <th>Ditambahkan</th>
                                <th>Diupdate</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="guestsTableBody">
                            @foreach ($guests as $guest)
                                <tr>
                                    <td>
                                        <div class="guest-name">{{ $guest->name }}</div>
                                        <div class="guest-slug">{{ $guest->slug }}</div>
                                    </td>
                                    <td>
                                        <div class="guest-whatsapp">
                                            @if ($guest->whatsapp)
                                                <a href="https://wa.me/{{ $guest->whatsapp }}" target="_blank" class="whatsapp-link">
                                                    +{{ $guest->whatsapp }}
                                                </a>
                                            @else
                                                <span class="whatsapp-empty">-</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ url('/' . $guest->slug) }}" target="_blank" class="guest-link">
                                            /{{ $guest->slug }}
                                        </a>
                                    </td>
                                    <td>
                                        @php
                                            $statusCode = $guest->status ?? 2;
                                            $statusText = ($statusCode == 1) ? 'Terkirim' : 'Belum Dikirim';
                                            $statusClass = ($statusCode == 1) ? 'guest-status-sent' : 'guest-status-pending';
                                            $bgColor = ($statusCode == 1) ? '#10b981' : '#ef4444';
                                        @endphp
                                        <span class="guest-status {{ $statusClass }}" data-guest-id="{{ $guest->id }}" style="background: {{ $bgColor }}; color: white; padding: 8px 16px; border-radius: 20px; display: inline-block; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; min-width: 140px; text-align: center;">{{ $statusText }}</span>
                                    </td>
                                    <td>
                                        <div class="guest-date">{{ $guest->created_at->format('d M Y H:i') }}</div>
                                    </td>
                                    <td>
                                        <div class="guest-date">{{ $guest->updated_at->format('d M Y H:i') }}</div>
                                    </td>
                                    <td>
                                        <div class="table-actions">
                                            <button class="btn btn-edit btn-sm" onclick="openEditModal({{ $guest->id }}, '{{ addslashes($guest->name) }}', '{{ $guest->whatsapp ?? '' }}')">
                                                Edit
                                            </button>
                                            @if ($guest->whatsapp)
                                            <button class="btn btn-whatsapp-send btn-sm" onclick="sendWhatsAppInvitation('{{ $guest->whatsapp }}', '{{ addslashes($guest->name) }}', '{{ $guest->slug }}', {{ $guest->id }})">
                                                Kirim Undangan
                                            </button>
                                            @endif
                                            <form action="{{ route('guests.destroy', $guest->id) }}" method="POST" style="display: inline;" class="delete-form" data-guest-name="{{ $guest->name }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($guests->hasPages())
                    <div class="pagination">
                        @if ($guests->onFirstPage())
                            <span class="disabled">← Sebelumnya</span>
                        @else
                            <a href="{{ $guests->previousPageUrl() }}">← Sebelumnya</a>
                        @endif

                        @foreach ($guests->getUrlRange(1, $guests->lastPage()) as $page => $url)
                            @if ($page == $guests->currentPage())
                                <span class="active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($guests->hasMorePages())
                            <a href="{{ $guests->nextPageUrl() }}">Selanjutnya →</a>
                        @else
                            <span class="disabled">Selanjutnya →</span>
                        @endif
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">👥</div>
                    <h3>Belum Ada Tamu</h3>
                    <p>Mulai tambahkan daftar tamu untuk undangan Anda</p>
                    <button class="btn btn-primary" onclick="openAddModal()">
                        Tambah Tamu Pertama
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Add Guest Modal -->
    <div class="modal" id="addModal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeAddModal()">×</button>
            <div class="modal-header">
                <h2>Tambah Tamu Baru</h2>
                <p class="modal-subtitle">Masukkan nama tamu untuk menambahkan ke daftar</p>
            </div>
            <form id="addForm" action="{{ route('guests.store') }}" method="POST" onsubmit="handleAddFormSubmit(event)" class="modal-form">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nama Tamu <span class="required-star">*</span></label>
                    <input type="text" name="name" class="form-input" placeholder="Masukkan nama lengkap" required autofocus>
                </div>
                <div class="form-group">
                    <label class="form-label">Nomor WhatsApp <span class="required-star">*</span></label>
                    <div class="whatsapp-input-group">
                        <span class="whatsapp-prefix">+62</span>
                        <input type="text" name="whatsapp" class="form-input whatsapp-input" id="addWhatsappInput" placeholder="82216210360" data-format="add" required>
                    </div>
                    <p class="input-help-text">Nomor tanpa +62 (contoh: 82216210360)</p>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeAddModal()">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambahkan Tamu</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Guest Modal -->
    <div class="modal" id="editModal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeEditModal()">×</button>
            <div class="modal-header">
                <h2>Edit Nama Tamu</h2>
                <p class="modal-subtitle">Ubah nama tamu di daftar</p>
            </div>
            <form id="editForm" method="POST" onsubmit="handleEditFormSubmit(event)" class="modal-form">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">Nama Tamu <span class="required-star">*</span></label>
                    <input type="text" id="editGuestName" name="name" class="form-input" placeholder="Masukkan nama lengkap" required autofocus>
                </div>
                <div class="form-group">
                    <label class="form-label">Nomor WhatsApp <span class="required-star">*</span></label>
                    <div class="whatsapp-input-group">
                        <span class="whatsapp-prefix">+62</span>
                        <input type="text" id="editWhatsappInput" name="whatsapp" class="form-input whatsapp-input" placeholder="82216210360" data-format="edit" required>
                    </div>
                    <p class="input-help-text">Nomor tanpa +62 (contoh: 82216210360)</p>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="confirmation-modal" id="confirmationModal">
        <div class="confirmation-content">
            <div class="confirmation-icon">⚠️</div>
            <h3 class="confirmation-title" id="confirmationTitle">Hapus Tamu?</h3>
            <p class="confirmation-text">Tindakan ini tidak dapat dibatalkan. Semua data tamu akan dihapus secara permanen.</p>
            <div class="confirmation-actions">
                <button type="button" class="btn btn-secondary" onclick="closeDeleteConfirmation()">Batal</button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">Hapus Sekarang</button>
            </div>
        </div>
    </div>

    @endsection

@section('extra-js')
    <script src="{{ asset('js/admin-dashboard.js') }}"></script>
@endsection
