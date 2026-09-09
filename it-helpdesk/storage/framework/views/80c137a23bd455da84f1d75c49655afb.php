
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Login - IT Helpdesk Hotel Loccal Collection Labuan Bajo</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', 'Poppins', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow-x: hidden;
        }
        
        /* Background Animation */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }
        
        .bg-animation .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 20s infinite ease-in-out;
        }
        
        .circle-1 {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }
        
        .circle-2 {
            width: 500px;
            height: 500px;
            bottom: -200px;
            right: -200px;
            animation-delay: 5s;
        }
        
        .circle-3 {
            width: 200px;
            height: 200px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: 10s;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }
        
        /* Main Container */
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
            padding: 20px;
        }
        
        /* Login Card */
        .login-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            width: 100%;
            max-width: 950px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.3);
        }
        
        /* Left Panel - Branding */
        .brand-panel {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            padding: 40px;
            height: 100%;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .brand-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1%, transparent 1%);
            background-size: 50px 50px;
            animation: moveBackground 20s linear infinite;
        }
        
        @keyframes moveBackground {
            0% {
                transform: translate(0, 0);
            }
            100% {
                transform: translate(50px, 50px);
            }
        }
        
        .logo {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
        }
        
        .logo-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 40px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }
        
        .logo h2 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .logo p {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .hotel-info {
            position: relative;
            z-index: 1;
            margin-top: 40px;
        }
        
        .hotel-info h3 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            font-size: 14px;
        }
        
        .info-item i {
            width: 30px;
            font-size: 18px;
            margin-right: 10px;
        }
        
        .feature-list {
            list-style: none;
            margin-top: 30px;
        }
        
        .feature-list li {
            margin-bottom: 12px;
            display: flex;
            align-items: center;
        }
        
        .feature-list li i {
            margin-right: 10px;
            font-size: 16px;
        }
        
        /* Right Panel - Form */
        .form-panel {
            padding: 50px 40px;
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 35px;
        }
        
        .form-header h3 {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .form-header p {
            color: #7f8c8d;
            font-size: 14px;
        }
        
        /* Form Group - Ukuran Sama Rata */
        .form-group {
            margin-bottom: 25px;
        }
        
        .input-group-custom {
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .input-group-custom i {
            position: absolute;
            left: 15px;
            color: #95a5a6;
            font-size: 18px;
            z-index: 10;
        }
        
        .form-control-custom {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s;
            background: #f8fafc;
        }
        
        .form-control-custom:focus {
            outline: none;
            border-color: #3498db;
            background: white;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }
        
        .form-control-custom.error {
            border-color: #e74c3c;
        }
        
        /* Placeholder Style */
        .form-control-custom::placeholder {
            color: #95a5a6;
            font-size: 14px;
        }
        
        .toggle-password {
            position: absolute;
            right: 15px;
            cursor: pointer;
            color: #95a5a6;
            transition: color 0.3s;
            z-index: 10;
            background: transparent;
            border: none;
        }
        
        .toggle-password:hover {
            color: #3498db;
        }
        
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .checkbox-label {
            display: flex;
            align-items: center;
            cursor: pointer;
            font-size: 14px;
            color: #4a5568;
        }
        
        .checkbox-label input {
            margin-right: 8px;
            cursor: pointer;
        }
        
        .forgot-link {
            font-size: 14px;
            color: #3498db;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .forgot-link:hover {
            color: #2c3e50;
            text-decoration: underline;
        }
        
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(52, 152, 219, 0.3);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .btn-login i {
            margin-right: 8px;
        }
        
        .divider {
            text-align: center;
            margin: 25px 0;
            position: relative;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: calc(50% - 60px);
            height: 1px;
            background: #e2e8f0;
        }
        
        .divider::before {
            left: 0;
        }
        
        .divider::after {
            right: 0;
        }
        
        .divider span {
            background: white;
            padding: 0 15px;
            color: #95a5a6;
            font-size: 13px;
        }
        
        .demo-credentials {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 15px;
            margin-top: 20px;
        }
        
        .demo-credentials h6 {
            font-size: 13px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .demo-credentials p {
            font-size: 12px;
            margin-bottom: 5px;
            font-family: monospace;
        }
        
        .demo-credentials i {
            color: #3498db;
            margin-right: 5px;
        }
        
        /* Alert Messages */
        .alert-custom {
            padding: 12px 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .alert-custom i {
            font-size: 18px;
            margin-right: 10px;
        }
        
        .alert-custom-danger {
            background: #fee2e2;
            border-left: 4px solid #e74c3c;
            color: #c0392b;
        }
        
        .alert-custom-success {
            background: #e3fcef;
            border-left: 4px solid #27ae60;
            color: #229954;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .brand-panel {
                display: none;
            }
            
            .form-panel {
                padding: 40px 30px;
            }
            
            .login-card {
                max-width: 450px;
            }
        }
        
        @media (max-width: 480px) {
            .form-panel {
                padding: 30px 20px;
            }
            
            .form-header h3 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="bg-animation">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
        <div class="circle circle-3"></div>
    </div>
    
    <div class="login-container">
        <div class="login-card">
            <div class="row g-0">
                <!-- Left Panel - Branding -->
                <div class="col-lg-6">
                    <div class="brand-panel">
                        <div class="logo">
                            <div class="logo-icon">
                                <i class="bi bi-headset"></i>
                            </div>
                            <h2>IT Helpdesk System</h2>
                            <p>Professional IT Support Management</p>
                        </div>
                        
                        <div class="hotel-info">
                            <h3>
                                <i class="bi bi-building"></i> Hotel Loccal Collection
                            </h3>
                            <div class="info-item">
                                <i class="bi bi-geo-alt"></i>
                                <span>Jl. Raya Binongko, Labuan Bajo, NTT</span>
                            </div>
                            <div class="info-item">
                                <i class="bi bi-telephone"></i>
                                <span>+62 123 4567 890</span>
                            </div>
                            <div class="info-item">
                                <i class="bi bi-envelope"></i>
                                <span>itsupport@hotelloccal.com</span>
                            </div>
                        </div>
                        
                        <ul class="feature-list">
                            <li><i class="bi bi-check-circle-fill"></i> Laporan Masalah Terstruktur</li>
                            <li><i class="bi bi-check-circle-fill"></i> Tracking Status Real-time</li>
                            <li><i class="bi bi-check-circle-fill"></i> Riwayat Penanganan Lengkap</li>
                            <li><i class="bi bi-check-circle-fill"></i> Prioritas Penanganan</li>
                        </ul>
                    </div>
                </div>
                
                <!-- Right Panel - Form -->
                <div class="col-lg-6">
                    <div class="form-panel">
                        <div class="form-header">
                            <h3>Selamat Datang</h3>
                            <p>Silakan login untuk melanjutkan</p>
                        </div>
                        
                        <!-- Alert Messages -->
                        <?php if(session('success')): ?>
                            <div class="alert-custom alert-custom-success">
                                <i class="bi bi-check-circle-fill"></i>
                                <span><?php echo e(session('success')); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if($errors->any()): ?>
                            <div class="alert-custom alert-custom-danger">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <span><?php echo e($errors->first()); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Login Form -->
                        <form method="POST" action="<?php echo e(route('login.post')); ?>">
                            <?php echo csrf_field(); ?>
                            
                            <!-- Field Email -->
                            <div class="form-group">
                                <div class="input-group-custom">
                                    <i class="bi bi-envelope"></i>
                                    <input type="email" 
                                           name="email" 
                                           id="email" 
                                           class="form-control-custom <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           placeholder="Alamat Email"
                                           value="<?php echo e(old('email')); ?>" 
                                           required 
                                           autofocus>
                                </div>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger mt-1 d-block"><?php echo e($message); ?></small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            
                            <!-- Field Password -->
                            <div class="form-group">
                                <div class="input-group-custom">
                                    <i class="bi bi-lock"></i>
                                    <input type="password" 
                                           name="password" 
                                           id="password" 
                                           class="form-control-custom <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           placeholder="Password"
                                           required>
                                    <button type="button" class="toggle-password" id="togglePassword">
                                        
                                    </button>
                                </div>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger mt-1 d-block"><?php echo e($message); ?></small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            
                            <div class="form-options">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                                    <span>Ingat saya</span>
                                </label>
                                <a href="#" class="forgot-link" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">
                                    Lupa Password?
                                </a>
                            </div>
                            
                            <button type="submit" class="btn-login">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </button>
                        </form>
                        
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="bi bi-shield-check"></i> Sistem Manajemen Layanan IT
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Forgot Password Modal -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-question-circle"></i> Lupa Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Silakan hubungi tim IT Support untuk reset password Anda:</p>
                    <div class="alert alert-info">
                        <i class="bi bi-envelope"></i> <strong>Email:</strong> itsupport@hotelloccal.com<br>
                        <i class="bi bi-telephone"></i> <strong>Telepon:</strong> Ext. 1234
                    </div>
                    <p class="small text-muted">Atau hubungi langsung departemen IT di lantai 2.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Toggle Password Visibility
            $('#togglePassword').click(function() {
                const passwordInput = $('#password');
                const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
                passwordInput.attr('type', type);
                $(this).find('i').toggleClass('bi-eye bi-eye-slash');
            });
            
            // Auto focus on email field
            $('#email').focus();
            
            // Enter key submit
            $('#password').on('keypress', function(e) {
                if (e.which === 13) {
                    $('form').submit();
                }
            });
        });
    </script>
</body>
</html><?php /**PATH D:\it-helpdesk\it-helpdesk\resources\views/auth/login.blade.php ENDPATH**/ ?>