document.addEventListener('DOMContentLoaded', () => {
  cargarContenido('vista_odontologo_principal.php'); // Carga por defecto
});

function cargarContenido(pagina) {
  fetch(pagina)
    .then(res => res.text())
    .then(html => {
      document.getElementById('contenido').innerHTML = html;
    })
    .catch(err => {
      document.getElementById('contenido').innerHTML = '<p>Error al cargar contenido.</p>';
      console.error(err);
    });
}
