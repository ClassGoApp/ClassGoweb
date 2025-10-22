
 // JS: genera N cards dentro del contenedor
document.addEventListener('DOMContentLoaded', () => {
  const container = document.getElementById('content-card');
  const numCards = 9; // por ejemplo, 3x3

  for (let i = 1; i <= numCards; i++) {
    const card = document.createElement('div');
    card.classList.add('card');
    container.appendChild(card);
  }
});

console.log('blog.js cargado correctamente');