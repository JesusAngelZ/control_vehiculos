<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Actualizar Vehículos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/auto.css') }}" rel="stylesheet">
    <style>
        /* Estilos personalizados */
        .booking-card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px; /* Espaciado interno */
            margin-bottom: 20px; /* Espaciado externo */
        }
        .car-utj {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            background-color: #f8f9fa;
            padding: 20px;
            margin-top: 20px;
        }
        .car-utj-image {
            max-width: 75%; /* Cambia este valor según sea necesario */
            height: auto;
            border-radius: 10px;
            border: 2px solid #007bff; /* Bordes de color azul */
        }
    </style>
</head>
<body>
    <header style="padding: 40px">
        @include('menu.menu') {{-- Incluir el menú aquí si lo deseas --}}
    </header>

    <section class="bg-gradient-animated text-center" style="background-color: #333; color: white; padding: 30px 0;">
        <div class="container">
            <h2 class="display-4">Verificación de solicitud</h2>
        </div>
    </section>

    <div id="agregar-auto" class="container my-5"> <!-- Contenedor específico para estilos -->
        <div class="row">
            <div class="col-md-6">
                <div class="booking-card">
                    <h2>Datos del Solicitante</h2>
                    <p><strong>Nombre completo:</strong> <span id="name">{{ $usuario->name }}</span></p>
                    <p><strong>Correo electrónico:</strong> <span id="email">{{ $usuario->email }}</span></p>
                    <p><strong>Profesión:</strong> <span id="profession">{{ $profession }}</span></p>

                    <h2>Datos del Vehículo</h2>
                    <p><strong>Marca del vehículo:</strong> <span id="car-make">{{ $vehiculo->vehiculo }}</span></p>
                    <p><strong>Modelo del vehículo:</strong> <span id="car-model">{{ $vehiculo->modelo }}</span></p>
                    <p><strong>Placas del vehículo:</strong> <span id="car-plate">{{ $vehiculo->placas }}</span></p>
                    <p><strong>Número de cilindros:</strong> <span id="car-cylinders">{{ $vehiculo->cilindros }}</span></p>

                    <h2>Documentación</h2>
                    <p><strong>Tarjeta de circulación:</strong> <span id="car-make">{{ $documentacion->tarjeta_circulacion }}</span></p>
                    <p><strong>Calcomanía de seguro:</strong> <span id="car-model">{{ $documentacion->calcomonia_seguro }}</span></p>
                    <p><strong>Póliza de seguro:</strong> <span id="car-plate">{{ $documentacion->poliza_seguro }}</span></p>

                    <br>
                    <img src="{{$vehiculo->foto}}" alt="Vehículo" class="img-fluid car-utj-image mx-auto d-block"> <!-- Centrado -->



    <br>
                </div>
            </div>

            <div class="col-md-6">
                <div class="car-utj text-center">
                    <h1 class="text-center">Completar Solicitud</h1>
                    <form id="registerForm" action="{{ route('solicitud.update', $datos->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Indica que se está realizando una actualización -->
                        <input type="hidden" name="id" value="{{ $datos->id }}"> <!-- Campo oculto para el ID de la solicitud -->

                        @if ($datos->estado_vehiculo == 'Disponible')
                            <div class="mb-3">
                                <label for="motivo">Motivo de la Solicitud</label>
                                <input type="text" name="motivo" placeholder="Motivo de la solicitud" class="form-control" required />
                            </div>

                            <div class="mb-3">
                                <label for="oficio_comision">Oficio de comisión (opcional)</label>
                                <input type="text" name="oficio_comision" placeholder="Oficio de comisión" class="form-control" />
                            </div>
                            <div class="mb-3">
                                <label for="fecha_salida">Fecha de Salida</label>
                                <input type="datetime-local" id="fecha_salida" name="fecha_salida" class="form-control" required />
                            </div>

                            <div class="mb-3">
                                <label for="kilometraje_inicial">Kilometraje inicial</label>
                                <div class="row align-items-center"> <!-- Fila que alinea los elementos -->
                                    <div class="col-md-6"> <!-- Columna para la imagen -->
                                        <img src="{{ asset('images/kilometraje.png') }}" alt="Kilometraje inicial" class="img-fluid mx-auto d-block" style="max-width: 60%;">
                                    </div>
                                    <div class="col-md-6"> <!-- Columna para el input -->
                                        <input type="number" name="kilometraje_inicial" class="form-control" value="{{ old('kilometraje_inicial', $datos->kilometraje_inicial) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="combustible_inicial">Combustible inicial</label>
                                <div class="row align-items-center"> <!-- Fila que alinea los elementos -->
                                    <div class="col-md-6"> <!-- Columna para la imagen -->
                                        <img src="{{ asset('images/inicial.png') }}" alt="Combustible inicial" class="img-fluid mx-auto d-block" style="max-width: 55%;">
                                    </div>
                                    <div class="col-md-6"> <!-- Columna para el input -->
                                        <input type="number" name="combustible_inicial" class="form-control" value="{{ old('combustible_inicial', $datos->combustible_inicial) }}" required>
                                    </div>
                                </div>
                            </div>


                        @elseif ($datos->estado_vehiculo == 'Usando')
                            <div class="mb-3">
                                <label for="fecha_regreso">Fecha de Regreso</label>
                                <input type="datetime-local" id="fecha_regreso" name="fecha_regreso" class="form-control" required />
                            </div>
                            <div class="mb-3">
                                <label for="kilometraje_final">Kilometraje final</label>
                                <div class="row align-items-center"> <!-- Fila que alinea los elementos -->
                                    <div class="col-md-6"> <!-- Columna para la imagen -->
                                        <img src="{{ asset('images/kilometraje.png') }}" alt="Kilometraje final" class="img-fluid mx-auto d-block" style="max-width: 75%;">
                                    </div>
                                    <div class="col-md-6"> <!-- Columna para el input -->
                                        <input type="number" name="kilometraje_final" class="form-control" value="{{ old('kilometraje_final', $datos->kilometraje_final) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="combustible_final">Combustible final</label>
                                <div class="row align-items-center"> <!-- Fila que alinea los elementos -->
                                    <div class="col-md-6"> <!-- Columna para la imagen -->
                                        <img src="{{ asset('images/final.png') }}" alt="Combustible final" class="img-fluid mx-auto d-block" style="max-width: 75%;">
                                    </div>
                                    <div class="col-md-6"> <!-- Columna para el input -->
                                        <input type="number" name="combustible_final" class="form-control" value="{{ old('combustible_final', $datos->combustible_final) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="estado_vehiculo_foto">Toma de fotografía del vehículo</label>
                                <input type="file" class="form-control" name="estado_vehiculo_foto" accept="image/*" required />
                            </div>

                        @endif
                        <br>
                        <button type="submit" class="btn btn-primary w-100">Enviar Solicitud</button>
                    </form>
                </div>
            </div>
        </div>

        <div id="registroMensaje" class="mt-3"></div> <!-- Mensaje de éxito o error -->
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
