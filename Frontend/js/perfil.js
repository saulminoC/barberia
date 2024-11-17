// Función para cargar el historial de servicios
function cargarHistorialServicios() {
    fetch('/barberia/Backend/cargar_historial.php?id=' + localStorage.getItem('usuarioId'))
        .then(response => {
            console.log(localStorage.getItem('usuarioId'));  // Verifica que esté obteniendo el ID correcto
            if (!response.ok) {
                throw new Error('Error al cargar el historial de servicios');
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                console.error('Error:', data.error);
                alert('Error al cargar el historial de servicios');
            } else {
                const tabla = document.querySelector("#tablaHistorial tbody");
                tabla.innerHTML = "";
        
                let total = 0;
                data.servicios.forEach(servicio => {  // Cambiar a `data.servicios`
                    const fila = document.createElement("tr");
                    fila.innerHTML = `
                        <td>${servicio.servicio}</td>
                        <td>$${servicio.precio}</td>
                    `;
        
                    tabla.appendChild(fila);
                    total += parseFloat(servicio.precio);
                });
        
                document.getElementById("totalGastado").textContent = `$${total.toFixed(2)}`;
            }
        })
        
        .catch(error => {
            console.error('Error al cargar el historial de servicios:', error);
            alert('Error al cargar el historial de servicios');
        });
        const usuarioId = localStorage.getItem("usuarioId");
        if (!usuarioId) {
            alert('No se ha encontrado el ID de usuario. Redirigiendo al inicio de sesión...');
            window.location.href = '/barberia/Frontend/web/login.html';  // Redirige al login si no está logueado
            return;
        }
        
}
