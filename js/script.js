// Interações básicas — aqui você pode ligar formulários, analytics, etc.
document.addEventListener('DOMContentLoaded', () => {
    // exemplo: pausar ticker ao passar o mouse
    const ticker = document.querySelector('.ticker-track');
    if (ticker){
      ticker.addEventListener('mouseenter', ()=> ticker.style.animationPlayState = 'paused');
      ticker.addEventListener('mouseleave', ()=> ticker.style.animationPlayState = 'running');
    }
  });
  