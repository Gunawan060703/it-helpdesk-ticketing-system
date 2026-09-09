@extends('layouts.user')

@section('title', 'Edit Tiket #' . $ticket->ticket_number)

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2">
        <i class="bi bi-pencil-square"></i> Edit Tiket
        <small class="text-muted">#{{ $ticket->ticket_number }}</small>
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('user.my-tickets') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Form Edit Tiket</div>
            <div class="card-body">
                <form action="{{ route('user.ticket.update', $ticket->id) }}" method="POST">
                    @csrf @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Nomor Tiket</label>
                        <input type="text" class="form-control" value="{{ $ticket->ticket_number }}" readonly disabled>
                    </div>
                    
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $ticket->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Masalah <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ $ticket->title }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Masalah <span class="text-danger">*</span></label>
                        <textarea name="description" rows="5" class="form-control" required>{{ $ticket->description }}</textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="priority" class="form-label">Prioritas <span class="text-danger">*</span></label>
                        <select name="priority" class="form-select" required>
                            <option value="Low" {{ $ticket->priority == 'Low' ? 'selected' : '' }}>Low - Normal</option>
                            <option value="Medium" {{ $ticket->priority == 'Medium' ? 'selected' : '' }}>Medium - Penting</option>
                            <option value="High" {{ $ticket->priority == 'High' ? 'selected' : '' }}>High - Kritis</option>
                        </select>
                    </div>
                    
                    <div class="alert alert-info">Status saat ini: <strong>{{ $ticket->status }}</strong></div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('user.my-tickets') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Informasi</div>
            <div class="card-body">
                <p><strong>Dibuat:</strong> {{ $ticket->created_at->format('d F Y H:i') }}</p>
                <p><strong>Update:</strong> {{ $ticket->updated_at->format('d F Y H:i') }}</p>
                <div class="alert alert-warning mt-3">
                    <i class="bi bi-exclamation-triangle"></i> Hanya tiket dengan status Open/In Progress yang dapat diedit.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection