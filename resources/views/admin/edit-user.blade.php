{{-- resources/views/admin/edit-user.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit User - ' . $user->full_name)

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2">
        <i class="bi bi-pencil-square"></i> Edit User
        <small class="text-muted">{{ $user->full_name }}</small>
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.users') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-info-circle"></i> Form Edit User
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" id="username" 
                                   class="form-control @error('username') is-invalid @enderror" 
                                   value="{{ old('username', $user->username) }}" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="full_name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="full_name" id="full_name" 
                                   class="form-control @error('full_name') is-invalid @enderror" 
                                   value="{{ old('full_name', $user->full_name) }}" required>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">No. Telepon</label>
                            <input type="text" name="phone" id="phone" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="department" class="form-label">Departemen</label>
                            <input type="text" name="department" id="department" 
                                   class="form-control @error('department') is-invalid @enderror" 
                                   value="{{ old('department', $user->department) }}">
                            <small class="text-muted">Contoh: Front Office, Housekeeping, F&B, IT, dll</small>
                            @error('department')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                            <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User (Karyawan)</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin (IT Support)</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" name="password" id="password" 
                                   class="form-control @error('password') is-invalid @enderror">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                   class="form-control">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        <small class="text-muted">User dengan status nonaktif tidak dapat login ke sistem</small>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Informasi User -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-person-circle"></i> Informasi User
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="avatar-circle mb-2">
                        <i class="bi bi-person fs-1"></i>
                    </div>
                    <h5>{{ $user->full_name }}</h5>
                    <p class="text-muted small">Bergabung: {{ $user->created_at->format('d F Y') }}</p>
                </div>
                
                <hr>
                
                <div class="mb-2">
                    <strong>ID User:</strong><br>
                    <code>#{{ $user->id }}</code>
                </div>
                
                <div class="mb-2">
                    <strong>Total Tiket:</strong><br>
                    <span class="badge bg-primary">{{ $user->tickets_count ?? 0 }} tiket</span>
                </div>
                
                <div class="mb-2">
                    <strong>Terakhir Update:</strong><br>
                    {{ $user->updated_at->format('d F Y H:i') }}
                </div>
                
                @if($user->role == 'admin')
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="bi bi-shield-check"></i> User ini memiliki akses sebagai Administrator
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Panduan Edit User -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-question-circle"></i> Panduan
            </div>
            <div class="card-body">
                <h6>Tips Mengedit User:</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success"></i> 
                        <strong>Username & Email</strong><br>
                        <small class="text-muted">Pastikan username dan email unik tidak ada yang sama</small>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success"></i> 
                        <strong>Role</strong><br>
                        <small class="text-muted">
                            - Admin: Akses penuh ke semua fitur<br>
                            - User: Hanya dapat membuat dan melihat tiket sendiri
                        </small>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success"></i> 
                        <strong>Status</strong><br>
                        <small class="text-muted">
                            - Aktif: Dapat login ke sistem<br>
                            - Nonaktif: Tidak dapat login
                        </small>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success"></i> 
                        <strong>Password</strong><br>
                        <small class="text-muted">Kosongkan password jika tidak ingin mengubahnya</small>
                    </li>
                </ul>
                
                <div class="alert alert-warning mt-3 mb-0">
                    <i class="bi bi-exclamation-triangle"></i>
                    <small>Perubahan akan langsung berlaku setelah disimpan</small>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .avatar-circle {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        color: white;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }
    
    .card {
        border: none;
        box-shadow: 0 0 20px rgba(0,0,0,0.05);
    }
</style>
@endpush

@push('scripts')
<script>
    // Preview perubahan role
    document.getElementById('role').addEventListener('change', function() {
        const role = this.value;
        const alertDiv = document.querySelector('.alert-info');
        if (alertDiv) {
            if (role === 'admin') {
                alertDiv.style.display = 'block';
            } else {
                alertDiv.style.display = 'none';
            }
        }
    });
    
    // Validasi password confirmation
    const password = document.getElementById('password');
    const passwordConfirm = document.getElementById('password_confirmation');
    
    function validatePassword() {
        if (password.value !== passwordConfirm.value) {
            passwordConfirm.setCustomValidity('Password tidak cocok');
        } else {
            passwordConfirm.setCustomValidity('');
        }
    }
    
    password.onchange = validatePassword;
    passwordConfirm.onkeyup = validatePassword;
</script>
@endpush
@endsection