<!-- resources/views/solicitud/success.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éxito</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos para la animación */
        #success-animation {
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div id="success-animation">
            <img src="{{ asset('images/success.gif') }}" alt="Success Animation" />
            <p>{{ $message }}</p>
        </div>
    </div>

    <script>
        // Redirigir a la pantalla principal después de 5 segundos
        setTimeout(function() {
            window.location.href = "{{ url('api/auth/principal') }}"; // Cambia la URL a tu pantalla principal
        }, 5000); // 5000 ms = 5 segundos
    </script>
</body>
</html>
