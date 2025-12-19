<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notificación</title>
</head>
<body style="font-family: Arial, sans-serif;">
    <h2>📢 Nueva notificación</h2>

    <p>{{ $mensaje }}</p>

    @if($comentario)
        <p><strong>Comentario:</strong></p>
        <p>{{ $comentario }}</p>
    @endif

    <hr>

    <p style="font-size: 12px; color: #666;">
        Intranet Garden 🌱
    </p>
</body>
</html>
