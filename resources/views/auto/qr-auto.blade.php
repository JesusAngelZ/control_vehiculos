<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código QR</title>
    <!-- Incluir jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Incluir jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <!-- Incluir jQuery QRCode -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Incluir Bootstrap CSS (opcional, para estilos de modal) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <center>
            <h1>Código QR para el vehículo ID: <span id="vehicleId"></span></h1>
            <div id="qrCodeContainer" class="text-center"></div>
            <button id="downloadPdfBtn" class="btn btn-success mt-3">Ver PDF</button>
        </center>
    </div>

    <script>
        $(document).ready(function () {
            const vehicleId = {{ $url }}; // Cambia esto según el ID del vehículo actual
            $('#vehicleId').text(vehicleId); // Mostrar el ID del vehículo

            // Generar el código QR
            function generateQRCode() {
                $('#qrCodeContainer').empty(); // Limpiar el contenedor

                // Usar jQuery QRCode para generar el código QR
                $('#qrCodeContainer').qrcode({
                    text: vehicleId,
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
