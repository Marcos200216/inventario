<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión / Registro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background-image: url('/images/ganado.png');
        background-repeat: no-repeat;
        background-position: center center;
        background-attachment: fixed;
        background-size: cover;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
    }

    .container {
        display: flex;
        width: 800px;
        max-width: 100%;
        min-height: 500px;
        background: transparent;
        border-radius: 15px;
        overflow: hidden;
        position: relative;
    }

    .form-container {
        position: absolute;
        top: 0;
        height: 100%;
        width: 50%;
        padding: 40px;
        transition: all 0.6s ease-in-out;
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    .sign-in-container {
        left: 0;
        z-index: 2;
    }

    .sign-up-container {
        left: 0;
        opacity: 0;
        z-index: 1;
    }

    .overlay-container {
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: 100%;
        overflow: hidden;
        transition: transform 0.6s ease-in-out;
        z-index: 100;
    }

    .overlay {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-radius: 15px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        color: #030101;
        position: relative;
        left: -100%;
        height: 100%;
        width: 200%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .overlay-panel {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 40px;
        text-align: center;
        top: 0;
        height: 100%;
        width: 50%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .overlay-left {
        transform: translateX(-20%);
    }

    .overlay-right {
        right: 0;
        transform: translateX(0);
    }

    .container.right-panel-active .sign-in-container {
        transform: translateX(100%);
        opacity: 0;
    }

    .container.right-panel-active .sign-up-container {
        transform: translateX(100%);
        opacity: 1;
        z-index: 5;
    }

    .container.right-panel-active .overlay-container {
        transform: translateX(-100%);
    }

    .container.right-panel-active .overlay {
        transform: translateX(50%);
    }

    .container.right-panel-active .overlay-left {
        transform: translateX(0);
    }

    .container.right-panel-active .overlay-right {
        transform: translateX(20%);
    }

    h1 {
        font-weight: bold;
        margin: 0;
        font-size: 28px;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    p {
        font-size: 14px;
        font-weight: 100;
        line-height: 20px;
        letter-spacing: 0.5px;
        margin: 20px 0 30px;
    }

    input {
        background-color: #eee;
        border: none;
        padding: 12px 15px;
        margin: 8px 0;
        width: 100%;
        border-radius: 5px;
    }

    button {
        border-radius: 20px;
        border: 1px solid #f39c12;
        background-color: #f39c12;
        color: #ffffff;
        font-size: 12px;
        font-weight: bold;
        padding: 12px 45px;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: transform 80ms ease-in;
        cursor: pointer;
        width: 100%;
        margin-top: 15px;
    }

    button:hover {
        background-color: #db8f17;
        border-color: #db8f17;
    }

    button:active {
        transform: scale(0.95);
    }

    button:focus {
        outline: none;
    }

    button.ghost {
        border: 1px solid #f39c12;
        background-color: #f39c12;
    }

    .error {
        color: red;
        text-align: center;
        margin-top: 10px;
        font-size: 14px;
    }

    @media (max-width: 768px) {
        .container {
            flex-direction: column;
            width: 100%;
            min-height: auto;
            height: auto;
            overflow: visible;
        }

        .form-container {
            width: 100%;
            position: relative;
            padding: 20px;
            transform: none !important;
            opacity: 1 !important;
            z-index: 1;
        }

        .overlay-container {
            display: none;
        }

        .container.right-panel-active .sign-in-container,
        .container.right-panel-active .sign-up-container {
            transform: none;
            opacity: 1;
        }
    }

    .logo-container {
        position: absolute;
        top: 20px;
        display: flex;
        justify-content: center;
        width: 100%;
        z-index: 1;
    }

    .overlay-logo {
        width: 142px;
        height: auto;
        pointer-events: none;
    }

    .overlay-panel p {
    font-size: 13px;             /* Texto un poco más grande */
    font-weight: bold;            /* Negrita semibold para más peso */
    line-height: 1.5;            /* Mejor interlineado */
   
    color: black;
 
    margin: 20px 0 30px;
}

</style>

</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-in-container">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h1>Iniciar Sesión</h1>
                <input type="email" name="email" placeholder="Correo electrónico" required />
                <input type="password" name="password" placeholder="Contraseña" required />
                <button type="submit">Ingresar</button>
            </form>
        </div>
        
        <div class="form-container sign-up-container">
            <form id="registerForm" method="POST" action="{{ route('register') }}">
                @csrf
                <h1>Crear Cuenta</h1>
                <input type="text" name="name" placeholder="Nombre" required />
                <input type="email" name="email" placeholder="Correo electrónico" required />
                <input type="password" name="password" placeholder="Contraseña" required />
                <input type="password" name="password_confirmation" placeholder="Confirmar Contraseña" required />
                <button type="button" id="registerButton">Registrarse</button>
            </form>
        </div>
        
       <div class="overlay-container">
    <div class="overlay">
       <div class="overlay-panel overlay-left">
    <div class="logo-container">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="overlay-logo">
    </div>
    <h1>Bienvenido de nuevo</h1>
    <p>Por favor, inicie sesión con sus credenciales para acceder al sistema de control de inventario de ganado.</p>
    <button class="ghost" id="signIn">Iniciar Sesión</button>
</div>
<div class="overlay-panel overlay-right">
    <div class="logo-container">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="overlay-logo">
    </div>
    <h1>Nuevo usuario</h1>
    <p>Regístrese para gestionar de forma eficiente y segura el inventario y el seguimiento de su ganado.</p>
    <button class="ghost" id="signUp">Registrarse</button>
</div>

    </div>
</div>

    </div>

    <!-- SweetAlert JS -->
     <!-- Por esta -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/src/js/i18n/es.js"></script>
      
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');
        const registerButton = document.getElementById('registerButton');
        const registerForm = document.getElementById('registerForm');

        // Verificar que todos los elementos existen
        if (!signUpButton || !signInButton || !container || !registerButton || !registerForm) {
            console.error('No se encontraron algunos elementos requeridos');
            return;
        }

        signUpButton.addEventListener('click', () => {
            container.classList.add('right-panel-active');
        });

        signInButton.addEventListener('click', () => {
            container.classList.remove('right-panel-active');
        });

       registerButton.addEventListener('click', async (e) => {
    e.preventDefault();
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    
    if (!csrfToken) {
        Swal.fire({
            title: 'Error',
            text: 'No se pudo verificar la seguridad de la solicitud',
            icon: 'error'
        });
        return;
    }

    try {
        const formData = new FormData(registerForm);
        // Aquí cambias registerForm.action por la ruta relativa '/register'
        const response = await fetch('/register', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            Swal.fire({
                title: '¡Éxito!',
                text: data.message || 'Registro exitoso. Por favor inicia sesión.',
                icon: 'success'
            }).then(() => {
                container.classList.remove('right-panel-active');
                registerForm.reset();
            });
        } else {
            let errorMessage = data.message || 'Error en el registro';
            if (data.errors) {
                errorMessage = Object.values(data.errors).join('\n');
            }
            Swal.fire({
                title: 'Error',
                text: errorMessage,
                icon: 'error'
            });
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error',
            text: 'Error de conexión con el servidor',
            icon: 'error'
        });
    }
});

    });
        
    // Mostrar SweetAlert en caso de error de login
    @if ($errors->has('email'))
    
        Swal.fire({
            icon: 'error',
            title: 'Credenciales incorrectas',
            text: '{{ $errors->first('email') }}',
            confirmButtonText: 'Aceptar'
        });
    @endif
</script>
</body>
</html>