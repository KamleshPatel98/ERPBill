<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ getSetting('app_name') }} - @yield('title')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>

        :root{
            --primary:#2e7d32;
            --primary-dark:#1b5e20;
            --bg:#f4f8f1;
        }

        body{
            background: linear-gradient(135deg, #e8f5e9, var(--bg));
            height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            font-family:'Segoe UI',sans-serif;
        }

        .login-card{
            width:100%;
            max-width:380px;
            background:#fff;
            border-radius:14px;
            box-shadow:0 5px 20px rgba(0,0,0,.1);
            padding:25px;
        }

        .logo{
            text-align:center;
            font-size:22px;
            font-weight:700;
            color:var(--primary);
            margin-bottom:15px;
        }

        .logo i{
            margin-right:8px;
        }

        .form-control{
            height:42px;
            font-size:14px;
            border-radius:8px;
        }

        .btn-primary{
            background:var(--primary);
            border:none;
            height:42px;
            font-size:14px;
        }

        .btn-primary:hover{
            background:var(--primary-dark);
        }

        .small-text{
            font-size:12px;
            color:#6b7280;
        }

        .input-group-text{
            background:#e8f5e9;
            border:none;
        }

    </style>

    <script src="{{ asset('assets/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/sweet-alert-2.min.js') }}"></script>
</head>

<body>
    <x-alert />

    <div class="login-card">

        <!-- LOGO -->
        <div class="logo">
            <i class="fa-solid fa-seedling"></i>
            {{ getSetting('app_name') }}
        </div>

        @yield('content')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>