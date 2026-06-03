<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Krishi Dawai ERP - Login</title>

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

</head>

<body>

    <div class="login-card">

        <!-- LOGO -->
        <div class="logo">
            <i class="fa-solid fa-seedling"></i>
            Krishi Dawai ERP
        </div>

        <p class="text-center small-text mb-3">
            Sign in to manage inventory, stock & sales
        </p>

        <!-- LOGIN FORM -->
        <form>

            <div class="mb-3">

                <label class="form-label">Username</label>

                <div class="input-group">

                    <span class="input-group-text">
                        <i class="fa fa-user"></i>
                    </span>

                    <input type="text" class="form-control" placeholder="Enter username">

                </div>

            </div>

            <div class="mb-3">

                <label class="form-label">Password</label>

                <div class="input-group">

                    <span class="input-group-text">
                        <i class="fa fa-lock"></i>
                    </span>

                    <input type="password" class="form-control" placeholder="Enter password">

                </div>

            </div>

            <div class="d-flex justify-content-between mb-3 small-text">

                <label>
                    <input type="checkbox"> Remember me
                </label>

                <a href="#" style="color:var(--primary); text-decoration:none;">
                    Forgot password?
                </a>

            </div>

            <button type="submit" class="btn btn-primary w-100">
                Login
            </button>

        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>