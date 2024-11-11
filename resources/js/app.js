import './bootstrap';

// Importa DataTables
import DataTable from 'datatables.net-dt';
import { Html5QrcodeScanner } from 'html5-qrcode';


// Inicializa DataTables sobre cualquier tabla con el ID #myTable
let table = new DataTable('#myTable');

// O si necesitas inicializar varias tablas:
$(document).ready(function() {
    $('#myTable').DataTable();
});


