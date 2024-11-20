<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/html5-qrcode/html5-qrcode.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Principal</title>
    <link href="{{ asset('css/principal.css') }}" rel="stylesheet">

    <style>
      #reader {
        width: 100%;
        max-width: 500px;
        margin: 0 auto;
        display: none; /* Oculto por defecto */
      }
    </style>
  </head>
  <body>



    <script>
        $(document).ready(function () {
            const urlParams = new URLSearchParams(window.location.search);
            const alertType = urlParams.get('alert');
            const alertMessage = urlParams.get('message');

            if (alertType && alertMessage) {
                Swal.fire({
                    icon: alertType, // 'success' o 'error'
                    title: alertType === 'success' ? '¡Éxito!' : '¡Error!',
                    text: alertMessage
                });
            }
        });
    </script>





    <header style="padding: 40px">
      @include('menu.menu')
    </header>
    <div class="pagina-principal-container">
    @if (Auth::user()->profession == 'tb')

        <div class="pagina-principal">
            <div class="card">
                <div class="header">
                    <div>
                        <h3>ESCANEAR CÓDIGO QR</h3>
                        <h3>Vehículo</h3>
                    </div>
                    <div class="difficulty">
                        <i class="fa fa-qrcode" aria-hidden="true" style="font-size: 40px; color: white;"></i>
                    </div>
                </div>
                <div class="content">
                    <h2>Escanea el código QR del vehículo</h2>
                    <p>Utiliza la cámara de tu teléfono para escanear el código QR del vehículo que deseas utilizar.</p> <!-- Botón para alternar entre Empezar y Detener -->
                    <button id="toggle-scanner-btn" class="button">Empezar</button>

                    <!-- Div para mostrar el lector QR -->
                    <div id="reader"></div>

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
        @endif



        @if (Auth::user()->profession == 'adm')

        <div class="pagina-principal">
            <div class="card">
              <div class="header" style="background-color: #54ccb1;">
                <div>
                  <h3>VER VEHÍCULOS REGISTRADOS</h3>
                  <h3>Consulta</h3>
                </div>
                <div class="difficulty">
                  <i class="fa fa-car" aria-hidden="true" style="font-size: 40px; color: white;"></i>
                </div>
              </div>
              <div class="content">
                <h2>Consulta los vehículos registrados</h2>
                <p>Accede a la lista de vehículos actualmente registrados en la Universidad Tecnológica de Jalisco.</p>
                <a href="{{route('auto')}}"><button class="button">Ver Registros</button></a>
              </div>
            </div>
          </div>

        @endif

        @if(Auth::user()->profession == 'gd')


        <div class="pagina-principal">
            <div class="card">
                <div class="header">
                    <div>
                        <h3>ESCANEAR CÓDIGO QR</h3>
                        <h3>Vehículo</h3>
                    </div>
                    <div class="difficulty">
                        <i class="fa fa-qrcode" aria-hidden="true" style="font-size: 40px; color: white;"></i>
                    </div>
                </div>
                <div class="content">
                    <h2>Escanea el código QR del vehículo</h2>
                    <p>Utiliza la cámara de tu teléfono para escanear el código QR del vehículo que deseas utilizar.</p> <!-- Botón para alternar entre Empezar y Detener -->
                    <button id="toggle-scanner-btn" class="button">Empezar</button>

                    <!-- Div para mostrar el lector QR -->
                    <div id="reader"></div>
                </div>
            </div>
        </div>

        @endif



      </div>

    <script>
        let profession = "{{ Auth::user()->profession }}"; // Pasamos la profesión al JavaScript
        let html5QrcodeScanner;
        let isScanning = false;
        let hasScanned = false; // Bandera para evitar escaneos múltiples

        function onScanSuccess(decodedText, decodedResult) {
            if (hasScanned) return; // Si ya se ha escaneado, no hacer nada más

            console.log(`Scan result: ${decodedText}`, decodedResult);
            hasScanned = true; // Marcar que ya se ha escaneado

            let vehicleId = decodedText.split('/').pop(); // Obtiene el último segmento de la URL

            // Redirigir al usuario a la vista correspondiente según su profesión
            if (profession === 'gd') {
                window.location.href = "{{ url('api/auth/verificacion') }}/" + vehicleId;
            } else if (profession === 'tb') {
                window.location.href = "{{ url('api/auth/solicitud') }}/" + vehicleId;
            }

            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear().then(() => {
                    console.log("Escaneo detenido.");
                    isScanning = false;
                }).catch(err => console.error("Error al detener el escáner: ", err));
            }
        }

        function onScanError(errorMessage) {
            console.log(`Scan error: ${errorMessage}`);
        }

        document.getElementById("toggle-scanner-btn").addEventListener("click", function() {
            const readerElement = document.getElementById("reader");
            const button = document.getElementById("toggle-scanner-btn");

            if (isScanning) {
                html5QrcodeScanner.clear().then(() => {
                    console.log("Escaneo detenido.");
                    readerElement.style.display = "none";
                    button.textContent = "Empezar";
                    isScanning = false;
                    hasScanned = false; // Reiniciar la bandera al detener
                }).catch(err => console.error("Error al detener el escáner: ", err));
            } else {
                readerElement.style.display = "block";
                if (!html5QrcodeScanner) {
                    html5QrcodeScanner = new Html5QrcodeScanner(
                        "reader",
                        {
                            fps: 10,
                            qrbox: function(viewfinderWidth, viewfinderHeight) {
                                const minDimension = Math.min(viewfinderWidth, viewfinderHeight);
                                return { width: minDimension * 0.7, height: minDimension * 0.7 };
                            },
                            aspectRatio: 1.3333
                        }
                    );
                }
                html5QrcodeScanner.render(onScanSuccess, onScanError);
                button.textContent = "Detener";
                isScanning = true;
            }
        });
    </script>




    <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
  </body>
</html>
