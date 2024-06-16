<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @yield('custom-css')<!-- Incluyendo el archivo CSS -->
    <style>
        .custom-navbar {
            background-color: #161b22 !important;
        }

        .custom-navbar *:not(img) {
            color: white !important; /* Cambia esto si deseas otro color de texto */
        }

        .navbar-nav {
            margin-left: 0; /* Asegura que el margen izquierdo esté en cero */
        }

        .sidebar {
            height: 100%; /* Full-height: remove this if you want "auto" height */
            width: 0; /* 0 width - change this with JavaScript */
            position: fixed; /* Stay in place */
            z-index: 1; /* Stay on top */
            top: 0;
            right: 0;
            background-color: #111; /* Black*/
            overflow-x: hidden; /* Disable horizontal scroll */
            padding-top: 60px; /* Place content 60px from the top */
            transition: 0.5s; /* 0.5 second transition effect to slide in the sidebar */
        }

        .sidebar-content {
            padding: 15px;
        }

        .sidebar a{
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
            transition: 0.3s;
        }
        .sidebar p{
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: rgb(87, 84, 84);
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover {
            color: #f1f1f1;
        }
        .sidebar p:hover {
            color: #f1f1f1;
        }

        .sidebar .closebtn {
            position: absolute;
            top: 10px;
            right: 25px;
            font-size: 36px;
        }

        .color_nav {
            font-weight: bold;
        }

    </style>
</head>
<body style="background-color: #161b22; overflow-x: hidden">
    <header style="border-bottom: 0.5px solid rgb(119, 117, 117);">
        <nav class="navbar navbar-expand-lg custom-navbar">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/">
                                <img src="{{ asset('img/icono_principal.jpg') }}" class="rounded-circle" height="40px" width="40px">&nbsp;&nbsp;Pagina Principal
                            </a>
                        </li>
                    </ul>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown" style="padding-left: 82%">
                        <img src="{{ asset('img/user_img.png') }}" class="rounded-circle" height="40px" width="40px" id="img"  style="cursor: pointer;">
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Barra lateral -->
    <div id="mySidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <div class="sidebar-content">
            <a class="color_nav"><i class="fa-solid fa-user"></i>&nbsp;&nbsp;Usuario:</a>
            <p>{{ session('user_complete') }}</p>
            <hr style="color: white">
            <a class="color_nav"><i class="fa-solid fa-envelope"></i>&nbsp;&nbsp;Correo:</a>
            <p>{{ session('user_email') }}</p>
            <hr style="color: white">
            <form action="/logout" method="POST">
              @csrf
              <button type="submit" class="btn btn-danger">Cerrar Sesión &nbsp;<i class="fa-solid fa-arrow-right-to-bracket"></i></button>
            </form>
        </div>
    </div>

    {{$slot}}



    <footer>
    </footer>
    @yield('custom-js') <!-- Sección para JS personalizado -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/e8d65d76e0.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function openNav() {
            document.getElementById("mySidebar").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
        }

        document.getElementById('img').onclick = function() {
            openNav();
        };
    </script>
</body>
</html>
