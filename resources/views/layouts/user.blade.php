<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - IT Helpdesk Hotel Loccal Collection</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f0f2f5;
            overflow-x: hidden;
        }
        
        /* ========== SIDEBAR STYLES ========== */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: 280px;
            background: linear-gradient(180deg, #1a1c23 0%, #0f1117 100%);
            color: #fff;
            z-index: 1050;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
            overflow-x: hidden;
            box-shadow: 5px 0 25px rgba(0,0,0,0.15);
        }
        
        .sidebar::-webkit-scrollbar {
            width: 5px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 10px;
        }
        
        /* Sidebar Brand */
        .sidebar-brand {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            margin-bottom: 20px;
        }
        
        .sidebar-brand .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .sidebar-brand .logo-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #3498db, #2c3e50);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 5px 15px rgba(52,152,219,0.3);
        }
        
        .sidebar-brand .logo-text {
            font-weight: 700;
            font-size: 18px;
            letter-spacing: 0.5px;
        }
        
        .sidebar-brand .logo-text small {
            display: block;
            font-size: 10px;
            opacity: 0.7;
            font-weight: 400;
            margin-top: 4px;
        }
        
        /* Sidebar User Info */
        .sidebar-user {
            padding: 0 20px 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            margin-bottom: 20px;
        }
        
        .user-avatar {
            width: 55px;
            height: 55px;
            background: linear-gradient(135deg, #3498db, #2c3e50);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 12px;
            border: 3px solid rgba(255,255,255,0.2);
        }
        
        .user-name {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 4px;
        }
        
        .user-role {
            font-size: 11px;
            opacity: 0.7;
        }
        
        /* Sidebar Navigation */
        .sidebar-nav {
            padding: 0 15px;
        }
        
        .nav-section {
            margin-bottom: 25px;
        }
        
        .nav-section-title {
            padding: 10px 15px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255,255,255,0.4);
            font-weight: 600;
        }
        
        .nav-item {
            list-style: none;
            margin-bottom: 5px;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
            gap: 12px;
        }
        
        .nav-link i {
            font-size: 20px;
            width: 24px;
            transition: all 0.3s ease;
        }
        
        .nav-link span {
            flex: 1;
        }
        
        .nav-link:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
            transform: translateX(5px);
        }
        
        .nav-link.active {
            background: linear-gradient(135deg, #3498db, #2c3e50);
            color: #fff;
            box-shadow: 0 5px 15px rgba(52,152,219,0.3);
        }
        
        /* Sidebar Footer */
        .sidebar-footer {
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            padding: 0 20px;
        }
        
        .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            background: rgba(255,255,255,0.05);
            border-radius: 12px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
            width: 100%;
            border: none;
            cursor: pointer;
        }
        
        .logout-btn:hover {
            background: rgba(231,76,60,0.2);
            color: #e74c3c;
        }
        
        /* ========== MAIN CONTENT ========== */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Top Navbar */
        .top-navbar {
            background: #fff;
            padding: 15px 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1020;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .menu-toggle {
            background: none;
            border: none;
            font-size: 24px;
            color: #2c3e50;
            cursor: pointer;
            display: none;
            transition: all 0.3s;
        }
        
        .menu-toggle:hover {
            color: #3498db;
        }
        
        .page-title {
            font-size: 20px;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .navbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 30px;
            transition: background 0.3s;
        }
        
        .user-dropdown:hover {
            background: #f0f2f5;
        }
        
        .user-avatar-small {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #3498db, #2c3e50);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #fff;
        }
        
        .user-info {
            text-align: right;
        }
        
        .user-name-small {
            font-weight: 600;
            font-size: 14px;
            color: #2c3e50;
        }
        
        .user-role-small {
            font-size: 11px;
            color: #7f8c8d;
        }
        
        /* Content Wrapper */
        .content-wrapper {
            padding: 25px;
        }
        
        /* Stats Cards */
        .stat-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
            transition: all 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .stat-card .stat-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 3rem;
            opacity: 0.15;
        }
        
        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0;
        }
        
        .stat-card .stat-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.9;
        }
        
        /* Card Styles */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: all 0.3s;
            margin-bottom: 20px;
        }
        
        .card:hover {
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }
        
        .card-header {
            background: transparent;
            border-bottom: 1px solid #eef2f7;
            padding: 1rem 1.5rem;
            font-weight: 600;
        }
        
        /* Gradient Backgrounds */
        .bg-primary-gradient { background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%); }
        .bg-danger-gradient { background: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%); }
        .bg-warning-gradient { background: linear-gradient(135deg, #d35400 0%, #f39c12 100%); }
        .bg-success-gradient { background: linear-gradient(135deg, #1e8449 0%, #27ae60 100%); }
        .bg-secondary-gradient { background: linear-gradient(135deg, #7f8c8d 0%, #95a5a6 100%); }
        .bg-info-gradient { background: linear-gradient(135deg, #2471a3 0%, #3498db 100%); }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .menu-toggle {
                display: block;
            }
        }
        
        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        /* Overlay */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
            display: none;
        }
        
        .sidebar-overlay.show {
            display: block;
        }
        
        /* Ticket Number */
        .ticket-number {
            font-family: 'Courier New', monospace;
            font-weight: 600;
            font-size: 0.9rem;
            background: #f8f9fa;
            padding: 4px 8px;
            border-radius: 6px;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <!-- Brand -->
        <div class="sidebar-brand">
            <div class="brand-logo">
                <div class="logo-icon">
                    <i class="bi bi-headset"></i>
                </div>
                <div class="logo-text">
                    IT HELPDESK
                    <small>Loccal Collection Labuan Bajo</small>
                </div>
            </div>
        </div>
        
        <!-- User Info -->
        <div class="sidebar-user">
            <div class="user-avatar">
                <i class="bi bi-person"></i>
            </div>
            <div class="user-name">{{ Auth::user()->full_name }}</div>
            <div class="user-role">
                <span class="badge" style="background: rgba(255,255,255,0.2);">
                    Karyawan
                </span>
            </div>
        </div>
        
        <!-- Navigation -->
        <div class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">MAIN NAVIGATION</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" 
                           href="{{ route('user.dashboard') }}">
                            <i class="bi bi-speedometer2"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="nav-section">
                <div class="nav-section-title">TICKET</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('user.create-ticket') ? 'active' : '' }}" 
                           href="{{ route('user.create-ticket') }}">
                            <i class="bi bi-plus-circle"></i>
                            <span>Buat Tiket Baru</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('user.my-tickets*') ? 'active' : '' }}" 
                           href="{{ route('user.my-tickets') }}">
                            <i class="bi bi-ticket-perforated"></i>
                            <span>Tiket Saya</span>
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="nav-section">
                <div class="nav-section-title">INFORMASI</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#helpModal">
                            <i class="bi bi-question-circle"></i>
                            <span>Panduan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#contactModal">
                            <i class="bi bi-envelope"></i>
                            <span>Kontak IT Support</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
            <a href="{{ route('user.profile') }}" class="logout-btn" style="margin-bottom: 10px;">
                <i class="bi bi-person-circle"></i>
                <span>Profil Saya</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <button class="menu-toggle" id="menuToggle">
                <i class="bi bi-list"></i>
            </button>
            <div class="page-title">
                @yield('page-title', 'Dashboard')
            </div>
            <div class="navbar-right">
                <div class="dropdown">
                    <div class="user-dropdown" data-bs-toggle="dropdown">
                        <div class="user-info">
                            <div class="user-name-small">{{ Auth::user()->full_name }}</div>
                            <div class="user-role-small">Karyawan</div>
                        </div>
                        <div class="user-avatar-small">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('user.profile') }}">
                                <i class="bi bi-person"></i> Profil Saya
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Content -->
        <div class="content-wrapper">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show fade-in" role="alert">
                    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show fade-in" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>
    
    <!-- Modal Panduan -->
    <div class="modal fade" id="helpModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-question-circle"></i> Panduan Penggunaan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h6>Cara Membuat Tiket:</h6>
                    <ol>
                        <li>Klik menu "Buat Tiket Baru"</li>
                        <li>Pilih kategori masalah yang sesuai</li>
                        <li>Isi judul dan deskripsi masalah dengan jelas</li>
                        <li>Pilih prioritas masalah (Low/Medium/High)</li>
                        <li>Klik "Kirim Laporan"</li>
                    </ol>
                    <h6>Memantau Tiket:</h6>
                    <ol>
                        <li>Klik menu "Tiket Saya"</li>
                        <li>Lihat status tiket Anda</li>
                        <li>Klik "Detail" untuk melihat respon dari IT Support</li>
                        <li>Anda dapat menambah respon jika diperlukan</li>
                    </ol>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Kontak IT Support -->
    <div class="modal fade" id="contactModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-envelope"></i> Kontak IT Support
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <div class="logo-icon mx-auto" style="width: 60px; height: 60px; background: linear-gradient(135deg, #3498db, #2c3e50);">
                            <i class="bi bi-headset" style="font-size: 30px; color: white; line-height: 60px;"></i>
                        </div>
                    </div>
                    <div class="list-group">
                        <div class="list-group-item">
                            <i class="bi bi-envelope me-2"></i> 
                            <strong>Email:</strong> itsupport@hotelloccal.com
                        </div>
                        <div class="list-group-item">
                            <i class="bi bi-telephone me-2"></i> 
                            <strong>Telepon:</strong> Ext. 1234
                        </div>
                        <div class="list-group-item">
                            <i class="bi bi-clock me-2"></i> 
                            <strong>Jam Kerja:</strong> 24/7
                        </div>
                        <div class="list-group-item">
                            <i class="bi bi-building me-2"></i> 
                            <strong>Lokasi:</strong> Kantor IT, Lantai 2
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        // Auto hide alert
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
        
        // Mobile menu toggle
        $('#menuToggle').click(function() {
            $('#sidebar').toggleClass('show');
            $('#sidebarOverlay').toggleClass('show');
        });
        
        // Close sidebar when clicking overlay
        $('#sidebarOverlay').click(function() {
            $('#sidebar').removeClass('show');
            $('#sidebarOverlay').removeClass('show');
        });
        
        // Close sidebar on window resize
        $(window).resize(function() {
            if ($(window).width() > 992) {
                $('#sidebar').removeClass('show');
                $('#sidebarOverlay').removeClass('show');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>