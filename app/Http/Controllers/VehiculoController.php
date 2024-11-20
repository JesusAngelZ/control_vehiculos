<?php

namespace App\Http\Controllers;

use App\Models\Auto;
use App\Models\Documentacion_vehiculo;
use App\Models\Solicitud;
use App\Models\Solicitud_utj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class VehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$autos = Auto::where('activo', '=', 1)->get();
        $autos = Auto::all();
        $dataTable = $this->cargarDT($autos);

        //return view('auto.index');
        return view('auto.index')->with('autos', $dataTable);
    }


    public function index_nuevo_auto(){
        return view('auto.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos
        $validatedData = $request->validate([
            'VehiculoNombre' => 'required|string|max:50',
            'Modelo' => 'required|string|max:50',
            'Placas' => 'required|string|max:50',
            'Cilindros' => 'required|integer|min:1|max:20',
            'vehiculoFoto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'tarjeta_circulacion' => 'required|string|max:10',
            'poliza_seguro' => 'required|string|max:10',
        ]);

        // Subir la imagen
        if ($request->hasFile('vehiculoFoto')) {
            $imageData = file_get_contents($request->vehiculoFoto);
            $base64 = base64_encode($imageData);
            $imageType = $request->vehiculoFoto->getClientMimeType();
            $image = 'data:' . $imageType . ';base64,' . $base64; // Formato: data:image/jpeg;base64,...
        } else {
            $image = null; // Manejo de caso en el que no hay imagen
        }

        // Crear el nuevo registro en Auto y obtener el objeto recién creado
        $auto = Auto::create([
            'vehiculo' => $validatedData['VehiculoNombre'],
            'modelo' => $validatedData['Modelo'],
            'placas' => $validatedData['Placas'],
            'cilindros' => $validatedData['Cilindros'],
            'foto' => $image,
        ]);

        // Crear el registro en Documentacion_vehiculo usando el id del auto recién creado
        Documentacion_vehiculo::create([
            'id_auto' => $auto->id,
            'tarjeta_circulacion' => $validatedData['tarjeta_circulacion'],
            'poliza_seguro' => $validatedData['poliza_seguro'],
        ]);

        // Retornar respuesta JSON
        return response()->json(['message' => 'Vehículo agregado exitosamente']);
    }




    public function cargarDT($consulta)
        {
            $autos = [];

            foreach ($consulta as $key => $value) {
                $editar = route('autos.edit', $value['id']);
                $borrar = route('autos.borrar', $value['id']);
                $mostrarpdf = route('autos.generarPdf', $value['id']);
               // $mostrarQR = QrCode::size(300)->generate("" . (string)$value['id']);

                // Genera la URL de la vista del vehículo
                $url = $value['id'];

                // Genera el código QR con el enlace que lleva a la vista del vehículo
                $mostrarQR = QrCode::size(300)->generate($url);



             //   $qr = route('autos.qr', $value['id']);
                $acciones = '';

                // Aquí se definen las acciones para cada auto
                $acciones = '
                <div class="btn-acciones">
                    <a href="'.$editar.'" class="btn btn-success me-2" title="Editar">
                        <i class="far fa-edit"></i>
                    </a>
                    <button class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#borrar'.$value['id'].'" title="Eliminar">
                        <i class="far fa-trash-alt"></i>
                    </button>
                    <a href="#qr'.$value['id'].'" class="btn btn-info" data-bs-toggle="modal" title="Código QR" onclick="loadQrCode('.$value['id'].')">
                        <i class="fa fa-qrcode" style="color: white;"></i>
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
                            <br>
                              <a href="'.$mostrarpdf.'"  class="btn btn-success" id="downloadPdf'.$value['id'].'" download>
                                Descargar PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>


                <!-- Modal para confirmación de borrado -->
                <div class="modal fade" id="borrar'.$value['id'].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down"> <!-- Ocupa toda la pantalla en dispositivos pequeños -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">¿Seguro que deseas eliminar este auto?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-primary mb-0"> <!-- mb-0 elimina el margen inferior del párrafo -->
                                    <strong>ID:</strong> '.$value['id'].'
                                </p>
                                <p class="text-dark mb-0">
                                    <strong>Vehículo:</strong> '.$value['vehiculo'].'
                                </p>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <form action="'.$borrar.'" method="POST" style="display:inline;">
                                    '.csrf_field().'
                                    '.method_field('DELETE').'
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>';

                // Agrega los datos del auto al arreglo autos
                $autos[$key] = [
                    $value['id'],
                    $value['vehiculo'],
                    $value['modelo'],
                    $value['placas'],
                    $value['cilindros'],
                    $acciones // Las acciones con los botones
                ];
            }

            return $autos; // Devuelve el arreglo de autos
        }




        public function generarPdf($id)
        {
            // Encuentra el auto por su ID
            $auto = Auto::find($id);

            // Verifica si el auto existe
            if (!$auto) {
                return response()->json(['error' => 'Auto no encontrado'], 404);
            }

            $url = $auto->id; // Cambia esto según tus necesidades
            return view('auto.qr-auto')->with('url', $url);

        }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
  //
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
{
    $auto = Auto::find($id);
    $documentacion = Documentacion_vehiculo::where('id_auto', $id)->first();
    if (!$auto) {
        return redirect()->route('autos.index')->with('error', 'Vehículo no encontrado.');
    }
    return view('auto.update', compact('auto','documentacion')); // Pasa el objeto auto a la vista
}


    /**
     * Update the specified resource in storage.
     */
/**
 * Update the specified resource in storage.
 */
public function update(Request $request, string $id)
{
    $auto = Auto::find($id);

    // Verificar si el vehículo existe
    if (!$auto) {
        return redirect()->route('auto')->with('error', 'Vehículo no encontrado.');
    }

    // Obtener la documentación asociada al vehículo
    $documentacion = Documentacion_vehiculo::where('id_auto', $id)->first();

    // Validar los datos
    $validatedData = $request->validate([
        'VehiculoNombre' => 'required|string|max:50',
        'Modelo' => 'required|string|max:50',
        'Placas' => 'required|string|max:50',
        'Cilindros' => 'required|integer|min:1|max:20',
        'vehiculoFoto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'tarjeta_circulacion' => 'required|string|max:10',
        'poliza_seguro' => 'required|string|max:10',
    ]);

    // Subir la imagen solo si hay un archivo nuevo
    if ($request->hasFile('vehiculoFoto')) {
        $imageData = file_get_contents($request->vehiculoFoto);
        $base64 = base64_encode($imageData);
        $imageType = $request->vehiculoFoto->getClientMimeType();
        $image = 'data:' . $imageType . ';base64,' . $base64;
        $auto->foto = $image; // Guardar la nueva imagen en la base de datos
    }

    // Actualizar los datos del vehículo
    $auto->vehiculo = $validatedData['VehiculoNombre'];
    $auto->modelo = $validatedData['Modelo'];
    $auto->placas = $validatedData['Placas'];
    $auto->cilindros = $validatedData['Cilindros'];
    $auto->update(); // Guarda los cambios en Auto

    // Verificar si existe la documentación para el vehículo antes de actualizar
    if ($documentacion) {
        $documentacion->tarjeta_circulacion = $validatedData['tarjeta_circulacion'];
        $documentacion->poliza_seguro = $validatedData['poliza_seguro'];
        $documentacion->update(); // Guarda los cambios en Documentacion_vehiculo
    }

    return redirect()->route('auto', ['alert' => 'success', 'message' => 'Vehículo actualizado exitosamente']);

   // return redirect()->route('auto')->with('success', 'Vehículo actualizado exitosamente.');
}





    /**
     * Remove the specified resource from storage.
     */

     public function destroy(string $id)
     {
         $auto = Auto::find($id);
         $existeSolicitud = Solicitud_utj::where('id_auto', $id)->exists();

         if ($existeSolicitud) {
             // Redirige con parámetros en la URL
             return redirect()->route('auto', ['alert' => 'error', 'message' => 'No es posible eliminar el vehículo porque tiene solicitudes asociadas.']);
         }

         if ($auto) {
             Documentacion_vehiculo::where('id_auto', $id)->delete();
             $auto->delete();
             // Redirige con parámetros en la URL
             return redirect()->route('auto', ['alert' => 'success', 'message' => 'Vehículo eliminado exitosamente.']);
         }

         // Redirige con parámetros en la URL
         return redirect()->route('auto', ['alert' => 'error', 'message' => 'Vehículo no encontrado.']);
     }







}
