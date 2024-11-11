<link href="{{asset('css/menu.css')}}" rel="stylesheet">

<style>
    .user-role {

        display: flex; /* Flex para centrar */
        justify-content: center; /* Centrar horizontalmente */
        flex-grow: 1; /* Permitir que crezca y ocupe espacio disponible */
        font-size: 18px;
        color: #333; /* Color del texto del rol */
    }


    .role-label {
        background-color: #e2e3e5; /* Fondo gris claro para el rol */
        border-radius: 5px;
        padding: 5px 10px;
        display: inline-block;
    }

</style>

<div class="custom-menu">
    <header class="header">
        <div class="container">
            <nav class="navbar">
                <h1><a href="{{ route('principal') }}" class="brand">UTJ</a></h1>

                <!-- Mostrar el rol del usuario -->
                <div class="user-role">
                    @if (Auth::check())
                        @switch(Auth::user()->profession)
                            @case('adm')
                                <p class="role-label">Administrador</p>
                                @break
                            @case('gd')
                                <p class="role-label">Guardia</p>
                                @break
                            @case('tb')
                                <p class="role-label">Trabajador</p>
                                @break
                        @endswitch
                    @endif
                </div>

                <button type="button" class="burger" id="burger">
                    <span class="burger-line"></span>
                    <span class="burger-line"></span>
                    <span class="burger-line"></span>
                </button>
                <span class="overlay" id="overlay"></span>
                <div class="menu" id="menu">
                    <ul class="menu-block">
                        @if (Auth::check())
                            <li class="menu-item"><a class="menu-link" href="{{ route('principal') }}">Inicio</a></li>
                            <!-- Opciones específicas según el tipo de usuario -->
                            @if (Auth::user()->profession == 'adm')
                                <li class="menu-item"><a class="menu-link" href="{{ route('auto') }}">Ver autos</a></li>
                                <li class="menu-item"><a class="menu-link" href="{{ route('solicitudes.historial') }}">Ver historial</a></li>
                            @elseif (Auth::user()->profession == 'gd')
                              <!--  <li class="menu-item"><a class="menu-link" href="#">Gestionar Documentos</a></li>  -->
                            @elseif (Auth::user()->profession == 'tb')
                                <li class="menu-item"><a class="menu-link" href="{{ route('solicitudes.mi_historial') }}">Ver mi historial</a></li>
                            @endif

                            <!-- Opción de cerrar sesión -->
                            <li class="menu-item">
                                <button id="logoutButton" class="menu-link" style="background:none; border:none; color:black; cursor:pointer;">
                                    Cerrar sesión
                                </button>
                            </li>
                        @else
                            <!-- Opciones para usuarios no autenticados -->
                            <li class="menu-item"><a class="menu-link" href="#">Iniciar sesión</a></li>
                        @endif
                    </ul>
                </div>
            </nav>
        </div>
    </header>
</div>


<script>
    const burgerMenu = document.getElementById("burger");
    const navbarMenu = document.getElementById("menu");

    // Show and Hide Navbar Menu
    burgerMenu.addEventListener("click", () => {
        burgerMenu.classList.toggle("is-active");
        navbarMenu.classList.toggle("is-active");

        if (navbarMenu.classList.contains("is-active")) {
            navbarMenu.style.maxHeight = navbarMenu.scrollHeight + "px";
        } else {
            navbarMenu.removeAttribute("style");
        }
    });
</script>


<script>
    document.getElementById('logoutButton').addEventListener('click', function() {
        fetch('/api/auth/logout', {
            method: 'POST', // Asegúrate de que sea POST
            headers: {
                'Content-Type': 'application/json',
                // Agrega más encabezados si es necesario (por ejemplo, Authorization)
            },
            credentials: 'include' // Incluye cookies en la solicitud
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data.message); // Maneja la respuesta
            // Opcional: redirigir al usuario a la página de inicio o login
            window.location.href = '/'; // Cambia a la ruta que desees
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    });
</script>
