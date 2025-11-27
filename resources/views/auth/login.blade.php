<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #0a3d62, #3c6382);
            margin: 0;
            padding: 0;
        }

        .form-container {
            width: 360px;
            margin: 90px auto;
            padding: 30px;
            background: white;
            border-radius: 14px;
            box-shadow: 0px 4px 15px #00000040;
            border-top: 5px solid #e84118;
        }

        h1 {
            text-align: center;
            margin-bottom: 22px;
            color: #0a3d62;
            font-weight: 800;
        }

        label { display:block; margin-top:12px; }
        input { width:100%; padding:10px; margin-top:5px; }

        button {
            width: 100%;
            padding: 12px;
            background: #e84118;
            color: white;
            border: none;
            border-radius: 6px;
            margin-top: 22px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: .2s;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h1>Iniciar Sesión</h1>

        <form action="{{ route('login.submit') }}" method="POST">
            @csrf

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Contraseña</label>
            <input type="password" name="password" required>

            <button type="submit">Ingresar</button>
        </form>

        <div class="link-btn" style="text-align:center; margin-top:20px;">
            <a href="{{ route('register') }}">¿No tenés cuenta? Registrarse</a>
        </div>
    </div>

</body>
</html>
