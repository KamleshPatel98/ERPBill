<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ getSetting('app_name') }} - @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        :root{
            --primary:#2e7d32;
            --primary-dark:#1b5e20;
            --secondary:#8bc34a;
            --bg:#f4f8f1;
            --card:#ffffff;
        }

        body{
            background:var(--bg);
            font-family:'Segoe UI',sans-serif;
            font-size:14px;
            color:#333;
        }

        /* HEADER */
        .top-header{
            background:linear-gradient(90deg,var(--primary-dark),var(--primary));
            padding:8px 18px;
        }

        .logo{
            color:#fff;
            font-size:20px;
            font-weight:700;
            text-decoration:none;
        }

        .profile-btn{
            background:rgba(255,255,255,.15);
            color:#fff;
            border:none;
            font-size:13px;
            padding:6px 12px;
        }

        /* MENU */
        .menu-bar{
            background:#fff;
            border-bottom:1px solid #d7e5d3;
            min-height:46px;
        }

        .menu-bar .nav-link{
            color:#374151;
            font-size:14px;
            font-weight:500;
            padding:10px 14px;
        }

        .menu-bar .nav-link:hover{
            color:var(--primary);
        }

        .dropdown-menu{
            border:none;
            border-radius:10px;
            box-shadow:0 4px 12px rgba(0,0,0,.08);
        }

        /* CARDS */
        .page-card,
        .table-card{
            background:var(--card);
            border:none;
            border-radius:10px;
            box-shadow:0 2px 6px rgba(0,0,0,.06);
        }

        .page-card .card-body{
            padding:15px;
        }

        /* PAGE TITLE */
        .page-title{
            color:var(--primary-dark);
            font-weight:700;
            margin-bottom:2px;
        }

        .page-subtitle{
            color:#6b7280;
            font-size:13px;
            margin:0;
        }

        /* FORM */
        .form-control,
        .form-select{
            height:36px;
            font-size:13px;
            border-radius:8px;
            border:1px solid #d6e4d4;
        }

        .form-control:focus,
        .form-select:focus{
            box-shadow:none;
            border-color:var(--primary);
        }

        .btn{
            font-size:13px;
        }

        .btn-primary{
            background:var(--primary);
            border-color:var(--primary);
        }

        .btn-primary:hover{
            background:var(--primary-dark);
            border-color:var(--primary-dark);
        }

        /* TABLE */
        .table{
            font-size:13px;
            margin-bottom:0;
        }

        .table thead th{
            background:#edf7ed;
            color:var(--primary-dark);
            padding:10px 12px;
            font-weight:600;
            border-bottom:1px solid #d8e7d6;
        }

        .table td{
            padding:10px 12px;
            vertical-align:middle;
        }

        .table-hover tbody tr:hover{
            background:#f7fbf6;
        }

        /* PRODUCT ICON */
        .member-avatar{
            width:34px;
            height:34px;
            background:#e8f5e9;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            color:var(--primary);
            font-size:13px;
        }

        /* STATUS */
        .badge-active{
            background:#dcedc8;
            color:#33691e;
            padding:4px 10px;
            border-radius:15px;
            font-size:12px;
            font-weight:600;
        }

        /* ACTION BUTTONS */
        .action-btn{
            width:30px;
            height:30px;
            padding:0;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            font-size:12px;
        }

        /* MOBILE FIX (IMPORTANT) */
        @media(max-width:768px){

            .top-header{
                padding:10px;
            }

            .logo{
                font-size:18px;
            }

            .table{
                font-size:12px;
            }

            .page-card .row > div{
                margin-bottom:10px;
            }

            /* FIX NAVBAR COLLAPSE UI */
            .navbar-collapse{
                background:#fff;
                margin-top:10px;
                padding:10px;
                border-radius:10px;
                box-shadow:0 3px 10px rgba(0,0,0,.08);
            }

            .menu-bar .nav-link{
                padding:12px;
            }

            .dropdown-menu{
                border:none;
                box-shadow:none;
                padding-left:10px;
            }
        }
    </style>

    @stack('style')

    <script src="{{ asset('assets/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/sweet-alert-2.min.js') }}"></script>
</head>

