{{-- resources/views/user/my-tickets.blade.php --}}
@extends('layouts.user')

@section('title', 'Tiket Saya')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h2">
            <i class="bi bi-ticket-perforated"></i> Tiket Saya
        </h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('user.create-ticket') }}" class="btn btn-gradient">
                <i class="bi bi-plus-circle"></i> Buat Tiket Baru
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Cari</label>
                    <input type="text" name="search" class="form-control" placeholder="Cari nomor tiket atau judul..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-search"></i> Filter
                    </button>
                    <a href="{{ route('user.my-tickets') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-repeat"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tickets Table -->
    <div class="card">
        <div class="card-body">
            @if($tickets->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No. Tiket</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Prioritas</th>
                                <th>Status</th>
                                <th>Tanggal Dibuat</th>
                                <th>Terakhir Update</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
                                <tr>
                                    <td><code class="ticket-number">{{ $ticket->ticket_number }}</code></td>
                                    <td>{{ Str::limit($ticket->title, 50) }}</td>
                                    <td><span class="badge bg-info">{{ $ticket->category->name }}</span></td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $ticket->priority == 'High' ? 'danger' : ($ticket->priority == 'Medium' ? 'warning' : 'success') }}">
                                            {{ $ticket->priority }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $ticket->status == 'Open' ? 'danger' : ($ticket->status == 'In Progress' ? 'warning' : ($ticket->status == 'Resolved' ? 'success' : 'secondary')) }}">
                                            {{ $ticket->status }}
                                        </span>
                                    </td>
                                    <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $ticket->updated_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('user.ticket.detail', $ticket->id) }}"
                                                class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @if(in_array($ticket->status, ['Open', 'In Progress']))
                                                <a href="{{ route('user.ticket.edit', $ticket->id) }}"
                                                    class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            @endif
                                            @if($ticket->status == 'Open')
                                                <form action="{{ route('user.ticket.delete', $ticket->id) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus tiket {{ $ticket->ticket_number }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip"
                                                        title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $tickets->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <p class="text-muted mt-2">Belum ada tiket yang ditemukan</p>
                    <a href="{{ route('user.create-ticket') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Buat Tiket Sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection