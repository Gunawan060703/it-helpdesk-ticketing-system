@extends('layouts.user')

@section('title', 'Buat Tiket Baru')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h2">
            <i class="bi bi-plus-circle"></i> Buat Tiket Baru
        </h1>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('user.store-ticket') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategori Masalah <span class="text-danger">*</span></label>
                            <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Masalah <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title') }}" placeholder="Contoh: Komputer tidak bisa menyala" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Masalah <span class="text-danger">*</span></label>
                            <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror" 
                                      placeholder="Jelaskan masalah yang dialami secara detail..." required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="priority" class="form-label">Prioritas <span class="text-danger">*</span></label>
                            <select name="priority" id="priority" class="form-select @error('priority') is-invalid @enderror" required>
                                <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>Low - Normal (Tidak mendesak)</option>
                                <option value="Medium" {{ old('priority') == 'Medium' ? 'selected' : '' }}>Medium - Penting (Mempengaruhi pekerjaan)</option>
                                <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>High - Kritis (Mengganggu operasional)</option>
                            </select>
                            <small class="text-muted">Pilih prioritas sesuai dengan tingkat urgensi masalah</small>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Setelah tiket dibuat, tim IT akan segera menindaklanjuti laporan Anda.
                            Anda dapat memantau status tiket melalui menu "Tiket Saya".
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-gradient">
                                <i class="bi bi-send"></i> Kirim Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection