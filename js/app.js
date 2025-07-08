// PARTICLES JS CONFIGURAÇÃO
particlesJS('particles-js',
  {
    "particles": {
      "number": { "value": 80, "density": { "enable": true, "value_area": 800 } },
      "color": { "value": "#ffffff" },
      "shape": {
        "type": "circle",
        "stroke": { "width": 0, "color": "#ffffff" },
        "polygon": { "nb_sides": 5 },
        "image": { "src": "img/github.svg", "width": 100, "height": 100 }
      },
      "opacity": { "value": 0.5, "random": false },
      "size": { "value": 5, "random": true },
      "line_linked": { "enable": true, "distance": 150, "color": "#ffffff", "opacity": 0.4, "width": 1 },
      "move": { "enable": true, "speed": 3, "direction": "none", "random": false, "straight": false, "out_mode": "out" }
    },
    "interactivity": {
      "detect_on": "canvas",
      "events": {
        "onhover": { "enable": true, "mode": "repulse" },
        "onclick": { "enable": true, "mode": "push" },
        "resize": true
      },
      "modes": {
        "grab": { "distance": 400, "line_linked": { "opacity": 1 } },
        "bubble": { "distance": 400, "size": 40, "duration": 2, "opacity": 8, "speed": 3 },
        "repulse": { "distance": 200 },
        "push": { "particles_nb": 4 },
        "remove": { "particles_nb": 2 }
      }
    },
    "retina_detect": true
  }
);

document.addEventListener("DOMContentLoaded", () => {
  // TOGGLE MENU LATERAL (SIDEBAR)
  const hamburger = document.querySelector('.hamburger');
  const sidebar = document.querySelector('.sidebar');

  if (hamburger && sidebar) {
    hamburger.addEventListener("click", () => {
      const visivel = sidebar.style.transform === 'translateX(0%)';
      sidebar.style.transform = visivel ? 'translateX(-100%)' : 'translateX(0%)';
    });
  }

  // ANIMAÇÕES NAS SEÇÕES
  const secoes = document.querySelectorAll('.primeira-secao');
  if (secoes.length > 0) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visivel');
        } else {
          entry.target.classList.remove('visivel');
        }
      });
    }, { threshold: 0.2 });

    secoes.forEach(secao => observer.observe(secao));
  }

  // FORMULÁRIO E MODAL
  const form = document.getElementById('formContato');
  const modal = document.getElementById('modalMensagem');
  const textoModal = document.getElementById('textoModal');
  const fecharModal = document.getElementById('fecharModal');

  if (form && modal && textoModal && fecharModal) {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      const formData = new FormData(form);

      try {
        const response = await fetch(form.action, {
          method: form.method,
          body: formData
        });

        const data = await response.json();

        textoModal.textContent = data.message;
        modal.style.display = 'flex';
        if (response.ok && data.success) form.reset();

      } catch (error) {
        textoModal.textContent = "Erro na conexão. Tente novamente.";
        modal.style.display = 'flex';
        console.error(error);
      }
    });

    fecharModal.addEventListener('click', () => {
      modal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
      if (event.target === modal) {
        modal.style.display = 'none';
      }
    });
  }
});
