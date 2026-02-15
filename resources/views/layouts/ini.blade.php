<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rental Motor')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #edf2f7 0%, #e2e8f0 100%);
            overflow-x: hidden;
        }

        .main-wrapper {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* Subtle Background Pattern */
        .bg-pattern {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.03;
            z-index: 0;
            pointer-events: none;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(30, 41, 59, 0.28) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(51, 65, 85, 0.24) 0%, transparent 50%);
        }

        /* Sidebar - FIXED */
        .sidebar {
            width: 280px;
            min-height: 100vh;
            background: #ffffff;
            box-shadow: 2px 0 20px rgba(0, 0, 0, 0.03);
            padding: 30px 20px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(30, 41, 59, 0.3);
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(30, 41, 59, 0.5);
        }

        .sidebar-header {
            padding-bottom: 25px;
            border-bottom: 1px solid #e8ecf1;
            margin-bottom: 25px;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #1e293b;
            text-decoration: none;
        }

        .sidebar-logo-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #1f2937 0%, #334155 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.3rem;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.25);
        }

        .sidebar-logo h4 {
            margin: 0;
            font-weight: 700;
            font-size: 1.4rem;
            color: #1e293b;
        }

        .user-badge {
            background: linear-gradient(135deg, #eef2f7 0%, #e2e8f0 100%);
            padding: 14px 18px;
            border-radius: 14px;
            margin-bottom: 25px;
            border: 1px solid #cbd5e1;
        }

        .user-badge p {
            margin: 0;
            color: #64748b;
            font-size: 0.8rem;
            margin-bottom: 4px;
            font-weight: 500;
        }

        .user-badge strong {
            color: #1f2937;
            font-weight: 600;
            text-transform: capitalize;
            font-size: 1rem;
        }

        .nav-section-title {
            color: #94a3b8;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin: 25px 0 12px 12px;
            font-weight: 700;
        }

        .sidebar .nav-link {
            color: #64748b;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 6px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            font-size: 0.95rem;
            position: relative;
        }

        .sidebar .nav-link i {
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover {
            background: #f8fafc;
            color: #1f2937;
            transform: translateX(4px);
        }

        .sidebar .nav-link:hover i {
            transform: scale(1.1);
        }

        .sidebar .nav-link.active {
            background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.3);
        }

        .sidebar .nav-link.active i {
            transform: scale(1.1);
        }

        .sidebar hr {
            border-color: #e8ecf1;
            margin: 20px 0;
            opacity: 1;
        }

        .logout-btn {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border: none;
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            width: 100%;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 0.95rem;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(239, 68, 68, 0.35);
        }

        /* Content Area - ADJUSTED FOR FIXED SIDEBAR */
        .content {
            flex: 1;
            margin-left: 280px;
            padding: 30px;
            position: relative;
            z-index: 10;
            background: #f8fafc;
        }

        /* Topbar */
        .topbar {
            background: white;
            border-radius: 16px;
            padding: 24px 30px;
            margin-bottom: 25px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #e8ecf1;
        }

        .topbar-title {
            color: #1e293b;
            margin: 0;
            font-weight: 700;
            font-size: 1.6rem;
        }

        .topbar-subtitle {
            color: #64748b;
            font-size: 0.9rem;
            margin: 4px 0 0 0;
            font-weight: 500;
        }

        .topbar-actions {
            display: flex;
            gap: 12px;
        }

        .topbar-btn {
            background: #f8fafc;
            border: 1px solid #e8ecf1;
            color: #64748b;
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }

        .topbar-btn:hover {
            background: #1f2937;
            color: white;
            border-color: #1f2937;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.25);
        }

        /* Content Card */
        .content-wrapper {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            min-height: calc(100vh - 200px);
            border: 1px solid #e8ecf1;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                left: -280px;
            }

            .sidebar.active {
                left: 0;
            }

            .content {
                margin-left: 0;
                padding: 15px;
            }

            .topbar {
                padding: 18px 20px;
            }

            .topbar-title {
                font-size: 1.3rem;
            }
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>

    <!-- Background Pattern -->
    <div class="bg-pattern"></div>

    <div class="main-wrapper">

        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content --}}
        <div class="content">
            @include('layouts.topbar')

            <div class="content-wrapper">
                @yield('content')
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
