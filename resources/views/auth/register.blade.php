<!-- resources/views/auth/register.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .login-container {
            max-width: 400px;
            width: 90%;
            margin: 80px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.15);
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 1rem;
        }

        .btn {
            width: 100%;
            background-color: #38c172; /* verde */
            color: white;
            padding: 10px;
            margin-top: 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #2d995b;
        }

        .message {
            text-align: center;
            margin-top: 15px;
            font-size: 0.9rem;
        }

        .message a {
            color: #3490dc;
            text-decoration: none;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-container {
                margin: 30px auto;
                padding: 20px;
            }

            h2 {
                font-size: 1.5rem;
            }

            input[type="text"],
            input[type="email"],
            input[type="password"],
            .btn {
                font-size: 0.9rem;
                padding: 8px;
            }

            .message {
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Registro</h2>

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <label>Nombre completo:</label>
            <input type="text" name="name" required>

            <label>Correo electrónico:</label>
            <input type="email" name="email" required>

            <label>Contraseña:</label>
            <input type="password" name="password" required>

            <label>Confirmar contraseña:</label>
            <input type="password" name="password_confirmation" required>

            <button class="btn" type="submit">Registrarse</button>
        </form>

        <div class="message">
            ¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
        </div>
    </div>
</body>
</html>
