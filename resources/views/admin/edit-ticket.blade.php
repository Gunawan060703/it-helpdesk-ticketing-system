@extends('layouts.admin')

@section('title', 'Edit Tiket #' . $ticket->ticket_number)

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h2">
            <i class="bi bi-pencil-square"></i> Edit Tiket
            <small class="text-muted">#{{ $ticket->ticket_number }}</small>
        </h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.tickets') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-info-circle"></i> Form Edit Tiket
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.ticket.update', $ticket->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nomor Tiket</label>
                            <input type="text" class="form-control" value="{{ $ticket->ticket_number }}" readonly disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pelapor</label>
                            <input type="text" class="form-control" value="{{ $ticket->user->full_name }}" readonly
                                disabled>
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror"
                                required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $ticket->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Masalah <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title', $ticket->title) }}" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Masalah <span
                                    class="text-danger">*</span></label>
                            <textarea name="description" rows="5"
                                class="form-control @error('description') is-invalid @enderror"
                                required>{{ old('description', $ticket->description) }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="priority" class="form-label">Prioritas <span
                                        class="text-danger">*</span></label>
                                <select name="priority" class="form-select @error('priority') is-invalid @enderror"
                                    required>
                                    <option value="Low" {{ old('priority', $ticket->priority) == 'Low' ? 'selected' : '' }}>
                                        Low</option>
                                    <option value="Medium" {{ old('priority', $ticket->priority) == 'Medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="High" {{ old('priority', $ticket->priority) == 'High' ? 'selected' : '' }}>
                                        High</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="Open" {{ old('status', $ticket->status) == 'Open' ? 'selected' : '' }}>Open
                                    </option>
                                    <option value="In Progress" {{ old('status', $ticket->status) == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="Resolved" {{ old('status', $ticket->status) == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                                    <option value="Closed" {{ old('status', $ticket->status) == 'Closed' ? 'selected' : '' }}>
                                        Closed</option>
                                </select>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.tickets') }}" class="btn btn-secondary">Batal</a>
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
                    @if($ticket->completed_at)
                    <p><strong>Selesai:</strong> {{ $ticket->completed_at->format('d F Y H:i') }}</p>@endif
                </div>
            </div>
        </div>
    </div>
@endsection