<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Solicitudes</title>

    <!-- Estilos necesarios para DataTables y los botones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.1.1/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" rel="stylesheet"> <!-- Nuevo para responsive -->
    <link href="{{ asset('css/tabla.css') }}" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

    <!-- Scripts de jQuery y DataTables -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script> <!-- Nuevo para responsive -->
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script> <!-- Nuevo para responsive -->

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
            <h2 class="display-4">Historial de mis solicitudes</h2>
        </div>
    </section>

    <div class="container mt-5">
        <table id="historialTable" class="table table-striped table-bordered table-hover" style="width:100%">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Fecha salida</th>
                    <th>Fecha regreso</th>
                    <th>Motivo</th>
                    <th>Oficio comisión</th>
                    <th>Estado vehículo</th>
                    <th>Usuario</th>
                    <th>Auto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data se llenará con JavaScript -->
            </tbody>
        </table>
    </div>

    <script type="text/javascript">
        var data = @json($dataTable);
        $(document).ready(function() {
            $('#historialTable').DataTable({
                "data": data,
                "pageLength": 5,
                "order": [[0, "desc"]],
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sSearch": "Buscar:",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    }
                },
                responsive: true, // Activa la extensión responsive
                dom: '<"col-xs-3"l><"col-xs-5"B><"col-xs-4"f>rtip',
                buttons: [
                    { extend: 'copy', title: 'Historial de solicitudes', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 7, 8] } },
                    { extend: 'excel', title: 'Historial de solicitudes', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 7, 8] } },
                    { extend: 'pdfHtml5', title: 'Historial de solicitudes', orientation: 'portrait', pageSize: 'LETTER', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 7, 8] } }
                ]
            });
        });
    </script>
</body>
</html>
