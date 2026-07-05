(function () {
  const track = document.getElementById('testimonials-track');
  const indicatorsContainer = document.getElementById('testimonials-indicators');

  if (!track || !indicatorsContainer) return;

  const slides = Array.from(track.children);
  const indicators = Array.from(indicatorsContainer.children);
  const total = slides.length;

  if (total === 0) return;

  let current = 0;
  const INTERVAL_MS = 5000;

  // Set up slides: all hidden except first
  slides.forEach((slide, i) => {
    slide.style.display = i === 0 ? 'block' : 'none';
    slide.style.width = '100%';
    slide.style.flexShrink = '0';
  });

  // Remove flex from track since we're using display toggle
  track.style.display = 'block';

  function updateIndicators() {
    indicators.forEach((dot, i) => {
      dot.classList.toggle('bg-red-600', i === current);
      dot.classList.toggle('bg-gray-300', i !== current);
    });
  }

  function goTo(index) {
    slides[current].style.display = 'none';
    current = (index + total) % total;
    slides[current].style.display = 'block';
    updateIndicators();
  }

  indicators.forEach((dot) => {
    dot.addEventListener('click', () => {
      goTo(parseInt(dot.dataset.index, 10));
    });
  });

  setInterval(() => goTo(current + 1), INTERVAL_MS);
})();
