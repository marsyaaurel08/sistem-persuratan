<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Persuratan || Login</title>

    <link rel="shortcut icon" type="image/x-icon" href="https://eproc.jasatirta1.co.id/assets/images/logo-jasatirta-crop.png">
    <link rel="stylesheet" type="text/css" href="{{ asset('duralux/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('duralux/assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('duralux/assets/css/theme.min.css') }}">
</head>

<body>
    <main class="auth-creative-wrapper">
        <div class="auth-creative-inner">
            <div class="creative-card-wrapper">
                <div class="card my-4 overflow-hidden" style="z-index: 1">
                    <div class="row flex-1 g-0">
                        <div class="col-lg-6 h-100 my-auto order-1 order-lg-0">
                            <div class="bg-white shadow-lg position-absolute translate-middle top-50 start-50 d-none d-lg-flex align-items-center justify-content-center rounded-circle"
                                style="width: 80px; height: 80px; z-index: 10; padding: 10px;">
                                <img src="https://eproc.jasatirta1.co.id/assets/images/logo-jasatirta-crop.png" alt=""
                                    class="img-fluid">
                            </div>
                            <div class="creative-card-body card-body p-sm-5">
                                <h2 class="fs-20 fw-bolder mb-4">Masuk ke akun Anda</h2>
                                <p class="fs-12 fw-medium text-muted">Silakan masukkan akun Anda untuk mengakses sistem.</p>

                                <form action="{{ route('login.process') }}" method="POST" class="w-100 mt-4 pt-2">
                                    @csrf
                                    <div class="mb-4">
                                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                                    </div>
                                    <div class="mt-5">
                                        <button type="submit" class="btn btn-lg btn-primary w-100">Login</button>
                                    </div>
                                </form>

                                <div class="mt-5 text-muted">
                                    <span> Butuh bantuan teknis?</span>
                                    <a href="#" class="fw-bold">Klik disini</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 bg-primary order-0 order-lg-1">
                            <div class="h-100 d-flex align-items-center justify-content-center">
                                <img src="https://i.pinimg.com/736x/d0/e3/45/d0e345fee5e315782ba616f8aca45d2c.jpg"
                                    alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- ✅ Toast container --}}
    <div id="toastNotif" class="toast-notif">
        <span class="toast-icon"></span>
        <span class="toast-message"></span>
        <button class="toast-close">&times;</button>
    </div>

    {{-- ✅ Scripts --}}
    <script src="{{ asset('duralux/assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('duralux/assets/js/common-init.min.js') }}"></script>
    <script src="{{ asset('duralux/assets/js/theme-customizer-init.min.js') }}"></script>

    {{-- ✅ Toast Styles & Script --}}
    <style>
        .toast-notif {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 300px;
            max-width: 360px;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 0.95rem;
            background: #fff;
            color: #333;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-left: 6px solid;
            opacity: 0;
            transform: translateX(50px);
            transition: all 0.4s ease;
            z-index: 9999;
        }

        .toast-notif.show {
            opacity: 1;
            transform: translateX(0);
        }

        .toast-success {
            border-color: #28a745;
            background-color: #e8f5e9;
        }

        .toast-error {
            border-color: #dc3545;
            background-color: #fdecea;
        }

        .toast-icon {
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .toast-close {
            margin-left: auto;
            background: transparent;
            border: none;
            color: #666;
            font-size: 1.1rem;
            cursor: pointer;
            transition: color 0.2s;
        }

        .toast-close:hover {
            color: #000;
        }
    </style>

    <script>
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toastNotif');
            const icon = toast.querySelector('.toast-icon');
            const msg = toast.querySelector('.toast-message');
            const closeBtn = toast.querySelector('.toast-close');

            toast.className = `toast-notif toast-${type}`;
            msg.textContent = message;

            switch (type) {
                case 'success':
                    icon.innerHTML = '<i class="feather-check-circle text-success"></i>';
                    break;
                case 'error':
                    icon.innerHTML = '<i class="feather-x-circle text-danger"></i>';
                    break;
            }

            toast.classList.add('show');
            closeBtn.onclick = hideToast;
            setTimeout(() => hideToast(), 3000);
        }

        function hideToast() {
            document.getElementById('toastNotif').classList.remove('show');
        }

        // === Tampilkan toast berdasarkan session Laravel ===
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                showToast(@json(session('success')), 'success');
            @endif
            @if($errors->any())
                showToast(@json($errors->first()), 'error');
            @endif
        });
    </script>
</body>
</html>