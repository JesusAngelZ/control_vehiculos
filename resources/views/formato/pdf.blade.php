<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Uso de Vehículo Oficial</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">


</head>

<style>
    /* Estilo general para el cuerpo */
    body {
        font-family: 'Arial', sans-serif; /* Tipo de letra general */
        background-color: #ffffff; /* Color de fondo general */
        margin: 0;
        padding: 0;
        color: #333; /* Color del texto */
    }

    .form-container {
        max-width: 800px; /* Ancho máximo del contenedor */
        margin: auto; /* Centrado del contenedor */
        padding: 20px; /* Espaciado interno del contenedor */
        background-color: #fff; /* Fondo blanco */
        border-radius: 8px; /* Bordes redondeados */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra suave */
    }

    .section {
        margin: 20px 0; /* Espaciado vertical entre secciones */
        padding: 20px;
        border-radius: 8px;
        background-color: #ffffff; /* Fondo blanco para la sección */
        box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1); /* Sombra suave */
    }

    .section-title {
        background: #00aa8a; /* Color de fondo del título */
        color: #ffffff; /* Color del texto del título */
        text-align: center; /* Centrado del título */
        padding: 10px; /* Espaciado alrededor del título */
        border-radius: 8px; /* Bordes redondeados */
        margin: 0; /* Sin margen */
    }

    .row {
        display: flex;
        align-items: center;
        gap: 15px;
        margin: 10px 0; /* Espaciado vertical entre filas */
    }

    label {
        margin-right: 15px; /* Espacio entre la etiqueta y el texto */
        font-weight: bold; /* Negrita para las etiquetas */
        flex: 0 0 200px; /* Anchura fija para las etiquetas */
        color: #333; /* Color de las etiquetas */
    }

    span {
        color: #555; /* Color del texto */
        flex: 1; /* Ocupa el resto del espacio */
    }

    /* Estilo opcional para el encabezado */
    h2 {
        margin: 0; /* Quitar margen para centrar mejor */
        font-family: 'Helvetica Neue', sans-serif; /* Tipo de letra del encabezado */
    }

    /* Estilo de borde y fondo para las filas */
    .row:nth-child(even) {
        background-color: #f2f2f2; /* Fondo alterno para filas pares */
    }

    .row:hover {
        background-color: #eaeaea; /* Fondo al pasar el mouse */
    }

    /* Estilos para inputs y ranges */
    input[type="text"],
    input[type="range"] {
        flex: 1; /* Ocupa el resto del espacio */
        padding: 10px; /* Espaciado interno */
        border: 1px solid #ccc; /* Borde del input */
        border-radius: 4px; /* Bordes redondeados */
        margin-left: 15px; /* Espacio a la izquierda */
    }

    .checkbox-group {
        display: flex;
        flex-wrap: wrap; /* Permite que los checkboxes se envuelvan */
        gap: 10px; /* Espacio entre los checkboxes */
    }

    .checkbox-group label {
        display: flex;
        align-items: center; /* Centrar texto y checkbox */
        font-weight: normal; /* Texto normal para checkboxes */
    }

/* Estilo de la fila combustible para alinear en columnas */
.row.combustible {
    display: flex;
    justify-content: center;
    gap: 30px; /* Espacio entre las columnas */
    margin: 10px 0;
    text-align: center;
}

/* Estilo para las etiquetas, imágenes y spans en columnas */
.combustible-label {
    flex: 1;
    font-weight: bold;
    text-align: center;
}

.combustible-img {
    max-width: 100px; /* Tamaño de las imágenes */
    height: auto;
    display: block;
    margin: 0 auto;
}

.combustible2-img {
    max-width: 110px; /* Tamaño de las imágenes */
    height: auto;
    display: block;
    margin: 0 auto;
    margin-left: 50px;
}

.combustible-span {
    flex: 1;
    color: #555;
    text-align: center;
    margin-top: 5px;
    margin-left: 20px;
}




    /*Pasar pagina*/
    .page-break {
    page-break-after: always;
  }
</style>

<header>
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="text-align: left; width: 20%; height: 100px; vertical-align: middle; overflow: hidden;">
                <img class="img-responsive" src="images/Logo-utj.png" alt="Logo UTJ" style="max-width: 180px; height: 80px; width: auto;">
            </td>
            <td style="text-align: center; width: 60%; vertical-align: middle; font-size: 15px;">
                <h1 style="margin: 0;">Solicitud de uso de vehículo oficial</h1>
            </td>
            <td style="text-align: right; width: 20%; vertical-align: middle;">
                <p class="pie" style="margin: 0;">RI-SAD-01-01<br>
                    Rev. 00<br>
                    {{ date('d-m-Y') }}</p>
            </td>
        </tr>
    </table>
