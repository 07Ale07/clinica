// Funcionalidad para el modal de imágenes
document.addEventListener('DOMContentLoaded', function() {
    // Modal para imágenes
    const modal = document.createElement('div');
    modal.className = 'modal';
    modal.innerHTML = `
        <span class="close">&times;</span>
        <img class="modal-content" id="modal-img">
    `;
    document.body.appendChild(modal);
    
    // Abrir modal al hacer clic en una imagen
    document.querySelectorAll('td img').forEach(img => {
        img.addEventListener('click', function() {
            modal.style.display = 'flex';
            document.getElementById('modal-img').src = this.src;
        });
    });
    
    // Cerrar modal
    modal.querySelector('.close').addEventListener('click', function() {
        modal.style.display = 'none';
    });
    
    // Cerrar modal al hacer clic fuera de la imagen
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
    
    // Animación de elementos al hacer scroll
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = 1;
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observar elementos con la clase fade-in
    document.querySelectorAll('.fade-in').forEach(el => {
        el.style.opacity = 0;
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
    
    // Efecto de desplazamiento suave para los enlaces de navegación
    document.querySelectorAll('.nav-list a').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Resaltar filas de tabla al pasar el mouse
    const tableRows = document.querySelectorAll('tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transition = 'background-color 0.3s ease';
        });
    });
});