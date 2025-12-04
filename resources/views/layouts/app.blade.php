<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Product Management</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f8;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background-color: #007bff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            z-index: 1000;
        }

        .logo-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-title img {
            height: 40px;
            width: 40px;
            border-radius: 50%;
        }

        .logo-title h1 {
            font-size: 20px;
            margin: 0;
        }

        .search-bar {
            display: flex;
            gap: 5px;
        }

        .search-bar input {
            padding: 6px;
            border-radius: 4px;
            border: none;
            width: 200px;
        }

        .search-bar button {
            padding: 6px 12px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-info img {
            height: 35px;
            width: 35px;
            border-radius: 50%;
            border: 2px solid white;
        }

        .user-info span {
            font-weight: bold;
        }

        .layout {
            display: flex;
            flex: 1;
            margin-top: 60px;
        }

        .sidebar-left {
            width: 220px;
            background-color: #343a40;
            color: white;
            height: calc(100vh - 60px);
            position: fixed;
            top: 60px;
            left: 0;
            padding: 20px;
        }

        .sidebar-left h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar-left ul {
            list-style: none;
            padding: 0;
        }

        .sidebar-left ul li {
            margin: 15px 0;
        }

        .sidebar-left ul li a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 8px;
            border-radius: 4px;
        }

        .sidebar-left ul li a:hover {
            background-color: #495057;
        }

        .main-content {
            margin-left: 240px;
            padding: 30px;
            flex: 1;
        }

        .container {
            background: white;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            margin-top: auto;
        }

        footer a {
            color: #ffc107;
            text-decoration: none;
            margin: 0 10px;
        }

        footer a:hover {
            text-decoration: underline;
        }
        .input_style {
  height: 45px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

    </style>
</head>
<body>
    <header>
    <div class="logo-title">
<img src="https://cdn-icons-png.flaticon.com/512/5968/5968705.png" alt="Logo">
        <h1>Product Management</h1>
    </div>

    <div class="user-info">
        <img src="https://cdn-icons-png.flaticon.com/512/9131/9131529.png" alt="User">
        <span>{{ Auth::user()->name ?? 'Guest' }}</span>
    </div>
</header>

    <div class="layout">
        <div class="sidebar-left">
            <h3>Dashboard</h3>
            <ul>
                <li><a href="/products">Products</a></li>
                <li><a href="/categories">Categories</a></li>
                {{-- <li><a href="#">Reports</a></li>
                <li><a href="#">Settings</a></li> --}}
            </ul>
        </div>

        <div class="main-content">
            @yield('content')
        </div>
    </div>

    <footer>
        &copy; {{ date('Y') }} Product Management System. All rights reserved.
        <br>
        <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a>
    </footer>
</body>
</html>
