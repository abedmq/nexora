<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نكسورا - تسجيل الدخول</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/dark-mode.css') }}">
    <script src="{{ asset('admin-assets/js/dark-mode.js') }}"></script>
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-logo">
            @if(setting('company_logo'))
                <img src="{{ asset(setting('company_logo')) }}" alt="{{ setting('company_name', 'نكسورا') }}" style="height:64px;width:auto;object-fit:contain;margin-bottom:16px;">
            @else
                <div class="logo-icon">
                    <i class="fas fa-bolt"></i>
                </div>
            @endif
            <h2>{{ setting('company_name', 'نكسورا') }}</h2>
            <p>تسجيل الدخول إلى لوحة التحكم</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger" style="border-radius: var(--nx-radius-sm); font-size: 13px; border: none; background: var(--nx-danger-light); color: var(--nx-danger);">
                <i class="fas fa-exclamation-circle me-1"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}" class="nx-form">
            @csrf
            <div class="mb-3">
                <label class="form-label">البريد الإلكتروني</label>
                <div class="position-relative">
                    <input type="email" name="email" class="form-control" placeholder="admin@nexora.com"
                           value="{{ old('email') }}" required autofocus
                           style="padding-right: 40px;">
                    <i class="fas fa-envelope" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);color:var(--nx-text-muted);"></i>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">كلمة المرور</label>
                <div class="position-relative">
                    <input type="password" name="password" class="form-control" placeholder="••••••••"
                           required style="padding-right: 40px;">
                    <i class="fas fa-lock" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);color:var(--nx-text-muted);"></i>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember" style="font-size:13px;">تذكرني</label>
                </div>
            </div>
            <button type="submit" class="btn btn-nx-primary w-100 py-2" style="font-size:15px;">
                <i class="fas fa-sign-in-alt me-1"></i> تسجيل الدخول
            </button>
        </form>

        <div class="text-center mt-4">
            <small class="text-muted">
                بيانات الدخول التجريبية: admin@nexora.com / password
            </small>
        </div>
    </div>
</div>

</body>
</html>
