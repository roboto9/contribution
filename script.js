/* Minimal JS: smooth scroll, fade-in on scroll, and accessible focus for anchor */
document.addEventListener('DOMContentLoaded', () => {
  // Smooth scroll for internal anchors
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', (e) => {
      const href = a.getAttribute('href');
      if (href.length > 1) {
        e.preventDefault();
        const el = document.querySelector(href);
        if (el) el.scrollIntoView({behavior:'smooth', block:'start'});
      }
    });
  });

  // Fade-in on scroll
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('in-view');
        observer.unobserve(entry.target);
      }
    });
  }, {threshold: 0.12});

  // Target elements to animate
  const toFade = document.querySelectorAll('.section .container > *:not(.hero-grid), .card, .hero-text, .hero-illus, .support-action');
  toFade.forEach(el => {
    el.classList.add('fade-element');
    observer.observe(el);
  });

  // Make WhatsApp button visually prominent on mobile by adding tint if screen is small
  const wa = document.querySelector('.btn.whatsapp');
  if (wa) {
    const isMobile = window.matchMedia('(max-width:900px)').matches;
    if (isMobile) {
      wa.style.background = 'var(--whatsapp)';
      wa.style.color = '#fff';
      wa.style.boxShadow = '0 8px 24px rgba(37,211,102,0.14)';
    }
  }
});