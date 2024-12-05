function filterAsentamientos(e) {
    document.querySelectorAll('#asentamiento_id option:not(:first-child)')
        .forEach((option) => {
            if (option.dataset.cp === document.getElementById('cp').value)
                option.classList.remove('d-none');
            else
                option.classList.add('d-none');
        })
}


document.getElementById('nuevo_asentamiento')
    .addEventListener('change', (e) => {
        document.getElementById('nuevo-asentamiento')
            .classList.toggle('d-none');
        document.getElementById('asentamiento-lista')
            .classList.toggle('d-none');
    });

document.getElementById('cp')
    .addEventListener('change', filterAsentamientos);

document.getElementById('curp')
    .addEventListener('keyup', e => {
        e.target.value = e.target.value.toUpperCase();
    })

filterAsentamientos(null);
