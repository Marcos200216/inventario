<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Sistema de Inventario de Ganado</title>
    <style>
        /* Tipografía y fondo base */
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f1f3f6;
            color: #333;
        }

       .sidebar {
    width: 240px;
    background-color: #f7fafc; /* gris muy claro y profesional */
    color: #0d1118; /* gris oscuro */
    position: fixed;
    height: 100vh;
    padding: 30px 0;
    box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
    border-right: 2px solid #cbd5e1; /* borde profesional sutil */
}

        .sidebar h3 {
         position: relative;
            top: 16px; /* baja el título 40px */
            text-align: center;
            margin-bottom: 30px;
            font-size: 20px;
            color: #1c2025;
        }
         .sidebar-logo {
    position: absolute; /* posición absoluta dentro del sidebar */
    top: 10px;          /* distancia desde arriba */
    left: 10px;         /* distancia desde izquierda */
    width: 75px;        /* tamaño del logo, ajusta a tu gusto */
    height: auto;
    z-index: 10;        /* para que esté sobre el resto */
}

       .sidebar a {
    display: flex;
    align-items: center;
    padding: 12px 24px;
    color: #1a212a;
    text-decoration: none;
    transition: all 0.2s ease;
    font-size: 15px;
    font-weight: bold; /* texto en negrita */
}

        .sidebar a:hover,
       /* El estado activo no cambia estilos */
.sidebar a.active {
    background-color: transparent;
    color: #1a212a; /* o el color normal del texto */
}

/* Solo cuando pases el mouse sobre cualquier enlace */
.sidebar a:hover {
    background-color: #334155;
    color: #fff;
}

        /* Main content */
        .main-content {
            margin-left: 240px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            position: sticky;
              top: 0;
    background-color: #ffffff;
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e5e7eb;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

        .topbar .title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 18px;
    font-weight: 600;
    color: #1e293b;
}
.topbar .title i {
    font-size: 22px;
    color: #0f172a;
}

       .logout-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    background-color: #087282;
    color: #fff;
    border: none;
    padding: 10px 15px;
    font-size: 13px;
    border-radius: 8px;
     font-weight: bold;
    cursor: pointer;
    transition: background 0.3s;
}

.logout-btn i {
    font-size: 16px;
}
        .logout-btn:hover {
    background-color: #05454f;
}

        .content {
            padding: 30px;
            flex-grow: 1;
        }

        /* Responsivo */
        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                display: flex;
                flex-direction: row;
                justify-content: space-around;
                padding: 15px 0;
            }

            .sidebar h3 {
                display: none;
            }

            .sidebar a {
                padding: 10px;
                font-size: 14px;
            }

            .main-content {
                margin-left: 0;
            }

            .topbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .topbar .title {
                margin-bottom: 10px;
            }
        }
        .sidebar a i {
    width: 24px;
    text-align: center;
    margin-right: 12px;
    font-size: 16px;
}
    </style>
</head>
<body>

  <div class="sidebar">
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="sidebar-logo" />
    <h3>Menú</h3>
    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    <a href="{{ route('ganados.index') }}" class="{{ request()->routeIs('ganados.*') ? 'active' : '' }}">
        <i class="fas fa-cow"></i> Ganado
    </a>
   <a href="{{ route('reportes.index') }}" class="{{ request()->routeIs('reportes.index') ? 'active' : '' }}">
    <i class="fas fa-chart-bar"></i> Reportes
</a>


</div>

    <div class="main-content">
       <div class="topbar">
    <div class="title">
        
        Sistema de Inventario de Ganado
    </div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i>
            Cerrar Sesión
        </button>
    </form>
</div>



        <div class="content">
            @yield('content')
        </div>
    </div>

</body>
</html>
