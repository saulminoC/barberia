// Datos de ejemplo, puedes obtener esto desde tu base de datos
const diasDisponibles = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
const horasDisponibles = ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00'];

document.addEventListener('DOMContentLoaded', () => {
    const diaSelect = document.getElementById('dia');
    const horaSelect = document.getElementById('hora');

    // Llenar el select de días
    diasDisponibles.forEach(dia => {
        const option = document.createElement('option');
        option.value = dia;
        option.textContent = dia;
        diaSelect.appendChild(option);
    });

    // Llenar el select de horas
    horasDisponibles.forEach(hora => {
        const option = document.createElement('option');
        option.value = hora;
        option.textContent = hora;
        horaSelect.appendChild(option);
    });
});

// Función para confirmar la cita
function confirmarCita() {
    const dia = document.getElementById('dia').value;
    const hora = document.getElementById('hora').value;
    
    // Aquí puedes agregar la lógica para enviar la cita a la base de datos
    alert(`Cita confirmada para el ${dia} a las ${hora}.`);
}
