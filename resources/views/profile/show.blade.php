{{-- resources/views/profile/show.blade.php --}}
@extends(Auth::user()->role === 'admin' ? 'layouts.admin' : 'layouts.user')

@section('title', 'Profil Saya')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2">
        <i class="bi bi-person-circle"></i> Profil Saya
    </h1>
</div>

<div class="row">
    <!-- Kolom Kiri - Avatar & Info -->
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <!-- Avatar -->
                <div class="position-relative d-inline-block mb-3">
                    @php
                        $avatarUrl = $user->avatar ? Storage::url($user->avatar) : 'https://ui-avatars.com/api/?background=3498db&color=fff&size=200&name=' . urlencode($user->full_name);
                    @endphp
                    <img src="{{ $avatarUrl }}" 
                         alt="{{ $user->full_name }}" 
                         class="rounded-circle img-thumbnail"
                         style="width: 150px; height: 150px; object-fit: cover;">
                    <button type="button" class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle" 
                            data-bs-toggle="modal" data-bs-target="#uploadAvatarModal"
                            style="width: 40px; height: 40px;">
                        <i class="bi bi-camera"></i>
                    </button>
                </div>
                
                <h4 class="mb-1">{{ $user->full_name }}</h4>
                <p class="text-muted mb-2">
                    <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : 'info' }}">
                        {{ $user->role == 'admin' ? 'Administrator' : 'Karyawan' }}
                    </span>
                </p>
                <p class="text-muted small">
                    <i class="bi bi-calendar3"></i> Bergabung: {{ $user->created_at->format('d F Y') }}
                </p>
                
                <hr>
                
                <div class="row text-start">
                    <div class="col-12 mb-2">
                        <small class="text-muted d-block">Username</small>
                        <strong><code>{{ $user->username }}</code></strong>
                    </div>
                    <div class="col-12 mb-2">
                        <small class="text-muted d-block">Email</small>
                        <strong>{{ $user->email }}</strong>
                    </div>
                    @if($user->department)
                    <div class="col-12 mb-2">
                        <small class="text-muted d-block">Departemen</small>
                        <strong>{{ $user->department }}</strong>
                    </div>
                    @endif
                    @if($user->phone)
                    <div class="col-12 mb-2">
                        <small class="text-muted d-block">No. Telepon</small>
                        <strong>{{ $user->phone }}</strong>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Statistik -->
        <div class="card mt-4">
            <div class="card-header">
                <i class="bi bi-graph-up"></i> Statistik Aktivitas
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <h3 class="mb-0 text-primary">{{ $user->tickets()->count() }}</h3>
                        <small class="text-muted">Total Tiket</small>
                    </div>
                    <div class="col-6 mb-3">
                        <h3 class="mb-0 text-success">{{ $user->tickets()->where('status', 'Resolved')->count() }}</h3>
                        <small class="text-muted">Tiket Selesai</small>
                    </div>
                    <div class="col-6">
                        <h3 class="mb-0 text-warning">{{ $user->tickets()->whereIn('status', ['Open', 'In Progress'])->count() }}</h3>
                        <small class="text-muted">Dalam Proses</small>
                    </div>
                    <div class="col-6">
                        <h3 class="mb-0 text-secondary">{{ $user->responses()->count() }}</h3>
                        <small class="text-muted">Total Respon</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Kolom Kanan - Edit Profile & Change Password -->
    <div class="col-md-8">
        <!-- Edit Profile Form -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-pencil-square"></i> Edit Profil
            </div>
            <div class="card-body">
                <form action="{{ route(Auth::user()->role . '.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
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
                            <label for="phone" class="form-label">No. Telepon</label>
                            <input type="text" name="phone" id="phone" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="department" class="form-label">Departemen</label>
                            <input type="text" name="department" id="department" 
                                   class="form-control @error('department') is-invalid @enderror" 
                                   value="{{ old('department', $user->department) }}">
                            @error('department')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Change Password Form -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-key"></i> Ubah Password
            </div>
            <div class="card-body">
                <form action="{{ route(Auth::user()->role . '.profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                        <input type="password" name="current_password" id="current_password" 
                               class="form-control @error('current_password') is-invalid @enderror" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="new_password" class="form-label">Password Baru <span class="text-danger">*</span></label>
                            <input type="password" name="new_password" id="new_password" 
                                   class="form-control @error('new_password') is-invalid @enderror" required>
                            <small class="text-muted">Minimal 6 karakter</small>
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" 
                                   class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> 
                        Password harus terdiri dari minimal 6 karakter. Gunakan kombinasi huruf dan angka untuk keamanan yang lebih baik.
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-key"></i> Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Upload Avatar -->
<div class="modal fade" id="uploadAvatarModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route(Auth::user()->role . '.profile.avatar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-camera"></i> Upload Foto Profil
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <img src="{{ $avatarUrl }}" 
                             alt="Preview" 
                             id="avatarPreview"
                             class="rounded-circle img-thumbnail"
                             style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Pilih Foto</label>
                        <input type="file" name="avatar" id="avatar" 
                               class="form-control @error('avatar') is-invalid @enderror" 
                               accept="image/*" required>
                        <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                        @error('avatar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-upload"></i> Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Preview avatar sebelum upload
    document.getElementById('avatar').addEventListener('change', function(e) {
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById('avatarPreview');
            preview.src = reader.result;
        }
        reader.readAsDataURL(e.target.files[0]);
    });
    
    // Validasi password confirmation
    const newPassword = document.getElementById('new_password');
    const confirmPassword = document.getElementById('new_password_confirmation');
    
    function validatePassword() {
        if (newPassword.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Password tidak cocok');
        } else {
            confirmPassword.setCustomValidity('');
        }
    }
    
    newPassword.onchange = validatePassword;
    confirmPassword.onkeyup = validatePassword;
</script>
@endpush

@push('styles')
<style>
    .img-thumbnail {
        border: 3px solid #fff;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    
    .card {
        border: none;
        box-shadow: 0 0 20px rgba(0,0,0,0.05);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
        border: none;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(52,152,219,0.3);
    }
</style>
@endpush
@endsection