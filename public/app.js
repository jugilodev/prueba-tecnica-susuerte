const form = document.getElementById('ticketForm');
const message = document.getElementById('message');
const ticketList = document.getElementById('ticketList');

form.addEventListener('submit', async (event) => {

    event.preventDefault();

    const usuario_id = Number(
        document.getElementById('usuario_id').value
    );

    const monto = Number(
        document.getElementById('monto').value
    );

    try {

        const response = await fetch(
            'http://localhost:8000/api/tiquetes',
            {
                method: 'POST',

                headers: {
                    'Content-Type': 'application/json'
                },

                body: JSON.stringify({
                    usuario_id,
                    monto
                })
            }
        );

        const data = await response.json();

        switch (response.status) {

            case 201:

                message.textContent =
                    'Tiquete creado correctamente';

                const item =
                    document.createElement('li');

                item.textContent =
                    `Tiquete #${data.tiquete_id} - Monto: ${monto}`;

                ticketList.appendChild(item);

                form.reset();

                break;

            case 404:

                message.textContent =
                    'Usuario no encontrado';

                break;

            case 422:

                message.textContent =
                    'Saldo insuficiente';

                break;

            case 400:

                message.textContent =
                    'Datos inválidos';

                break;

            default:

                message.textContent =
                    'Error inesperado';

        }

    } catch (error) {

        message.textContent =
            'No fue posible conectar con el servidor';

        console.error(error);
    }
});
