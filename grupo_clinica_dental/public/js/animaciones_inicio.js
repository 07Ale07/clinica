document.addEventListener("DOMContentLoaded", () => {
    const hero = document.querySelector('.hero-content');
    const features = document.querySelectorAll('.feature');
    const buttons = document.querySelectorAll('.btn');
  
    // Mostrar hero al cargar
    setTimeout(() => {
      hero.classList.add('visible');
    }, 200);
  
    // Observer para las características al hacer scroll
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, {
      threshold: 0.3
    });
  
    features.forEach(f => {
      f.classList.add('hidden');
      observer.observe(f);
    });
  
    // Animaciones al pasar el mouse por los botones
    buttons.forEach(btn => {
      btn.addEventListener('mouseenter', () => {
        btn.style.transform = "scale(1.05)";
      });
      btn.addEventListener('mouseleave', () => {
        btn.style.transform = "scale(1)";
      });
    });
  
    // Detectar scroll para animar el hero-content
    let lastScroll = 0;
    window.addEventListener('scroll', () => {
      const currentScroll = window.pageYOffset;
      if (currentScroll > lastScroll + 10) {
        hero.classList.remove('scrolled-up');
        hero.classList.add('scrolled-down');
      } else if (currentScroll < lastScroll - 10) {
        hero.classList.remove('scrolled-down');
        hero.classList.add('scrolled-up');
      }
      lastScroll = currentScroll;
    });
  });
  