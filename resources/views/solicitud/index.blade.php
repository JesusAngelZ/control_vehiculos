<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detalles del Vehículo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/auto.css') }}" rel="stylesheet">
    <style>
        /* Estilos personalizados */
        .booking-card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .car-utj {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            background-color: #f8f9fa;
            padding: 20px;
            margin-top: 20px;
        }
        .car-utj img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <header style="padding: 40px">
        @include('menu.menu') {{-- Incluir el menú aquí --}}
    </header>

    <section class="bg-gradient-animated text-center" style="background-color: #333; color: white; padding: 30px 0;">
        <div class="container">
            <h2 class="display-4">Detalles del Vehículo</h2>
        </div>
    </section>



    <div id="detalles-vehiculo" class="container my-5"> <!-- Contenedor específico para estilos -->
        <div class="row">
            <div class="col-md-6">
                <div class="booking-card p-4 border rounded shadow">
                    <h1 class="text-center">Detalles</h1>
                    <p><strong>ID Vehículo:</strong> {{ $vehiculo->id }}</p>
                    <p><strong>Marca:</strong> {{ $vehiculo->vehiculo }}</p>
                    <p><strong>Modelo:</strong> {{ $vehiculo->modelo }}</p>
                    <p><strong>Placas:</strong> {{ $vehiculo->placas }}</p>
                    <p><strong>Cilindros:</strong> {{ $vehiculo->cilindros }}</p>

                    <h2>Documentación</h2>
                    <p><strong>Tarjeta de circulación:</strong> <span id="car-make">{{ $documentacion->tarjeta_circulacion }}</span></p>
                    <p><strong>Calcomanía de seguro:</strong> <span id="car-model">{{ $documentacion->calcomonia_seguro }}</span></p>
                    <p><strong>Póliza de seguro:</strong> <span id="car-plate">{{ $documentacion->poliza_seguro }}</span></p>

                    <!-- Formulario para solicitar -->
                    <form id="solicitudForm" action="{{ route('solicitud.qr') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_auto" value="{{ $vehiculo->id }}">
                        <div class="mt-4">
                            <a href="{{ url()->previous() }}" class="btn btn-secondary w-100">Cancelar</a>
                            <button type="submit" class="btn btn-primary w-100 mt-2">Solicitar</button>
                        </div>
                    </form>


                </div>
            </div>

            <div class="col-md-6">
                <div class="car-utj text-center">
                    <h1>Imagen del Vehículo</h1>
                    <center>
                        <img src="{{$vehiculo->foto}}" alt="Vehículo" class="img-fluid">
                    </center>

                    <div id="registroMensaje" class="mt-3"></div> <!-- Mensaje de éxito o error -->
                </div>
            </div>
        </div>

        <div id="registroMensaje" class="mt-3"></div> <!-- Mensaje de éxito o error -->
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



</body>
</html>
