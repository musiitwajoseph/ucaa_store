<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCAA STORE</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Favicon (replace 'cent.png' with your actual path or remove) -->
    <link rel="icon" type="image/png" href="down.png">

    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            padding-top: 70px; /* Space for topbar */
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: #e9ecef;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            overflow-y: auto;
            z-index: 1000;
        }
        .sidebar .nav-link {
            color: #adb5bd;
            padding: 12px 20px;
            margin: 4px 0;
            border-radius: 0.375rem;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #495057;
            color: #fff;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        .topbar {
            background-color: #f8f9fa;
            padding: 15px 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-left: 250px;
            position: fixed;
            top: 0;
            right: 0;
            left: 250px;
            z-index: 1030;
            border-bottom: 2px solid #e9ecef;
            border-radius: 0 0 8px 8px;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
        }
        .sidebar .card-header {
            background-color: #0d6efd;
            color: white;
            border-radius: 8px 8px 0 0 !important;
            padding: 12px 20px;
        }
        .sidebar .card-header img {
            height: 40px;
            margin-right: 10px;
            vertical-align: middle;
        }
    </style>
</head>
<body>

<nav class="topbar bg-white py-3 px-4 shadow-sm" style="border-bottom: 1px solid #eaeaea;">
  <div class="d-flex justify-content-between align-items-center">
    <h5 class="mb-0 fw-bold text-primary">
      <i class="fas fa-tachometer-alt me-2"></i> Dashboard
    </h5>
    <div class="text-end">
      <span class="text-muted">Welcome,</span>
      <strong class="text-dark">Mutumba</strong><br>
      <small class="text-secondary">Main Branch • IT Department</small>
    </div>
  </div>
</nav>

<!-- Sidebar -->
<div class="sidebar">
    <div class="card-header">
        <!-- <img src="down.png" alt="down Logo" height="100px" class="me-2"> -->
         <img src="down.png" alt="Down Logo" class="me-2" style="height: 60px; width: auto;">
        <strong>UCAA STORE</strong>
    </div>

    <ul class="nav flex-column mt-3">
        <!-- Home -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-home"></i> Home
            </a>
        </li>

        <!-- Users (Admin only - shown by default in this static version) -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                <i class="fas fa-users"></i> Users
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Add User</a></li>
                <li><a class="dropdown-item" href="#">View Users</a></li>
            </ul>
        </li>

        <!-- User Role -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-diagram-project"></i> User Role
            </a>
        </li>

        <!-- Main Approvers -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-lock"></i> Main Approvers
            </a>
        </li>

        <!-- Branches -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                <i class="fas fa-building"></i> Branches
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Add Branch</a></li>
                <li><a class="dropdown-item" href="#">View Branches</a></li>
            </ul>
        </li>

        <!-- Division -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                <i class="fas fa-sitemap"></i> Division
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Add Division</a></li>
                <li><a class="dropdown-item" href="#">View Divisions</a></li>
            </ul>
        </li>

        <!-- Report (for approvers) -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-file-alt"></i> Report
            </a>
        </li>

        <!-- Request Asset (for requesters) -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-plus-circle"></i> Request Asset
            </a>
        </li>

        <!-- Pending & Rejected (for approvers) -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-hourglass-half"></i> Pending Asset
             
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-times-circle"></i> Rejected Assets
                
            </a>
        </li>

        <!-- Account Settings -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-cog"></i> Account Settings
            </a>
        </li>

        <!-- Logout -->
        <li class="nav-item mt-auto">
            <a class="nav-link text-danger" href="#" onclick="logout()">
                <i class="fas fa-sign-out-alt"></i> Log out
            </a>
        </li>
    </ul>
</div>

<!-- Main Content Area -->
<div class="main-content">

        @yield('content')
   
</div>

<!-- Session Timeout & Logout Script -->
<script>
function logout() {
    if (confirm('Are you sure you want to log out?')) {
        // In a real app, redirect to logout URL
        alert('Logout functionality would redirect to /logout in a real app.');
        // window.location.href = '/logout';
    }
}

</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>