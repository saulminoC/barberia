document.addEventListener("DOMContentLoaded", function() {
    // Cargar disponibilidad de citas
    cargarDisponibilidad();

    // Cuando se selecciona un día, actualizar las horas disponibles
    document.getElementById("dia").addEventListener("change", function() {
        cargarHorasDisponibles();
    });
});

// Función para cargar disponibilidad (días y horas) desde el backend
function cargarDisponibilidad() {
    fetch('/barberia/Backend/cargar_disponibilidad.php')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            cargarDias(data.disponibilidades);
        } else {
            console.error("Error al cargar disponibilidad:", data.message);
        }
    })
    .catch(error => {
        console.error("Error al cargar disponibilidad:", error);
    });
}

// Función para cargar los días disponibles en el select
function cargarDias(disponibilidades) {
    const diaSelect = document.getElementById("dia");
    disponibilidades.forEach(disponibilidad => {
        const option = document.createElement("option");
        option.value = disponibilidad.dia;
        option.textContent = disponibilidad.dia;
        diaSelect.appendChild(option);
    });
}

// Función para cargar las horas disponibles según el día seleccionado
function cargarHorasDisponibles() {
    const diaSeleccionado = document.getElementById("dia").value;
    const horaSelect = document.getElementById("hora");

    // Limpiar las opciones anteriores
    horaSelect.innerHTML = '<option value="" disabled selected>--Seleccionar hora--</option>';

    if (!diaSeleccionado) {
        return; // Si no se ha seleccionado un día, no hacer nada
    }

    // Filtrar las horas disponibles para el día seleccionado
    fetch(`/barberia/Backend/cargar_horas_disponibles.php?dia=${diaSeleccionado}`)
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            data.horas.forEach(hora => {
                const option = document.createElement("option");
                option.value = hora;
                option.textContent = hora;
                horaSelect.appendChild(option);
            });
        } else {
            console.error("Error al cargar horas:", data.message);
        }
    })
    .catch(error => {
        console.error("Error al cargar horas:", error);
    });
}
console.log(dia);  // Esto imprimirá la fecha seleccionada en la consola


// Función para confirmar la cita
function confirmarCita() {
    const servicio = document.getElementById("servicio").value;
    const dia = document.getElementById("dia").value;
    const hora = document.getElementById("hora").value;

    // Verificar que todos los campos estén llenos
    if (!servicio || !dia || !hora) {
        alert("Por favor, completa todos los campos.");
        return;
    }

    // Obtener el ID del usuario desde localStorage
    //const usuario_id = localStorage.getItem('id_user');
    var usuario_id = localStorage.getItem('usuarioId');

    console.log('Usuario ID desde localStorage: ', usuario_id);

    if (!usuario_id) {
        document.getElementById('mensaje-advertencia').style.display = 'block'; // Mostrar advertencia si no está logueado
        return;
    }

    // Preparar los datos para enviar al servidor
    const citaData = {
        servicio: servicio,
        dia: dia,
        hora: hora,
        usuario_id: usuario_id
    };

    // Enviar los datos mediante AJAX
    fetch('/barberia/Backend/guardar_cita.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(citaData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Cita agendada exitosamente.");
        } else {
            alert("Error al agendar la cita: " + data.message);
        }
    })
    .catch(error => {
        console.error("Error al agendar la cita:", error);
    });
}
