@extends('layouts.user')

@section('title', 'Detail Tiket #' . $ticket->ticket_number)

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="bi bi-ticket-perforated"></i> Detail Tiket
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
            <!-- Ticket Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-info-circle"></i> Informasi Tiket
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Nomor Tiket:</div>
                        <div class="col-md-9"><code>{{ $ticket->ticket_number }}</code></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Judul Masalah:</div>
                        <div class="col-md-9">{{ $ticket->title }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Kategori:</div>
                        <div class="col-md-9">{{ $ticket->category->name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Prioritas:</div>
                        <div class="col-md-9">
                            <span
                                class="badge bg-{{ $ticket->priority == 'High' ? 'danger' : ($ticket->priority == 'Medium' ? 'warning' : 'success') }}">
                                {{ $ticket->priority }}
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Status:</div>
                        <div class="col-md-9">
                            <span
                                class="badge bg-{{ $ticket->status == 'Open' ? 'danger' : ($ticket->status == 'In Progress' ? 'warning' : ($ticket->status == 'Resolved' ? 'success' : 'secondary')) }}">
                                {{ $ticket->status }}
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Tanggal Dibuat:</div>
                        <div class="col-md-9">{{ $ticket->created_at->format('d F Y H:i') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Terakhir Update:</div>
                        <div class="col-md-9">{{ $ticket->updated_at->format('d F Y H:i') }}</div>
                    </div>
                    @if($ticket->completed_at)
                        <div class="row mb-3">
                            <div class="col-md-3 fw-bold">Selesai pada:</div>
                            <div class="col-md-9">{{ $ticket->completed_at->format('d F Y H:i') }}</div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-3 fw-bold">Deskripsi:</div>
                        <div class="col-md-9">
                            <div class="p-3 bg-light rounded">
                                {{ $ticket->description }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Responses -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-chat-dots"></i> Riwayat Respon
                    </h5>
                </div>
                <div class="card-body">
                    @if($ticket->responses->count() > 0)
                        <div class="timeline">
                            @foreach($ticket->responses as $response)
                                <div class="timeline-item">
                                    <div class="d-flex justify-content-between">
                                        <strong>
                                            @if($response->is_admin_response)
                                                <i class="bi bi-shield-check text-primary"></i> IT Support
                                            @else
                                                <i class="bi bi-person text-success"></i> {{ $response->user->full_name }}
                                            @endif
                                        </strong>
                                        <small class="text-muted">{{ $response->created_at->format('d F Y H:i') }}</small>
                                    </div>
                                    <div class="mt-2 p-3 bg-light rounded">
                                        {!! nl2br(e($response->response)) !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-chat-square-text fs-1 text-muted"></i>
                            <p class="text-muted mt-2">Belum ada respon</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Add Response -->
            @if($ticket->status != 'Closed')
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-reply"></i> Tambah Respon
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.ticket.add-response', $ticket->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <textarea name="response" rows="4" class="form-control"
                                    placeholder="Tulis respon atau informasi tambahan..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-send"></i> Kirim Respon
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Status Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-clock-history"></i> Status Progress
                    </h5>
                </div>
                <div class="card-body">
                    <div class="progress mb-3" style="height: 30px;">
                        @php
                            $progress = 0;
                            if ($ticket->status == 'Open')
                                $progress = 25;
                            elseif ($ticket->status == 'In Progress')
                                $progress = 50;
                            elseif ($ticket->status == 'Resolved')
                                $progress = 75;
                            elseif ($ticket->status == 'Closed')
                                $progress = 100;
                        @endphp
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-{{ $ticket->status == 'Open' ? 'danger' : ($ticket->status == 'In Progress' ? 'warning' : ($ticket->status == 'Resolved' ? 'success' : 'secondary')) }}"
                            style="width: {{ $progress }}%">
                            {{ $progress }}%
                        </div>
                    </div>

                    <div class="timeline-mini">
                        <div class="d-flex mb-3">
                            <div class="me-3">
                                <i
                                    class="bi bi-circle-fill text-{{ $ticket->status == 'Open' ? 'danger' : 'success' }}"></i>
                            </div>
                            <div>
                                <strong>Open</strong>
                                <div class="small text-muted">Tiket dibuat</div>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="me-3">
                                <i
                                    class="bi bi-circle-fill text-{{ $ticket->status == 'In Progress' ? 'warning' : ($ticket->status == 'Open' ? 'secondary' : 'success') }}"></i>
                            </div>
                            <div>
                                <strong>In Progress</strong>
                                <div class="small text-muted">Sedang ditangani IT Support</div>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="me-3">
                                <i
                                    class="bi bi-circle-fill text-{{ $ticket->status == 'Resolved' ? 'success' : ($ticket->status == 'Closed' ? 'success' : 'secondary') }}"></i>
                            </div>
                            <div>
                                <strong>Resolved</strong>
                                <div class="small text-muted">Masalah sudah selesai ditangani</div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="me-3">
                                <i
                                    class="bi bi-circle-fill text-{{ $ticket->status == 'Closed' ? 'secondary' : 'secondary' }}"></i>
                            </div>
                            <div>
                                <strong>Closed</strong>
                                <div class="small text-muted">Tiket ditutup</div>
                            </div>
                        </div>
                    </div>

                    @if($ticket->status == 'Resolved')
                        <hr>
                        <form action="{{ route('user.ticket.close', $ticket->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success w-100"
                                onclick="return confirm('Apakah masalah sudah selesai? Tiket akan ditutup.')">
                                <i class="bi bi-check-circle"></i> Tutup Tiket
                            </button>
                        </form>
                        <small class="text-muted d-block mt-2 text-center">
                            Jika masalah sudah selesai, tutup tiket untuk menyelesaikan proses.
                        </small>
                    @endif
                </div>
            </div>

            <!-- History Status Logs -->
            @if($ticket->statusLogs->count() > 0)
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-arrow-repeat"></i> Riwayat Perubahan Status
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @foreach($ticket->statusLogs as $log)
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between">
                                        <small>
                                            <i class="bi bi-arrow-right-short"></i>
                                            @if($log->old_status)
                                                {{ $log->old_status }} → {{ $log->new_status }}
                                            @else
                                                {{ $log->new_status }}
                                            @endif
                                        </small>
                                        <small class="text-muted">{{ $log->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <div class="small text-muted">
                                        Oleh: {{ $log->changer->full_name }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection