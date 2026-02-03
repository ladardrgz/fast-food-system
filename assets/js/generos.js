document.addEventListener('DOMContentLoaded', async () => {
    const generoSelect = document.getElementById('genero');
    if (!generoSelect) return;

    try {
        const response = await fetch('index.php?controller=genero&action=obtener');
        if (!response.ok) throw new Error('Error al obtener géneros');

        const data = await response.json();

        // Validación de tipo de respuesta
        if (Array.isArray(data) && data.length > 0) {
            data.forEach(genero => {
                const option = document.createElement('option');
                option.value = genero.id_genero;
                option.textContent = genero.nombre_genero;
                generoSelect.appendChild(option);
            });
        } else {
            const option = document.createElement('option');
            option.disabled = true;
            option.textContent = 'No hay géneros disponibles';
            generoSelect.appendChild(option);
        }

    } catch (error) {
        console.error('Error al cargar géneros:', error);
        const option = document.createElement('option');
        option.disabled = true;
        option.textContent = 'Error al cargar géneros';
        generoSelect.appendChild(option);
    }
});
