<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Website</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
        }

        header {
            background-color: #f5d654;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            text-decoration: none;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }

        nav li {
            margin-right: 20px;
        }

        nav a {
            text-decoration: none;
            color: #333;
        }

        .hero {
            background-color: #f5d654;
            padding: 80px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 48px;
            font-weight: bold;
            color: #333;
        }

        .hero p {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }

        .hero button {
            background-color: #333;
            color: #fff;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .book-store {
            padding: 40px;
            text-align: center;
        }

        .book-store h2 {
            font-size: 32px;
            font-weight: bold;
            color: #333;
        }

        .book-store p {
            font-size: 16px;
            color: #333;
            margin-bottom: 30px;
        }

        .books {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .book {
            width: 200px;
            margin: 10px;
            text-align: center;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .book img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }

        .book h3 {
            margin-top: 10px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .book p {
            font-size: 14px;
            color: #333;
            margin-bottom: 5px;
        }

        .book .price {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <header>
        <a href="#" class="logo">PerpRi</a>
        <nav>
            @if (Route::has('login'))
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
                @auth
                    @php
                        $role = Auth::user()->type;
                        $homeRoute = '';
        
                        switch($role) {
                            case 'admin':
                                $homeRoute = 'admin/home'; // Ganti dengan nama route yang sesuai untuk admin
                                break;
                            case 'petugas':
                                $homeRoute = 'petugas/home'; // Ganti dengan nama route yang sesuai untuk petugas
                                break;
                            case 'siswa':
                            default:
                                $homeRoute = 'siswa/home'; // Ganti dengan nama route yang sesuai untuk siswa
                                break;
                        }
                    @endphp
                    <a href="{{ route($homeRoute) }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>
        
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                    @endif
                @endauth
            </div>
        @endif
        
        </nav>
    </header>

    <div class="hero">
        <h1>PerpRi</h1>
        <h2>PerpusTB</h2>
        <p>Wanna rent some Book??</p>
        <a href="/template">
  
</a>
    </div>

   

</body>
</html>