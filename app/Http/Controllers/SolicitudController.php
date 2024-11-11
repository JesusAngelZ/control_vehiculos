<?php

namespace App\Http\Controllers;
use App\Models\Auto;
use App\Models\Combustible;
use App\Models\Documentacion_vehiculo;
use App\Models\Kilometraje;
use App\Models\Solicitud_utj;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class SolicitudController extends Controller
{
    // Método para mostrar la página principal (escáner QR)
    public function index()
    {
        return view('solicitud.index'); // Asegúrate de tener la vista correcta para esto
    }


    // Método para mostrar los detalles de un vehículo basado en el ID
    public function show($id)
{
    // Buscar el vehículo por su ID
    $vehiculo = Auto::find($id);
    $documentacion = Documentacion_vehiculo::where('id_auto', $vehiculo->id)->first();

    // Verificar si el vehículo existe
    if (!$vehiculo) {
        return redirect()->back()->with('error', 'Vehículo no encontrado.');
    }

    // Verificar si el vehículo está siendo utilizado en solicitudes
    $solicitudes = Solicitud_utj::where('id_auto', $id)
                                ->where('estado_vehiculo', '=', 'Usando')
                                ->exists();

    // Si el vehículo está siendo utilizado en alguna solicitud, redirigir con mensaje
    if ($solicitudes) {
        return redirect()->back()->with('error', 'Este vehículo está en uso en una solicitud');
    }


    // Si no está en uso, retornar la vista con los detalles del vehículo
    return view('solicitud.index', compact('vehiculo','documentacion'));
}




    // Método para mostrar los detalles de un vehículo basado en el ID
public function verificacion($id)
{
    // Buscar la solicitud por su ID
    $datos = Solicitud_utj::find($id);

    // Verificar si la solicitud existe
    if (!$datos) {
        return redirect()->back()->with('error', 'Solicitud no encontrada.');
    }

    // Verificar que **ambos** campos sean nulos o vacíos
    $verificado = empty($datos->fecha_salida) || empty($datos->fecha_regreso);

    if ($verificado) {
        // Búsqueda de datos del usuario
        $usuario = User::find($datos->id_usuario);
        $profession = "Usuario no encontrado"; // Valor predeterminado

        if ($usuario) {
            switch ($usuario->profession) {
                case "gd":
                    $profession = "Guardia";
                    break;
                case "adm":
                    $profession = "Administrador";
                    break;
                case "tb":
                    $profession = "Empleado";
                    break;
                default:
                    $profession = "Desconocido";
                    break;
            }
        }

        // Búsqueda de datos del auto
        $vehiculo = Auto::find($datos->id_auto);
        $documentacion = Documentacion_vehiculo::where('id_auto', $datos->id_auto)->first();

        if (!$vehiculo) {
            return redirect()->back()->with('error', 'Vehículo no encontrado.');
        }

        // Retornar la vista con los datos de la solicitud, usuario, profesión y vehículo
        return view('solicitud.formulario', compact('vehiculo', 'usuario', 'profession', 'datos','documentacion'));
    } else {
        // Si no se cumple la verificación, redirigir con un mensaje de error
        return redirect()->back()->with('error', 'No se puede acceder a esta solicitud porque ya tiene fechas de salida o regreso.');
    }
}


      public function createAndShowQr(Request $request)
      {
          // Validar el ID del vehículo
          $request->validate([
              'id_auto' => 'required|exists:autos,id',
          ]);

          // Obtener la fecha actual en formato Y-m-d sin la hora
          $hoy = now()->format('Y-m-d');

          // Buscar una solicitud existente para el mismo usuario, vehículo y fecha de hoy
          $existingSolicitud = Solicitud_utj::where('id_auto', $request->id_auto)
              ->where('id_usuario', auth()->id())
              ->whereDate('fecha_solicitud', $hoy)
              ->first();

          // Inicializar el ID de la solicitud
          $solicitudId = null;

          // Verificar si existe una solicitud incompleta (campos críticos en null)
          if ($existingSolicitud && ($existingSolicitud->fecha_regreso === null || $existingSolicitud->motivo === null)) {
              // Si existe y está incompleta, reutilizar la solicitud existente
              $solicitudId = $existingSolicitud->id;
          } else {
              // Crear una nueva solicitud si no existe o la existente está completa
              $solicitud = new Solicitud_utj();
              $solicitud->id_auto = $request->id_auto;
              $solicitud->id_usuario = auth()->id();
              $solicitud->fecha_solicitud = now(); // Asignar la fecha completa actual (con hora)
              $solicitud->motivo = 'Espera de salida';
              $solicitud->estado_vehiculo = 'Disponible';
              $solicitud->save();

              $solicitudId = $solicitud->id; // Guardar el ID de la nueva solicitud creada
          }

          // Segunda verificación: asegurar que solo una solicitud incompleta exista para hoy
          $incompleteSolicitudes = Solicitud_utj::where('id_auto', $request->id_auto)
              ->where('id_usuario', auth()->id())
              ->whereDate('fecha_solicitud', $hoy)
              ->where(function($query) {
                  $query->whereNull('fecha_regreso')
                        ->orWhereNull('motivo');
              })
              ->get();

          // Si existen múltiples solicitudes incompletas, conservar solo la última
          if ($incompleteSolicitudes->count() > 1) {
              foreach ($incompleteSolicitudes->slice(1) as $extraSolicitud) {
                  $extraSolicitud->delete();
              }
          }

          // Si no se ha asignado el ID, verifica el ID de la solicitud existente
          if (!$solicitudId && $existingSolicitud) {
              $solicitudId = $existingSolicitud->id; // Asignar el ID de la solicitud existente si no se creó una nueva
          }

          // Redirigir a la vista que muestra el QR con la solicitud única
          return view('solicitud.scan-qr', ['id' => $solicitudId, 'url' => url("solicitud/" . $solicitudId)]);
      }




    public function historial()
    {
        // Obtener todas las solicitudes
        $solicitudes = Solicitud_utj::all();

        $dataTable = $this->cargarDT($solicitudes);

        // Pasar las solicitudes a la vista
        return view('solicitud.historial', compact('dataTable'));
    }



    public function mi_historial()
    {
        // Obtener todas las solicitudes
        $solicitudes = Solicitud_utj::where('id_usuario', auth()->id())->get();

        //dd($solicitudes);
        $dataTable = $this->cargarDT_Mi_historial($solicitudes);

        // Pasar las solicitudes a la vista
        return view('solicitud.mi-historial', compact('dataTable'));
    }



    public function update(Request $request, string $id)
    {
        // Buscar la solicitud por ID
        $solicitud = Solicitud_utj::find($id);



        // Verificar si la solicitud existe
        if (!$solicitud) {
            Log::error("Solicitud no encontrada con ID: $id");
            return back()->with('error', 'Solicitud no encontrada.');
        }

        // Validar los datos entrantes
        try {
            $validatedData = $request->validate([
                'kilometraje_inicial' => 'required_if:estado_vehiculo,Disponible|integer|min:0',
                'combustible_inicial' => 'required_if:estado_vehiculo,Disponible|integer|min:0',
                'fecha_salida' => 'required_if:estado_vehiculo,Disponible|date',
                'fecha_regreso' => 'required_if:estado_vehiculo,Usando|date',
                'motivo' => 'required_if:estado_vehiculo,Usando|string|max:255',
                'oficio_comision' => 'nullable|string|max:255',
                'kilometraje_final' => 'required_if:estado_vehiculo,Usando|integer|min:0',
                'combustible_final' => 'required_if:estado_vehiculo,Usando|integer|min:0',
                'estado_vehiculo_foto' => 'required_if:estado_vehiculo,Usando|image|mimes:jpeg,png,jpg|max:2048',
            ]);
        } catch (\Exception $e) {
            Log::error("Error en la validación: " . $e->getMessage());
            return back()->with('error', 'Error en la validación de datos.');
        }


        // Obtener o crear el registro en la tabla Kilometraje
        $kilometraje = Kilometraje::firstOrNew([
            'id_auto' => $solicitud->id_auto,
            'id_solicitud' => $solicitud->id // Asegúrate de que `id` sea el campo correcto de la solicitud
        ]);


        $combustible = Combustible::firstOrNew([
            'id_auto' => $solicitud->id_auto,
            'id_solicitud' => $solicitud->id // Asegúrate de que `id` sea el campo correcto de la solicitud
        ]);



        // Log de estado de solicitud
        Log::info("Estado actual de la solicitud: " . $solicitud->estado_vehiculo);

        // Si la solicitud pasa de 'Disponible' a 'Usando'
        if ($solicitud->estado_vehiculo == 'Disponible') {
            $solicitud->fecha_salida = $validatedData['fecha_salida'];
            $solicitud->estado_vehiculo = 'Usando';
            $solicitud->motivo = $validatedData['motivo'];
            $solicitud->oficio_comision = $validatedData['oficio_comision'] ?? null;

            $kilometraje->kilometraje_inicial = $validatedData['kilometraje_inicial'];
            $combustible->combustible_inicial = $validatedData['combustible_inicial'];



        // Si la solicitud pasa de 'Usando' a 'Disponible'
        } elseif ($solicitud->estado_vehiculo == 'Usando') {
            Log::info("Transición de 'Usando' a 'Disponible' para la solicitud ID: $id");

            $solicitud->fecha_regreso = $validatedData['fecha_regreso'];
            $solicitud->estado_vehiculo = 'Disponible';

            // Asegúrate de que los campos estén presentes
            if (isset($validatedData['kilometraje_final']) && isset($validatedData['combustible_final'])) {
                $kilometraje->kilometraje_salida = $validatedData['kilometraje_final'];
                $combustible->combustible_salida = $validatedData['combustible_final'];
            } else {
                Log::warning("Kilometraje final y/o combustible final faltantes para la solicitud ID: $id");
                return back()->with('error', 'Kilometraje final y combustible final son requeridos.');
            }
        }



        // Guardar los cambios en las tablas Kilometraje y Combustible
        $kilometraje->id_auto = $solicitud->id_auto;
        $kilometraje->save();

        $combustible->id_auto = $solicitud->id_auto;
        $combustible->save();


       // dd( $combustible);


          // Manejar la actualización de la foto del estado del vehículo
        if ($request->hasFile('estado_vehiculo_foto')) {
            // Subir la imagen
            $imageData = file_get_contents($request->estado_vehiculo_foto);
            $base64 = base64_encode($imageData);
            $imageType = $request->estado_vehiculo_foto->getClientMimeType();
            $image = 'data:' . $imageType . ';base64,' . $base64;

            // Asignar la foto al campo correspondiente
            $solicitud->estado_vehiculo_foto = $image;
        }
        // Guardar los cambios en la solicitud

       // dd($solicitud->estado_vehiculo_foto);

        $solicitud->update();

        Log::info("Solicitud actualizada exitosamente con ID: $id");

        // Mensaje de éxito
        $message = "Datos actualizados";
        return view('solicitud.success', compact('message'));
    }





    public function cargarDT($consulta)
{
    $solicitudes = [];

    foreach ($consulta as $key => $value) {
            $acciones = '<a href="' . route('solicitud.imprimir', $value['id']) . '" class="btn btn-success me-2" title="Formato PDF">
            <i class="fa-solid fa-file"></i> Descargar PDF
             </a>';

    //Busqueda de datos de usuario
        $usuario = User::find($value['id_usuario']);
        $datos_usuario = $usuario['name'] . ' ' . $usuario['email'];

    //Busqueda de datos de Auto
        $auto = Auto::find($value['id_auto']);

        $datos_auto = $auto['modelo'] . ' ' . $auto['placas'];

      //  dd($auto);


        // Agregar los datos de la solicitud al arreglo
        $solicitudes[$key] = [
            $value['id'],
            $value['fecha_salida'],
            $value['fecha_regreso'],
            $value['motivo'],
            $value['oficio_comision'],
            $value['estado_vehiculo'],
            $datos_usuario,
            $datos_auto,
            $acciones
        ];
    }

    return $solicitudes; // Devuelve el arreglo de solicitudes
}


public function cargarDT_Mi_historial($consulta)
{
    $solicitudes = [];


    foreach ($consulta as $key => $value) {

        $url = $value['id'];

        $mostrarQR = QrCode::size(300)->generate($url);

            $acciones = '

                <div class="btn-acciones">
                    <a href="#qr'.$value['id'].'" class="btn btn-info" data-bs-toggle="modal" title="Código QR" onclick="loadQrCode('.$value['id'].')">

                     <i class="fa-solid fa-file" style="color: white;"></i>

                    </a>
                </div>
                     <!-- Modal para QR -->
            <div class="modal fade" id="qr'.$value['id'].'" tabindex="-1" aria-labelledby="qrModalLabel'.$value['id'].'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- modal-lg ajusta el tamaño en pantallas grandes -->
                    <div class="modal-content" style="width: 100%; max-width: 90vw; max-height: 90vh;"> <!-- Estilos CSS personalizados -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="qrModalLabel'.$value['id'].'">Código QR del Vehículo '.$value['id'].'</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body text-center">
                            <div class="title m-b-md">
                                '.$mostrarQR.'
                            </div>
                        </div>
                    </div>
                </div>
            </div>'

           ;


    //Busqeuda de datos de usuario
        $usuario = User::find($value['id_usuario']);
        $datos_usuario = $usuario['name'] . ' ' . $usuario['email'];

    //Busqueda de datos de Auto
        $auto = Auto::find($value['id_auto']);

        $datos_auto = $auto['modelo'] . ' ' . $auto['placas'];

      //  dd($auto);


        // Agregar los datos de la solicitud al arreglo
        $solicitudes[$key] = [
            $value['id'],
            $value['fecha_salida'],
            $value['fecha_regreso'],
            $value['motivo'],
            $value['oficio_comision'],
            $value['estado_vehiculo'],
            $datos_usuario,
            $datos_auto,
            $acciones
        ];
    }

    return $solicitudes; // Devuelve el arreglo de solicitudes
}


public function imprimirFormato($id)
{
    // Buscar la solicitud por ID
    $solicitud = Solicitud_utj::find($id);

    // Verificar si la solicitud existe
    if (!$solicitud) {
            return redirect()->back()->with('error', 'Solicitud no encontrada.');
    }

        // Búsqueda de datos del usuario
    $usuario = User::find($solicitud->id_usuario);

        // Búsqueda de datos del vehículo
    $auto = Auto::find($solicitud->id_auto);

    $documentacion = Documentacion_vehiculo::where('id_auto',$auto->id)->first();

    $kilometraje = Kilometraje::where('id_auto',$auto->id)->first();

    $combustible = Combustible::where('id_auto', $auto->id)->first();

        // Preparar datos para el PDF
        $data = [
            'solicitud' => $solicitud,
            'usuario' => $usuario,
            'auto' => $auto ,
            'kilometraje' => $kilometraje,
            'combustible' => $combustible,
            'documentacion' => $documentacion,
        ];

    // dd($usuario);
        // Generar el PDF
        $pdf = \PDF::loadView('formato.pdf', $data);


    //  $pdf = \PDF::loadView('formato.pdf');


    // Retornar el PDF para descarga
    // return $pdf->download('formato_' . $id . '.pdf');
    return $pdf->stream('formato_' . $id . '.pdf');
    }

}
