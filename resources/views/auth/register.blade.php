<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #0a3d62, #3c6382);
            margin: 0;
            padding: 0;
        }

        .form-container {
            width: 360px;
            margin: 70px auto;
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

        label {
            display: block;
            margin-top: 12px;
            font-size: 15px;
            color: #2d3436;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #bdc3c7;
            border-radius: 6px;
            background: #f7f7f7;
            font-size: 14px;
            outline: none;
        }

        input:focus,
        select:focus {
            border-color: #e84118;
            box-shadow: 0 0 6px #e8411850;
        }

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
            transition: 0.2s;
        }

        button:hover {
            background: #c23616;
        }

        .link-btn {
            text-align: center;
            margin-top: 20px;
        }

        .link-btn a {
            text-decoration: none;
            color: #0a3d62;
            font-weight: bold;
        }

        .link-btn a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h1>Registro</h1>

        <form action="{{ route('register.submit') }}" method="POST">
            @csrf

            <label>Nombre</label>
            <input type="text" name="nombre" required>

            <label>Apellido</label>
            <input type="text" name="apellido" required>

            <label>Departamento</label>
            <select name="departamento" required>
                <option value="">Seleccione una opción</option>
                <option value="opcion1">Opción 1</option>
                <option value="opcion2">Opción 2</option>
            </select>

            <label>Puesto</label>
            <select name="puesto" required>
                <option value="">Seleccione una opción</option>
                <option value="opcion1">Opción 1</option>
                <option value="opcion2">Opción 2</option>
            </select>

            <label>Empresa</label>
            <select name="empresa" required>
                <option value="ninguna">Ninguna</option>
                <option value="cuevas">CUEVAS</option>
                <option value="mpy">MPY</option>
            </select>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Contraseña</label>
            <input type="password" name="password" required>

            <label>Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" required>

            <button type="submit">Registrarse</button>
        </form>

        <div class="link-btn">
            <a href="/login">¿Ya tenés cuenta? Iniciar sesión</a>
        </div>
    </div>
</body>
</html>
