// fitur interaktif seperti search, sort, atau pagination
window.addEventListener('DOMContentLoaded', event => {

    const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple);
    }
});
