{{-- resources/views/user/dashboard.blade.php --}}
@extends('layouts.user')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Welcome Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-primary-gradient text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-1">Selamat Datang, {{ Auth::user()->full_name }}!</h3>
                        <p class="mb-0 opacity-75">Sistem Layanan IT Helpdesk Hotel Loccal Collection Labuan Bajo</p>
                    </div>
                    <div class="text-center">
                        <i class="bi bi-headset" style="font-size: 48px; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card bg-primary-gradient text-white">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="bi bi-ticket-perforated"></i>
                </div>
                <div class="stat-value">{{ $stats['total'] }}</div>
                <div class="stat-label">Total Tiket</div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card bg-warning-gradient text-white">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div class="stat-value">{{ $stats['open'] + $stats['in_progress'] }}</div>
                <div class="stat-label">Dalam Proses</div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card bg-success-gradient text-white">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-value">{{ $stats['resolved'] }}</div>
                <div class="stat-label">Selesai</div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card bg-secondary-gradient text-white">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="bi bi-archive"></i>
                </div>
                <div class="stat-value">{{ $stats['closed'] }}</div>
                <div class="stat-label">Ditutup</div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Action & Recent Tickets -->
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-lightning-charge"></i> Aksi Cepat
            </div>
            <div class="card-body">
                <div class="d-grid gap-3">
                    <a href="{{ route('user.create-ticket') }}" class="btn btn-gradient btn-lg">
                        <i class="bi bi-plus-circle"></i> Buat Tiket Baru
                    </a>
                    <a href="{{ route('user.my-tickets') }}" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-ticket-perforated"></i> Lihat Tiket Saya
                    </a>
                </div>
                
                <hr>
                
                <div class="info-box">
                    <h6><i class="bi bi-info-circle"></i> Informasi Layanan</h6>
                    <ul class="small text-muted">
                        <li>Layanan IT Support tersedia 24/7</li>
                        <li>Setiap laporan akan mendapatkan nomor tiket</li>
                        <li>Anda dapat memantau status tiket melalui menu "Tiket Saya"</li>
                        <li>Tim IT akan merespon laporan sesuai prioritas</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-clock-history"></i> Tiket Terbaru Anda
            </div>
            <div class="card-body">
                @if($recentTickets->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No. Tiket</th>
                                    <th>Judul</th>
                                    <th>Prioritas</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentTickets as $ticket)
                                <tr>
                                    <td><code class="ticket-number">{{ $ticket->ticket_number }}</code></td>
                                    <td>{{ Str::limit($ticket->title, 35) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $ticket->priority == 'High' ? 'danger' : ($ticket->priority == 'Medium' ? 'warning' : 'success') }}">
                                            {{ $ticket->priority }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $ticket->status == 'Open' ? 'danger' : ($ticket->status == 'In Progress' ? 'warning' : ($ticket->status == 'Resolved' ? 'success' : 'secondary')) }}">
                                            {{ $ticket->status }}
                                        </span>
                                    </td>
                                    <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('user.ticket.detail', $ticket->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox fs-1 text-muted"></i>
                        <p class="text-muted mt-2">Belum ada tiket yang dibuat</p>
                        <a href="{{ route('user.create-ticket') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Buat Tiket Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Informasi Layanan -->
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-shield-check"></i> Layanan IT Support
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 text-center">
                        <div class="p-3">
                            <i class="bi bi-clock fs-1 text-primary"></i>
                            <h5 class="mt-2">24/7</h5>
                            <p class="text-muted small">Layanan tersedia<br>setiap saat</p>
                        </div>
                    </div>
                    <div class="col-6 text-center">
                        <div class="p-3">
                            <i class="bi bi-ticket-perforated fs-1 text-success"></i>
                            <h5 class="mt-2">Terstruktur</h5>
                            <p class="text-muted small">Setiap laporan<br>memiliki nomor tiket</p>
                        </div>
                    </div>
                    <div class="col-6 text-center">
                        <div class="p-3">
                            <i class="bi bi-graph-up fs-1 text-warning"></i>
                            <h5 class="mt-2">Terpantau</h5>
                            <p class="text-muted small">Status penanganan<br>dapat dipantau</p>
                        </div>
                    </div>
                    <div class="col-6 text-center">
                        <div class="p-3">
                            <i class="bi bi-archive fs-1 text-secondary"></i>
                            <h5 class="mt-2">Terdokumentasi</h5>
                            <p class="text-muted small">Riwayat laporan<br>tersimpan lengkap</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-question-circle"></i> Butuh Bantuan?
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#helpModal" class="text-decoration-none">
                            <div class="p-3 border rounded">
                                <i class="bi bi-book fs-1 text-primary"></i>
                                <p class="mt-2 mb-0">Panduan</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#contactModal" class="text-decoration-none">
                            <div class="p-3 border rounded">
                                <i class="bi bi-headset fs-1 text-success"></i>
                                <p class="mt-2 mb-0">Hubungi IT Support</p>
                            </div>
                        </a>
                    </div>
                </div>
                
                <hr>
                
                <div class="text-center">
                    <p class="small text-muted mb-0">
                        <i class="bi bi-envelope"></i> itsupport@hotelloccal.com | 
                        <i class="bi bi-telephone"></i> Ext. 1234
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection