
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes, viewport-fit=cover">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title'); ?> - Admin IT Helpdesk Hotel Loccal Collection</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">

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

        /* ========== SIDEBAR STYLES - TANPA SCROLL YANG TIDAK PERLU ========== */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: 280px;
            background: linear-gradient(180deg, #1a1c23 0%, #0f1117 100%);
            color: #fff;
            z-index: 1050;
            transition: transform 0.3s ease;
            overflow-y: auto;
            overflow-x: hidden;
            box-shadow: 5px 0 25px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
        }

        /* Scroll hanya muncul jika benar-benar perlu */
        .sidebar::-webkit-scrollbar {
            width: 3px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        /* Sidebar Brand */
        .sidebar-brand {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            flex-shrink: 0;
        }

        .sidebar-brand .brand-logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-brand .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #3498db, #2c3e50);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .sidebar-brand .logo-text {
            font-weight: 700;
            font-size: 14px;
            line-height: 1.3;
        }

        .sidebar-brand .logo-text small {
            display: block;
            font-size: 10px;
            opacity: 0.7;
            font-weight: 400;
            margin-top: 2px;
        }

        /* Sidebar User Info */
        .sidebar-user {
            padding: 15px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            flex-shrink: 0;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #3498db, #2c3e50);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 10px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            flex-shrink: 0;
        }

        .user-name {
            font-weight: 600;
            font-size: 13px;
            margin-bottom: 3px;
            word-break: break-word;
        }

        .user-role {
            font-size: 10px;
            opacity: 0.7;
        }

        .user-role .badge {
            font-size: 9px;
            padding: 2px 6px;
        }

        /* Sidebar Navigation - TANPA SCROLL BERLEBIH */
        .sidebar-nav {
            padding: 10px 12px;
            flex: 1;
        }

        .nav-section {
            margin-bottom: 20px;
        }

        .nav-section-title {
            padding: 8px 12px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.4);
            font-weight: 600;
        }

        .nav-item {
            list-style: none;
            margin-bottom: 3px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 10px 12px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.2s ease;
            font-size: 13px;
            font-weight: 500;
            gap: 10px;
        }

        .nav-link i {
            font-size: 18px;
            width: 22px;
            flex-shrink: 0;
        }

        .nav-link span {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .nav-link .badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 2px 6px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 600;
            flex-shrink: 0;
            margin-left: 5px;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
        }

        .nav-link.active {
            background: linear-gradient(135deg, #3498db, #2c3e50);
            color: #fff;
        }

        /* Sidebar Footer */
        .sidebar-footer {
            padding: 15px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            flex-shrink: 0;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 13px;
            font-weight: 500;
        }

        .logout-btn i {
            font-size: 18px;
            width: 22px;
            flex-shrink: 0;
        }

        .logout-btn span {
            flex: 1;
            text-align: left;
        }

        .logout-btn:hover {
            background: rgba(231, 76, 60, 0.2);
            color: #e74c3c;
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        /* Top Navbar */
        .top-navbar {
            background: #fff;
            padding: 12px 20px;
            box-shadow: 0 1px 10px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 1020;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        .menu-toggle {
            background: none;
            border: none;
            font-size: 22px;
            color: #2c3e50;
            cursor: pointer;
            display: none;
            transition: all 0.3s;
            padding: 5px;
        }

        .menu-toggle:hover {
            color: #3498db;
        }

        .page-title {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .notification-btn {
            position: relative;
            background: none;
            border: none;
            font-size: 20px;
            color: #7f8c8d;
            cursor: pointer;
            transition: color 0.3s;
            padding: 5px;
        }

        .notification-btn:hover {
            color: #3498db;
        }

        .notification-badge {
            position: absolute;
            top: -3px;
            right: -3px;
            background: #e74c3c;
            color: #fff;
            font-size: 9px;
            padding: 1px 5px;
            border-radius: 10px;
        }

        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 5px 8px;
            border-radius: 30px;
            transition: background 0.3s;
        }

        .user-dropdown:hover {
            background: #f0f2f5;
        }

        .user-avatar-small {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, #3498db, #2c3e50);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: #fff;
            flex-shrink: 0;
        }

        .user-info {
            text-align: right;
        }

        .user-name-small {
            font-weight: 600;
            font-size: 12px;
            color: #2c3e50;
        }

        .user-role-small {
            font-size: 10px;
            color: #7f8c8d;
        }

        /* Content Wrapper */
        .content-wrapper {
            padding: 20px;
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid #eef2f7;
            padding: 0.75rem 1.25rem;
            font-weight: 600;
            font-size: 14px;
        }

        /* Stats Cards untuk Mobile */
        .stat-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            transition: all 0.3s;
            margin-bottom: 15px;
        }

        .stat-card .stat-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 2rem;
            opacity: 0.15;
        }

        .stat-card .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0;
        }

        .stat-card .stat-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.9;
        }

        /* Gradient Backgrounds */
        .bg-primary-gradient {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
        }

        .bg-danger-gradient {
            background: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%);
        }

        .bg-warning-gradient {
            background: linear-gradient(135deg, #d35400 0%, #f39c12 100%);
        }

        .bg-success-gradient {
            background: linear-gradient(135deg, #1e8449 0%, #27ae60 100%);
        }

        .bg-secondary-gradient {
            background: linear-gradient(135deg, #7f8c8d 0%, #95a5a6 100%);
        }

        .bg-info-gradient {
            background: linear-gradient(135deg, #2471a3 0%, #3498db 100%);
        }

        /* Table Responsive */
        .table-responsive-custom {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table {
            margin-bottom: 0;
            font-size: 13px;
        }

        .table thead th {
            background: #f8f9fa;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        /* Form Styles */
        .form-label {
            font-weight: 500;
            font-size: 12px;
            margin-bottom: 5px;
            color: #2c3e50;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #dee2e6;
            padding: 8px 12px;
            font-size: 13px;
        }

        /* Button Styles */
        .btn {
            border-radius: 8px;
            padding: 6px 16px;
            font-weight: 500;
            font-size: 12px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3498db, #2c3e50);
            border: none;
        }

        /* Alert */
        .alert {
            border-radius: 10px;
            font-size: 13px;
            padding: 10px 15px;
        }

        /* ========== RESPONSIVE UNTUK HP ========== */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                width: 260px;
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

        @media (max-width: 768px) {

            /* Header mobile */
            .top-navbar {
                padding: 10px 15px;
            }

            .page-title {
                font-size: 16px;
            }

            /* Sembunyikan teks user di mobile jika perlu */
            .user-info {
                display: none;
            }

            /* Content padding lebih kecil */
            .content-wrapper {
                padding: 12px;
            }

            /* Card lebih compact */
            .card-header {
                padding: 0.6rem 1rem;
                font-size: 13px;
            }

            /* Grid untuk stat card */
            .row {
                margin-left: -6px;
                margin-right: -6px;
            }

            .row>[class*="col-"] {
                padding-left: 6px;
                padding-right: 6px;
            }

            /* Stat card untuk mobile */
            .stat-card .stat-value {
                font-size: 1.2rem;
            }

            .stat-card .stat-icon {
                font-size: 1.5rem;
                right: 10px;
            }
        }

        @media (max-width: 576px) {

            /* Mobile sangat kecil */
            .sidebar {
                width: 85%;
                max-width: 280px;
            }

            .top-navbar {
                flex-direction: row;
                flex-wrap: wrap;
            }

            .page-title {
                font-size: 14px;
                flex: 1;
            }

            .navbar-right {
                gap: 8px;
            }

            .notification-btn {
                font-size: 18px;
            }

            .user-avatar-small {
                width: 30px;
                height: 30px;
                font-size: 14px;
            }

            /* Stack columns di mobile */
            .mobile-stack {
                flex-direction: column;
            }

            /* Tombol full width di mobile */
            .btn-mobile-block {
                width: 100%;
                margin-bottom: 8px;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        /* Overlay untuk mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            display: none;
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* Utility */
        .cursor-pointer {
            cursor: pointer;
        }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>
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
            <div class="user-name"><?php echo e(Auth::user()->full_name ?? Auth::user()->name ?? 'User'); ?></div>
            <div class="user-role">
                <span class="badge" style="background: rgba(255,255,255,0.2);">
                    <?php echo e(Auth::user()->role == 'admin' ? 'Administrator' : (Auth::user()->role == 'staff' ? 'Staff' : 'User')); ?>

                </span>
            </div>
        </div>

        <!-- Navigation -->
        <div class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">MAIN NAVIGATION</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.dashboard')); ?>">
                            <i class="bi bi-speedometer2"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.tickets*') ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.tickets')); ?>">
                            <i class="bi bi-ticket-perforated"></i>
                            <span>Semua Tiket</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">MANAGEMENT</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.users*') ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.users')); ?>">
                            <i class="bi bi-people"></i>
                            <span>Manajemen User</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.categories*') ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.categories')); ?>">
                            <i class="bi bi-tags"></i>
                            <span>Kategori</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">REPORTS</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.reports') ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.reports')); ?>">
                            <i class="bi bi-graph-up"></i>
                            <span>Laporan & Statistik</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
            <a href="<?php echo e(route('admin.profile')); ?>" class="logout-btn" style="margin-bottom: 8px;">
                <i class="bi bi-person-circle"></i>
                <span>Profil Saya</span>
            </a>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="logout-btn" style="width: 100%; border: none; cursor: pointer;">
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
                <?php echo $__env->yieldContent('page-title', 'Dashboard'); ?>
            </div>
            <div class="navbar-right">
                <button class="notification-btn" id="notificationBtn">
                    <i class="bi bi-bell"></i>
                    <span class="notification-badge">3</span>
                </button>
                <div class="dropdown">
                    <div class="user-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-info">
                            <div class="user-name-small"><?php echo e(Auth::user()->full_name ?? Auth::user()->name ?? 'User'); ?></div>
                            <div class="user-role-small"><?php echo e(Auth::user()->role == 'admin' ? 'Administrator' : (Auth::user()->role == 'staff' ? 'Staff' : 'User')); ?></div>
                        </div>
                        <div class="user-avatar-small">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('admin.profile')); ?>">
                                <i class="bi bi-person"></i> Profil Saya
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
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
            <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show fade-in" role="alert">
                <i class="bi bi-check-circle-fill"></i> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show fade-in" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <?php if(session('warning')): ?>
            <div class="alert alert-warning alert-dismissible fade show fade-in" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> <?php echo e(session('warning')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <?php if(session('info')): ?>
            <div class="alert alert-info alert-dismissible fade show fade-in" role="alert">
                <i class="bi bi-info-circle-fill"></i> <?php echo e(session('info')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {
            // Auto hide alert after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 5000);

            // Mobile menu toggle
            $('#menuToggle').click(function() {
                $('#sidebar').toggleClass('show');
                $('#sidebarOverlay').toggleClass('show');
                $('body').css('overflow', $('#sidebar').hasClass('show') ? 'hidden' : '');
            });

            // Close sidebar when clicking overlay
            $('#sidebarOverlay').click(function() {
                $('#sidebar').removeClass('show');
                $('#sidebarOverlay').removeClass('show');
                $('body').css('overflow', '');
            });

            // Close sidebar on window resize (if screen becomes desktop)
            $(window).resize(function() {
                if ($(window).width() > 992) {
                    $('#sidebar').removeClass('show');
                    $('#sidebarOverlay').removeClass('show');
                    $('body').css('overflow', '');
                }
            });

            // Add active class to current nav item based on URL
            var currentUrl = window.location.href;
            $('.nav-link').each(function() {
                var linkUrl = $(this).attr('href');
                if (linkUrl && currentUrl.indexOf(linkUrl) !== -1) {
                    $(this).addClass('active');
                }
            });

            // Handle notification click (tanpa error)
            $('#notificationBtn').click(function() {
                console.log('Notification clicked');
                alert('Fitur notifikasi sedang dalam pengembangan');
            });

            // Prevent dropdown from closing when clicking inside
            $('.dropdown-menu').on('click', function(e) {
                e.stopPropagation();
            });
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH D:\it-helpdesk\resources\views/layouts/admin.blade.php ENDPATH**/ ?>