
function checkAuth() {
    const token = localStorage.getItem('token');

    if (token) {
        // Verifica si el token ha expirado
        const payload = JSON.parse(atob(token.split('.')[1]));
        const exp = payload.exp * 1000; // Convertir a milisegundos

        if (Date.now() >= exp) {
            // El token ha expirado
            localStorage.removeItem('token');
            window.location.href = '/login'; // Redirigir al login
        }
    } else {
        // No hay token, redirigir al login
        window.location.href = '/login';
    }
}

// Llama a la función en cada carga de página
checkAuth();
