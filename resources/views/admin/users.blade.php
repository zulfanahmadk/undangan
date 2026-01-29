@extends('layouts.admin')

@section('title', 'Manajemen Admin User')

@section('content')
    <div class="users-page">
        <div class="page-header">
            <h1>👤 Manajemen Admin User</h1>
            <p>Kelola akun admin untuk sistem manajemen undangan</p>
            <button class="btn btn-primary" onclick="openAddUserModal()">
                ➕ Tambah Admin User
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

        <div class="users-section">
            <div class="users-header">
                <div class="stat-card">
                    <div class="stat-label">Total Admin User</div>
                    <div class="stat-value">{{ $users->total() }}</div>
                </div>
            </div>

            @if ($users->count() > 0)
                <div class="table-responsive">
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Terdaftar Sejak</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <div class="user-name">{{ $user->name }}</div>
                                    </td>
                                    <td>
                                        <div class="user-email">{{ $user->email }}</div>
                                    </td>
                                    <td>
                                        <div class="user-roles">
                                            @foreach ($user->roles as $role)
                                                <span class="role-badge role-{{ $role->name }}">
                                                    @if ($role->name === 'admin')
                                                        👑 Admin
                                                    @elseif ($role->name === 'user')
                                                        👤 User
                                                    @else
                                                        {{ ucfirst($role->name) }}
                                                    @endif
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        <div class="user-date">{{ $user->created_at->format('d M Y H:i') }}</div>
                                    </td>
                                    <td>
                                        <div class="table-actions">
                                            <button class="btn btn-edit btn-sm" onclick="openEditUserModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}', {{ $user->roles->first()->id ?? 2 }})">
                                                ✏️ Edit
                                            </button>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;" class="delete-form" data-user-name="{{ $user->name }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    🗑️ Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($users->hasPages())
                    <div class="pagination">
                        @if ($users->onFirstPage())
                            <span class="disabled">← Sebelumnya</span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}">← Sebelumnya</a>
                        @endif

                        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                            @if ($page == $users->currentPage())
                                <span class="active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}">Selanjutnya →</a>
                        @else
                            <span class="disabled">Selanjutnya →</span>
                        @endif
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">👤</div>
                    <h3>Belum Ada Admin User</h3>
                    <p>Tambahkan admin user pertama untuk memulai</p>
                    <button class="btn btn-primary" onclick="openAddUserModal()">
                        ➕ Tambah Admin User Pertama
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal" id="addUserModal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeAddUserModal()">×</button>
            <div class="modal-header">
                <h2>Tambah Admin User</h2>
                <p class="modal-subtitle">Buat akun admin baru untuk sistem</p>
            </div>
            <form id="addUserForm" action="{{ route('users.store') }}" method="POST" onsubmit="handleAddUserFormSubmit(event)" class="modal-form">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nama <span class="required-star">*</span></label>
                    <input type="text" name="name" class="form-input" placeholder="Masukkan nama admin" required autofocus>
                </div>
                <div class="form-group">
                    <label class="form-label">Email <span class="required-star">*</span></label>
                    <input type="email" name="email" class="form-input" placeholder="Masukkan email admin" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Role <span class="required-star">*</span></label>
                    <select name="role_id" class="form-input" required>
                        <option value="">Pilih Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">
                                @if ($role->name === 'admin')
                                    👑 Admin
                                @elseif ($role->name === 'user')
                                    👤 User
                                @else
                                    {{ ucfirst($role->name) }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Password <span class="required-star">*</span></label>
                    <input type="password" name="password" class="form-input" placeholder="Masukkan password" required>
                    <p class="input-help-text">Minimal 6 karakter</p>
                </div>
                <div class="form-group">
                    <label class="form-label">Konfirmasi Password <span class="required-star">*</span></label>
                    <input type="password" name="password_confirmation" class="form-input" placeholder="Konfirmasi password" required>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeAddUserModal()">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambahkan User</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal" id="editUserModal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeEditUserModal()">×</button>
            <div class="modal-header">
                <h2>Edit Admin User</h2>
                <p class="modal-subtitle">Ubah data admin user</p>
            </div>
            <form id="editUserForm" method="POST" onsubmit="handleEditUserFormSubmit(event)" class="modal-form">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">Nama <span class="required-star">*</span></label>
                    <input type="text" id="editUserName" name="name" class="form-input" placeholder="Masukkan nama admin" required autofocus>
                </div>
                <div class="form-group">
                    <label class="form-label">Email <span class="required-star">*</span></label>
                    <input type="email" id="editUserEmail" name="email" class="form-input" placeholder="Masukkan email admin" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Role <span class="required-star">*</span></label>
                    <select id="editUserRole" name="role_id" class="form-input" required>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">
                                @if ($role->name === 'admin')
                                    👑 Admin
                                @elseif ($role->name === 'user')
                                    👤 User
                                @else
                                    {{ ucfirst($role->name) }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" name="password" class="form-input" placeholder="Masukkan password baru">
                    <p class="input-help-text">Minimal 6 karakter. Kosongkan untuk tetap menggunakan password lama</p>
                </div>
                <div class="form-group">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-input" placeholder="Konfirmasi password baru">
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeEditUserModal()">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="confirmation-modal" id="deleteUserConfirmationModal">
        <div class="confirmation-content">
            <div class="confirmation-icon">⚠️</div>
            <h3 class="confirmation-title">Hapus Admin User?</h3>
            <p class="confirmation-text">Tindakan ini tidak dapat dibatalkan. Admin user akan dihapus secara permanen.</p>
            <div class="confirmation-actions">
                <button type="button" class="btn btn-secondary" onclick="closeDeleteUserConfirmation()">Batal</button>
                <button type="button" class="btn btn-danger" onclick="confirmDeleteUser()">Hapus Sekarang</button>
            </div>
        </div>
    </div>

@endsection

@section('extra-js')
    <script src="{{ asset('js/admin-users.js') }}"></script>
@endsection