<body>
    <x-alert />

    <!-- TOP HEADER -->
    <div class="top-header">

        <div class="container-fluid">

            <div class="row align-items-center">

                <div class="col-md-9">

                    <a href="#" class="logo">
                        <i class="fa-solid fa-seedling me-2"></i>
                        {{ getSetting('app_name') }}
                    </a>

                </div>

                {{--<div class="col-md-5">

                    <div class="input-group">

                        <input type="text"
                            class="form-control"
                            placeholder="Search Product, Company, Customer...">

                        <button class="btn btn-primary">
                            <i class="fa fa-search"></i>
                        </button>

                    </div> 

                </div>--}}

                <div class="col-md-3 text-center">

                    <span class="text-white me-3 small">
                        <i class="fa-solid fa-calendar-days me-1"></i>
                        {{ date('d M Y'); }}
                    </span>

                    <div class="dropdown d-inline">

                        <button class="btn profile-btn dropdown-toggle"
                                data-bs-toggle="dropdown">

                            <i class="fa-solid fa-user me-1"></i>
                            Admin

                        </button>

                        <ul class="dropdown-menu dropdown-menu-start">

                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fa fa-user me-2"></i>
                                    Profile
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fa fa-key me-2"></i>
                                    Change Password
                                </a>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('auth.logout') }}">
                                    <i class="fa fa-right-from-bracket me-2"></i>
                                    Logout
                                </a>
                            </li>

                        </ul>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- MENU BAR -->
    <nav class="navbar navbar-expand-lg menu-bar">

        <div class="container-fluid">

            <!-- MOBILE TOGGLER -->
            <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#menu"
                    aria-controls="menu"
                    aria-expanded="false"
                    aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>

            <!-- MENU ITEMS -->
            <div class="collapse navbar-collapse" id="menu">

                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('auth.dashboard') }}">
                            <i class="fa fa-gauge me-1"></i> Dashboard
                        </a>
                    </li>

                    <!-- MASTER -->
                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">

                            <i class="fa fa-database me-1"></i> Master

                        </a>

                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('financial-years.index') }}">Financial Year</a></li>
                            <li><a class="dropdown-item" href="{{ route('categories.index') }}">Category</a></li>
                            <li><a class="dropdown-item" href="{{ route('units.index') }}">Unit</a></li>
                            <li><a class="dropdown-item" href="{{ route('gsts.index') }}">GST</a></li>
                            <li><a class="dropdown-item" href="{{ route('states.index') }}">State</a></li>
                            <li><a class="dropdown-item" href="{{ route('suppliers.index') }}">Supplier</a></li>
                            <li><a class="dropdown-item" href="{{ route('customers.index') }}">Customer</a></li>

                        </ul>

                    </li>

                    <!-- PRODUCTS -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-seedling me-1"></i> Products
                        </a>
                    </li>

                    <!-- PURCHASE -->
                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown">

                            <i class="fa fa-cart-plus me-1"></i> Purchase

                        </a>

                        <ul class="dropdown-menu">

                            <li><a class="dropdown-item" href="#">Purchase Entry</a></li>
                            <li><a class="dropdown-item" href="#">Purchase Return</a></li>

                        </ul>

                    </li>

                    <!-- SALES -->
                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown">

                            <i class="fa fa-cash-register me-1"></i> Sales

                        </a>

                        <ul class="dropdown-menu">

                            <li><a class="dropdown-item" href="#">Sale Entry</a></li>
                            <li><a class="dropdown-item" href="#">Sale Return</a></li>
                            <li><a class="dropdown-item" href="#">Customer Ledger</a></li>

                        </ul>

                    </li>

                    <!-- STOCK -->
                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown">

                            <i class="fa fa-boxes-stacked me-1"></i> Stock

                        </a>

                        <ul class="dropdown-menu">

                            <li><a class="dropdown-item" href="#">Current Stock</a></li>
                            <li><a class="dropdown-item" href="#">Low Stock</a></li>
                            <li><a class="dropdown-item" href="#">Expiry Stock</a></li>

                        </ul>

                    </li>

                    <!-- REPORTS -->
                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown">

                            <i class="fa fa-chart-column me-1"></i> Reports

                        </a>

                        <ul class="dropdown-menu">

                            <li><a class="dropdown-item" href="#">Sale Report</a></li>
                            <li><a class="dropdown-item" href="#">Purchase Report</a></li>
                            <li><a class="dropdown-item" href="#">Stock Report</a></li>

                        </ul>

                    </li>

                </ul>

            </div>

        </div>

    </nav>

    <!-- CONTENT -->
    <div class="container-fluid p-3">

        @yield('content')

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('script')
</body>
</html>