</header>








<body>

    <div class="form-container">


        <section class="section">
            <h2 class="section-title">Datos de la Solicitud</h2>

            <div class="row">
                <label>Fecha de solicitud:</label>
                <span>{{ $solicitud->fecha_solicitud }}</span>
            </div>
            <div class="row">
                <label>Fecha y hora de salida:</label>
                <span>{{ $solicitud->fecha_salida }}</span>
            </div>
            <div class="row">
                <label>Fecha y hora de regreso:</label>
                <span>{{ $solicitud->fecha_regreso }}</span>
            </div>

            <div class="row">
                <label>Nombre del solicitante:</label>
                <span>{{ $usuario->name }}</span>
            </div>

            <div class="row">
                <label>Área:</label>
                <span>Desconocido</span>

                <label style="margin-left: 12px;">Puesto:</label>
                <span>Desconocido</span>
            </div>

            <div class="row">
                <label>Motivo de la solicitud:</label>
                <span>{{ $solicitud->motivo }}</span>

                <label style="margin-left: 12px;">Oficio de comisión:</label>
                <span>{{ $solicitud->oficio_comision }}</span>
            </div>


            <table style="width: 100%; margin-top: 20px; font-size: 14px;">
                <tr>
                    <td style="text-align: center; vertical-align: top; padding: 10px;"> <!-- Solicita en la parte izquierda -->
                        <label style="margin-bottom: 10px;">Solicita:</label>
                        <br>
                        <br>
                        <br>
                        <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px;">&nbsp;</span> <!-- Barra para la firma -->
                        <br>
                        <span>Nombre y puesto de la o el solicitante</span>
                    </td>

                    <td style="text-align: center; vertical-align: top; padding: 10px;"> <!-- Autoriza en el centro -->
                        <label>Autoriza:</label>
                        <br>
                        <br>
                        <br>
                        <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px;">&nbsp;</span> <!-- Barra para la firma -->
                        <br>
                        <span>Nombre y puesto de Jefe (a) inmediato</span>
                    </td>

                    <td style="text-align: center; vertical-align: top; padding: 10px;"> <!-- Vo. Bo en la parte derecha -->
                        <label>Vo. Bo:</label>
                        <br>
                        <br>
                        <br>
                        <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px;">&nbsp;</span> <!-- Barra para la firma -->
                        <br>
                        <span>C.P. Felipe Nava Aguiler Secretario Administrativo</span>
                    </td>
                </tr>
            </table>


        </section>

        <section class="section">
            <h2 class="section-title" style="background-color: #555">Para llenado del Departamento de Recursos Materiales y Servicios Generales</h2>
            <h2 class="section-title">Datos del usuario</h2>

            <div class="row">
                <label>Nombre:</label>
                <span>{{  $usuario->name }}</span>
            </div>

            <div class="row">
                <label>Licencia:</label>
                <span>Desconocido</span>

                <label style="margin-left: 12px;">Tipo de sangre:</label>
                <span>Desconocido</span>
            </div>

            <div class="row">
                <label>Alergias:</label>
                <span>Desconocido</span>

                <label style="margin-left: 12px;">Otros:</label>
                <span>Desconocido</span>
            </div>

        </section>

        <div class="page-break"></div>

        <section class="section">
            <h2 class="section-title">Vehículo asignado</h2>
            <div class="row">
                <label>Vehículo:</label>
                <span>{{$auto->vehiculo}}</span>

                <label style="margin-left: 12px;">Modelo:</label>
                <span>{{$auto->modelo}}</span>
            </div>

            <div class="row">
                <label>Placas:</label>
                <span>{{$auto->placas}}</span>

                <label style="margin-left: 12px;">Cilindros:</label>
                <span>{{$auto->cilindros}}</span>
            </div>
        </section>


        <section class="section">
            <h2 class="section-title">Documentación del vehículo</h2>
            <div class="row">
                <label style="margin-left: 12px;">Tarjeta de circulación:</label>
                <span>{{$documentacion->tarjeta_circulacion}}</span>

            </div>

            <div class="row">
                <label style="margin-left: 12px;">Calcomonia de seguro:</label>
                <span>{{$documentacion->calcomonia_seguro}}</span>
            </div>
            <div class="row">
                <label style="margin-left: 12px;">Póliza de seguro:</label>
                <span>{{$documentacion->poliza_seguro}}</span>
            </div>
        </section>

        <section class="section">
            <h2 class="section-title">Herramientas y accesorios del vehículo</h2>

            <table style="width: 100%; border-collapse: collapse;">
                <!-- Primera fila con 4 elementos -->
                <tr>
                    <td style="padding-right: 5px;"><label>Cable p/halar:</label></td>
                    <td style="padding-right: 15px;"><input type="checkbox"></td>

                    <td style="padding-right: 5px;"><label>Linterna:</label></td>
                    <td style="padding-right: 15px;"><input type="checkbox"></td>

                    <td style="padding-right: 5px;"><label>Cables para batería:</label></td>
                    <td style="padding-right: 15px;"><input type="checkbox"></td>
                </tr>

                <!-- Segunda fila con 3 elementos -->
                <tr>
                    <td style="padding-right: 5px;"><label>Caja de herramientas:</label></td>
                    <td style="padding-right: 15px;"><input type="checkbox"></td>

                    <td style="padding-right: 5px;"><label>Llanta de repuesto:</label></td>
                    <td style="padding-right: 15px;"><input type="checkbox"></td>

                    <td style="padding-right: 5px;"><label>Triángulos de emergencia:</label></td>
                    <td><input type="checkbox"></td>

                    <td colspan="2"></td>
                </tr>

                <!-- Tercera fila con 3 elementos -->
                <tr>
                    <td style="padding-right: 5px;"><label>Tapetes:</label></td>
                    <td style="padding-right: 15px;"><input type="checkbox"></td>

                    <td style="padding-right: 5px;"><label>Extinguidor:</label></td>
                    <td style="padding-right: 15px;"><input type="checkbox"></td>

                    <td style="padding-right: 5px;"><label>Carátula de radio:</label></td>
                    <td><input type="checkbox"></td>
                    <td colspan="2"></td>
                </tr>

                <!-- Fila de "Otros" con línea separadora debajo de "Otros" -->
                <tr>
                    <td style="padding-right: 5px;"><label>Gato:</label></td>
                    <td><input type="checkbox"></td>

                    <td colspan="5" style="text-align: left;">
                        <label style="padding: 20px;">Otros:</label>
                        <span style="border-bottom: 1px solid #000; display: inline-block; width: 70%; margin-left: 5px;"></span>
                    </td>
                </tr>

            </table>
        </section>


        <section class="section">
            <h2 class="section-title">Combustible</h2>

            <div class="row combustible">
                <label class="combustible-label">Combustible de salida:</label>
                <label class="combustible-label">Combustible de regreso:</label>
            </div>

            <div class="row combustible">
                <br>
                <img src="images/inicial.png" alt="Imagen de combustible inicial" class="combustible-img">

                <span style="font-weight: bold;" class="combustible-span">{{$combustible->combustible_inicial}}</span>

                <img src="images/final.png" alt="Imagen de combustible final" class="combustible2-img">
                <span style="font-weight: bold;" class="combustible-span">{{$combustible->combustible_salida}}</span>
            </div>

        </section>


        <div class="page-break"></div>


        <section class="section">
            <h2 class="section-title">Kilometraje</h2>
            <div class="row">

                <label style="margin-left: 12px;">Kilometraje inicial:</label>
                <span>{{$kilometraje->kilometraje_inicial}}</span>
            </div>

            <div class="row">
                <label style="margin-left: 12px;">Kilometraje final:</label>
                <span>{{$kilometraje->kilometraje_salida}}</span>
            </div>
        </section>



        <section class="section">
            <h2 class="section-title">Estado de carrocería de vehículo</h2>

            <center>
                <img class="img-responsive" src="{{ $solicitud->estado_vehiculo_foto }}" style="max-width: 200px; height: auto;">
            </center>


           </section>


        <section class="section">
            <h2 class="section-title">Firmas</h2>
            <table style="width: 100%; margin-top: 20px; font-size: 14px;">
                <tr>
                    <td style="text-align: center; vertical-align: top; padding: 10px;"> <!-- Solicita en la parte izquierda -->
                        <br>
                        <br>
                        <br>
                        <span style="border-bottom: 1px solid #000; display: inline-block; width: 300px;">&nbsp;</span> <!-- Barra para la firma -->
                        <br>
                        <span>Firma de recibido de conformidad</span>
                    </td>

                    <td style="text-align: center; vertical-align: top; padding: 10px;"> <!-- Autoriza en el centro -->
                        <br>
                        <br>
                        <br>
                        <span style="border-bottom: 1px solid #000; display: inline-block; width: 300px;">&nbsp;</span> <!-- Barra para la firma -->
                        <br>
                        <span>Sello y firma del Departamento de Recursos Materiales y Servicios Generales</span>
                    </td>
                </tr>
            </table>


        </section>
    </div>


</body>
</html>
