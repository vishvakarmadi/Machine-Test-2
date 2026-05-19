<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - LuxeEstates</title>
    
    <!-- Google Fonts: Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #0f172a;
            --accent-color: #3b82f6;
            --bg-color: #f8fafc;
        }
        
        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-color);
            color: #334155;
            overflow-x: hidden;
        }

        #wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }

        #sidebar {
            min-width: 250px;
            max-width: 250px;
            background: var(--primary-color);
            color: #fff;
            transition: all 0.3s;
            min-height: 100vh;
        }

        #sidebar .sidebar-header {
            padding: 20px;
            background: #0b1120;
        }

        #sidebar ul.components {
            padding: 20px 0;
            border-bottom: 1px solid #1e293b;
        }

        #sidebar ul li a {
            padding: 15px 20px;
            font-size: 1.1em;
            display: block;
            color: #cbd5e1;
            text-decoration: none;
            transition: 0.3s;
        }

        #sidebar ul li a:hover, #sidebar ul li.active > a {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
            border-left: 4px solid var(--accent-color);
        }

        #content {
            width: 100%;
            padding: 20px;
            min-height: 100vh;
            transition: all 0.3s;
        }

        .glass-card {
            background: #fff;
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .navbar-top {
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            border-radius: 12px;
            margin-bottom: 20px;
        }
        
        /* Modal customizations */
        .modal-content {
            border-radius: 16px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .modal-header {
            border-bottom: 1px solid #f1f5f9;
            background-color: #f8fafc;
            border-radius: 16px 16px 0 0;
        }
        
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -250px;
            }
            #sidebar.active {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <div id="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3 class="mb-0 fw-bold"><i class="fa-solid fa-building-user me-2" style="color: #3b82f6;"></i>LuxeAdmin</h3>
            </div>

            <ul class="list-unstyled components">
                <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-chart-line me-3"></i>Dashboard</a>
                </li>
                <li class="{{ request()->routeIs('admin.properties.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.properties.index') }}"><i class="fa-solid fa-building me-3"></i>Properties</a>
                </li>
                <li class="{{ request()->routeIs('admin.enquiries.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.enquiries.index') }}"><i class="fa-solid fa-envelope me-3"></i>Enquiries</a>
                </li>
            </ul>

            <ul class="list-unstyled">
                <li>
                    <a href="{{ url('/') }}" target="_blank"><i class="fa-solid fa-globe me-3"></i>View Website</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light navbar-top p-3">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-primary d-md-none">
                        <i class="fas fa-align-left"></i>
                    </button>
                    
                    <div class="ms-auto d-flex align-items-center">
                        <span class="me-3 fw-medium text-muted">Hello, {{ Auth::guard('admin')->user()->name }}</span>
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-sign-out-alt me-2"></i>Logout</button>
                        </form>
                    </div>
                </div>
            </nav>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <script>
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
