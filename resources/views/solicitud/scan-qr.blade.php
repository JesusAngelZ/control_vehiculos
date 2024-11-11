<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR pase</title>
    <style>
        /* Estilos adicionales para la tarjeta */
        body {
            background-color: #d7d6d3; /* Color de fondo */
            font-family: 'Verdana', sans-serif; /* Fuente de la página */
            display: block; /* Cambiar de flex a bloque */
            margin: 0; /* Sin margen */
        }

        .id-card-holder {
            width: 250px; /* Ancho de la tarjeta */
            padding: 16px; /* Espaciado interno */
            margin: 20px auto; /* Margen automático para centrar horizontalmente */
            background-color: #1f1f1f; /* Color de fondo de la tarjeta */
            border-radius: 8px; /* Bordes redondeados */
            position: relative; /* Posicionamiento relativo */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5); /* Sombra de la tarjeta */
            text-align: center; /* Centrar texto */
        }

        .id-card {
            background-color: #fff; /* Fondo blanco de la tarjeta */
            padding: 15px; /* Espaciado interno */
            border-radius: 10px; /* Bordes redondeados */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Sombra más suave */
        }

        .header img {
            width: 100px; /* Ancho de la imagen del logo */
            margin: 15px auto; /* Centra la imagen */
        }

        .photo img {
            width: 100px; /* Tamaño del código QR */
            height: 100px; /* Altura del código QR */
            margin: 10px auto; /* Centrando imagen */
        }

        h2 {
            font-size: 18px; /* Tamaño de fuente del título */
            margin: 10px 0; /* Espaciado */
            font-weight: bold; /* Texto en negrita */
        }

        h3 {
            font-size: 14px; /* Tamaño de fuente del subtítulo */
            margin: 5px 0; /* Espaciado */
            font-weight: 300; /* Peso de fuente más ligero */
        }

        p {
            font-size: 10px; /* Tamaño de fuente de los párrafos */
            margin: 2px 0; /* Espaciado */
        }

        .description {
            font-size: 12px; /* Tamaño de fuente para la descripción */
            margin: 10px 0; /* Espaciado para el párrafo adicional */
            font-style: italic; /* Estilo en cursiva para la descripción */
        }

        .warning {
            color: red; /* Color de texto para la advertencia */
            font-weight: bold; /* Texto en negrita */
            font-size: 14px; /* Tamaño de fuente para la advertencia */
            margin: 10px 0; /* Margen alrededor del texto */
        }

        section {
            background-color: #333; /* Color de fondo de la sección */
            color: white; /* Color del texto */
            padding: 30px 0; /* Espaciado interno de la sección */
            text-align: center; /* Centra el texto de la sección */
        }

        .container {
            max-width: 800px; /* Ancho máximo de la sección */
            margin: 0 auto; /* Centra la sección horizontalmente */
        }
    </style>
</head>
<body>
    <header style="padding: 30px">
        @include('menu.menu') {{-- Incluir el menú aquí --}}
    </header>

    <section>
        <div class="container">
            <h2 class="display-4">Pase de salida / entrada</h2>
            <p class="warning">Advertencia: refrescar la pantalla puede generar problemas.</p> <!-- Advertencia añadida -->
        </div>
    </section>

    <div class="id-card-holder">
        <div class="id-card">
            <div class="header">
                <h1><a href="/" class="brand">UTJ</a></h1>
            </div>
            <div class="photo qr-code">
                {!! QrCode::size(100)->generate($id) !!} <!-- Código QR aumentado a 100x100 -->
            </div>
            <h2>Pase de salida / entrada</h2>
            <hr>
            <p class="description">Este código QR debe presentarse al guardia de seguridad para su salida y acceso al plantel.</p>
            <p><strong>"Dirección: "</strong> C. Luis J. Jiménez 577, Miravalle, 44970 Guadalajara, Jal.</p>
        </div>
    </div>
</body>
</html>
