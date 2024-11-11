<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Acceso</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome CSS for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">

    <script src="{{ asset('js/login.js') }}" defer></script>

<style>
    #error-message{
        display: none; /* Ocultar por defecto */
        background-color: #f8d7da;
        color: #721c24;
        padding: 10px;
        border: 1px solid #f5c6cb;
        border-radius: 4px;
        margin-top: 10px;
        text-align: center;
    }

    #error-message_form {
    display: none; /* Ocultar por defecto */
    background-color: #f8d7da;
    color: #721c24;
    padding: 10px;
    border: 1px solid #f5c6cb;
    border-radius: 4px;
    margin-top: 10px;
    padding-left: 15px; /* Añadir espacio a la izquierda para las viñetas */
}

    #error-message_form li {
    margin-bottom: 5px;
    list-style-type: disc;
}
</style>

</head>
<body>

    <div class="module form-module">
        <div class="toggle">
            <i class="fa-solid fa-user"></i>
        </div>
        <div class="form">
            <h2>Accede con tu cuenta</h2>
            <form id="loginForm">
                @csrf
                <input type="email" id="email" name="email" placeholder="Correo electrónico" required />
                <input type="password" id="password" name="password" placeholder="Contraseña" required />
                <button type="submit">Acceder</button>
                <div id="error-message"  style="color: red; display: none;"></div>
            </form>

        </div>

        <div class="form">
            <h2>Crear una cuenta</h2>

            <!-- Formulario de Registro -->
            <form id="registerForm">
                @csrf
                <input type="text" name="name" placeholder="Nombre" required />
                <input type="email" name="email" placeholder="Correo electrónico" required />
                <input type="password" name="password" placeholder="Contraseña" required />
                <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required />
                <button type="submit">Registrarse</button>
                <!-- Mensaje de error -->
                <ul id="error-message_form" style="list-style-type: disc; padding-left: 15px; margin-top: 10px; display: none;"></ul>
            </form>
        </div>

        <div class="cta">
            <a href="">¿Olvidaste la contraseña?</a>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevenir el comportamiento por defecto del formulario

            const formData = new FormData(this);

            fetch('/login', {
                method: 'POST',
                body: formData,
                credentials: 'include' // Para incluir cookies si es necesario
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.error || 'Error desconocido');
                    });
                }
                return response.json();
            })
            .then(data => {
                // Aquí verificamos si se recibió un token
                if (data.access_token) { // Cambia 'token' a 'access_token'
                    // Guardar el token en las cookies (opcional)
                    document.cookie = `jwt_token=${data.access_token}; path=/;`;
                // document.cookie = `jwt_token=${data.access_token}; path=/; max-age=3600`; // 1 hora de vida útil
                    console.log('Token guardado:', data.token);

                    // Redirigir a la vista principal
                    window.location.href = '/api/auth/principal'; // O la ruta deseada
                } else {
                    // Si no hay token, mostrar error
                    const errorMessage = document.getElementById('error-message');
                    errorMessage.innerText = 'Error: No se recibió token.';
                    errorMessage.style.display = 'block'; // Mostrar el mensaje
                }
            })
            .catch(error => {
                const errorMessage = document.getElementById('error-message');
                errorMessage.innerText = error.message;
                errorMessage.style.display = 'block'; // Mostrar el mensaje
            });
        });
    </script>

<script>
    document.getElementById('registerForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);
        const errorMessages = document.getElementById('error-message_form');
        errorMessages.innerHTML = ''; // Limpiar mensajes de error previos

        fetch('/register', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(errorData => {
                    throw new Error(errorData.error || 'Error desconocido');
                });
            }
            return response.json();
        })
        .then(data => {
            // Si el registro fue exitoso, refrescar la página
            if (data.refresh) {
                window.location.reload(); // Refresca la página
            } else {
                console.log(data.message); // Maneja el mensaje si es necesario
            }
        })
        .catch(error => {
            // Mostrar múltiples errores en pantalla
            const errors = error.message.split(','); // Suponiendo que los errores están separados por comas
            errorMessages.style.display = 'block'; // Mostrar contenedor de errores
            errors.forEach(err => {
                const li = document.createElement('li'); // Crear un nuevo elemento de lista para cada error
                li.innerText = err.trim(); // Establecer el texto del error
                errorMessages.appendChild(li); // Agregar el elemento a la lista
            });
        });
    });
</script>


</body>
</html>
