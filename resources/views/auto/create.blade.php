<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro de Vehículos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/auto.css') }}" rel="stylesheet">
    <style>
        /* Estilos personalizados */
        .booking-card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .taxi-card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            background-color: #f8f9fa;
            padding: 20px;
            margin-top: 20px;
        }
        .taxi-image {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            border: 2px solid #007bff; /* Bordes de color azul */
            display: none; /* Inicialmente oculto */
        }
    </style>
</head>
<body>
    <header style="padding: 40px">
        @include('menu.menu') {{-- Incluir el menú aquí si lo deseas --}}
    </header>

    <section class="bg-gradient-animated text-center" style="background-color: #333; color: white; padding: 30px 0;">
        <div class="container">
            <h2 class="display-4">Registro de vehículos oficiales</h2>
        </div>
    </section>

    <div id="agregar-auto" class="container my-5"> <!-- Contenedor específico para estilos -->
        <div class="row">
            <div class="col-md-6">
                <div class="booking-card p-4 border rounded shadow">
                    <h1 class="text-center">Registro</h1>
                    <form id="vehiculoForm" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Vehiculo" name="VehiculoNombre" required  minlength="3" maxlength="50"/>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Modelo" name="Modelo" required minlength="3" maxlength="50"/>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Placas" name="Placas" required minlength="1" maxlength="10"/>
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control" placeholder="Cilindros" name="Cilindros" min="1" max="20"  required />
                        </div>
                        <div class="mb-3">
                            <input type="file" class="form-control" name="vehiculoFoto" accept=".png,.jpg,.jpeg" required id="vehiculoFotoInput" />
                        </div>

                    <h3 class="text-center">Datos importantes</h3>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Tarjeta de circulación"
                            name="tarjeta_circulacion"  minlength="1" maxlength="8"
                            title="Debe contener entre 1 y 8 dígitos" required />
                        </div>

                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Póliza de seguro"
                            name="poliza_seguro" minlength="8" maxlength="10"
                            title="Debe contener entre 8 y 10 dígitos" required />
                        </div>
                        <!-- Contenedor para mostrar la vista previa de la imagen -->

                        <button class="btn btn-outline-secondary w-100" type="submit">Agregar vehículo</button>
                    </form>
                </div>
            </div>


            <div class="col-md-6">
                <div class="taxi-card text-center">
                    <h1>Vehículos oficiales</h1>

                    <center>
                        <img src="{{asset('images/coche_ejemplo.png')}}" id="vehiculoFotoPreview" alt="Vista previa de la foto del vehículo" class="img-fluid" style="max-width: 400px; width: 100%; height: auto;">
                    </center>

                     <div id="registroMensaje"></div> <!-- Mensaje de éxito o error -->
                </div>
            </div>
        </div>

        <div id="registroMensaje" class="mt-3"></div> <!-- Mensaje de éxito o error -->
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Muestra la vista previa de la imagen cuando se selecciona
            $('#vehiculoFotoInput').change(function(event) {
                const file = event.target.files[0]; // Obtener el primer archivo
                const reader = new FileReader(); // Crea un objeto FileReader

                reader.onload = function(e) {
                    $('#vehiculoFotoPreview').attr('src', e.target.result).show(); // Establece la fuente de la imagen
                };

                if (file) {
                    reader.readAsDataURL(file); // Leer el archivo como URL de datos
                } else {
                    $('#vehiculoFotoPreview').hide(); // Ocultar si no hay archivo
                }
            });

            $('#vehiculoForm').on('submit', function(event) {
                event.preventDefault(); // Evita el envío normal del formulario

                $.ajax({
                    url: "{{ route('auto_nuevo.store') }}", // Cambia a la ruta que maneja el almacenamiento
                    type: "POST",
                    data: new FormData(this), // Envía los datos del formulario
                    contentType: false, // No envía tipo de contenido
                    processData: false, // No procesa los datos
                    success: function(response) {
                        // Maneja la respuesta de éxito
                        $('#registroMensaje').html('<div class="alert alert-success">' + response.message + '</div>');
                        // Reinicia el formulario si es necesario
                        $('#vehiculoForm')[0].reset();
                        $('#vehiculoFotoPreview').hide(); // Oculta la vista previa
                    },
                    error: function(xhr) {
                        // Maneja errores
                        let errors = xhr.responseJSON.errors;
                        let errorMsg = '';
                        for (let key in errors) {
                            errorMsg += errors[key][0] + '<br>';
                        }
                        $('#registroMensaje').html('<div class="alert alert-danger">' + errorMsg + '</div>');
                    }
                });
            });
        });
    </script>
</body>
</html>
