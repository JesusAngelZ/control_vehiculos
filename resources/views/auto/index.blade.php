<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mi Tabla de DataTables</title>

        <!-- Estilos necesarios para DataTables y los botones -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/buttons/2.1.1/css/buttons.bootstrap5.min.css" rel="stylesheet">

        <!-- Scripts necesarios -->
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>

        <!-- Scripts necesarios para los botones de DataTables -->
        <script src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.bootstrap5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.print.min.js"></script>
    </head>

<body>

    <header style="padding: 40px">
        @include('menu.menu') {{-- Incluir el menú aquí --}}
    </header>


    <section class="section bg-gradient-animated text-center" style="background-color: #333; color: white; padding: 30px 0;">
        <div class="container">
            <h2 class="display-4">Listado de Autos</h2>
        </div>
    </section>

    <div class="container mt-5">
        <!-- Contenedor para el botón -->
        <div class="text-end mb-4">
            <a href="{{ route('auto_nuevo') }}">
                <button type="button" class="btn btn-success">Agregar</button>
            </a>
        </div>

        <!-- Tabla de autos en contenedor responsivo -->
        <div class="table-responsive">
            <table id="myTable2" class="table table-striped table-bordered table-hover w-100">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Vehículo</th>
                        <th>Modelo</th>
                        <th>Placas</th>
                        <th>Cilindros</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Los datos se cargan aquí -->
                </tbody>
            </table>

            <body>
                <!-- Mensajes de éxito o error -->
                <div class="container mt-4">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @elseif(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>

                <!-- Resto del contenido de la vista -->
            </body>

        </div>
    </div>

    <!-- Inicialización de DataTables -->
    <script type="text/javascript">
        var data = @json($autos);
        $(document).ready(function() {
            $('#myTable2').DataTable({
                data: data,
                pageLength: 5,
                order: [[0, "desc"]],
                language: {
                    processing: "Procesando...",
                    lengthMenu: "Mostrar _MENU_ registros",
                    zeroRecords: "No se encontraron resultados",
                    emptyTable: "Ningún dato disponible en esta tabla",
                    info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                    infoFiltered: "(filtrado de un total de _MAX_ registros)",
                    search: "Buscar:",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                },
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        title: 'Listado de Autos',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    },
                    {
                        extend: 'excel',
                        title: 'Listado de Autos',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Listado de Autos',
                        orientation: 'portrait',
                        pageSize: 'LETTER',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    }
                ]
            });
        });
    </script>

<script>
    $(document).ready(function () {
        const vehicleId = 1; // Cambia esto según el ID del vehículo actual
        $('#vehicleId').text(vehicleId); // Mostrar el ID del vehículo

        // Generar el código QR
        function generateQRCode() {
            $('#qrCodeContainer').empty(); // Limpiar el contenedor
            const url = vehicleId; // Cambia esto por la URL real que quieres codificar

            // Usar jQuery QRCode para generar el código QR
            $('#qrCodeContainer').qrcode({
                text: url,
                width: 300,
                height: 300,
                render: "canvas"
            });
        }

        // Ver el PDF al cargar la página
        $('#downloadPdfBtn').click(function () {
            const { jsPDF } = window.jspdf;

            const pdf = new jsPDF();
            pdf.text('Código QR para el vehículo ID: ' + vehicleId, 10, 10);
            const canvas = document.querySelector('#qrCodeContainer canvas'); // Obtener el canvas del QR
            const imgData = canvas.toDataURL('image/png');

            // Añadir la imagen al PDF
            pdf.addImage(imgData, 'PNG', 10, 20, 100, 100);

            // Guardar el PDF en un Blob y abrirlo en una nueva pestaña
            const pdfBlob = pdf.output('blob');
            const pdfUrl = URL.createObjectURL(pdfBlob);

            // Abrir el PDF en una nueva pestaña
            window.open(pdfUrl);
        });

        // Generar el QR al cargar la página
        generateQRCode();
    });
</script>




</body>
</html>
