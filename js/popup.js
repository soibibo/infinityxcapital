(function () {
  const popup = document.getElementById('social-proof-popup');
  const nameEl = document.getElementById('sp-name');
  const countryEl = document.getElementById('sp-country');
  const carEl = document.getElementById('sp-car');
  const statusEl = document.getElementById('sp-status');
  const progressEl = document.getElementById('sp-progress');

  if (!popup || !nameEl || !countryEl || !carEl || !statusEl || !progressEl) return;

  const purchases = [
    { name: 'James O.', country: '🇺🇸 USA', car: 'Tesla Model 3 2024', fee: 299 },
    { name: 'Maria S.', country: '🇨🇦 Canada', car: 'Tesla Model Y 2024', fee: 299 },
    { name: 'Liam B.', country: '🇬🇧 UK', car: 'Tesla Model S 2025', fee: 349 },
    { name: 'Sophie M.', country: '🇦🇺 Australia', car: 'Tesla Model X 2025', fee: 399 },
    { name: 'Noah J.', country: '🇩🇪 Germany', car: 'Tesla Cybertruck 2024', fee: 449 },
    { name: 'Emma L.', country: '🇫🇷 France', car: 'Tesla Model 3 2024', fee: 299 },
    { name: 'Oliver K.', country: '🇳🇱 Netherlands', car: 'Tesla Model Y 2024', fee: 299 },
    { name: 'Isabella R.', country: '🇧🇷 Brazil', car: 'Tesla Model S 2025', fee: 349 }
  ];

  let index = 0;
  const SHOW_DELAY_MS = 0;             // show immediately
  const ROTATE_INTERVAL_MS = 5000;     // 5 seconds per purchase

  function render(purchase) {
    nameEl.textContent = purchase.name;
    countryEl.textContent = purchase.country;
    carEl.textContent = purchase.car;
    statusEl.textContent = `🚗 Car confirmed & dispatched! ($${purchase.fee} fee paid)`;
  }

  function animateProgress() {
    // Reset to 0% instantly
    progressEl.style.transition = 'none';
    progressEl.style.width = '0%';

    // Force reflow so the reset applies immediately
    void progressEl.offsetWidth;

    // Animate to 100% over the rotation interval
    progressEl.style.transition = `width ${ROTATE_INTERVAL_MS}ms linear`;
    progressEl.style.width = '100%';
  }

  function slideIn() {
    popup.style.display = 'block';
    popup.style.opacity = '1';
    popup.style.transform = 'translateX(-120%)';
    popup.style.transition = 'transform 500ms cubic-bezier(0.22, 1, 0.36, 1)';

    requestAnimationFrame(() => {
      popup.style.transform = 'translateX(0)';
    });

    animateProgress();
  }

  function slideOut(callback) {
    popup.style.transition = 'transform 400ms ease-in, opacity 400ms ease-in';
    popup.style.transform = 'translateX(-120%)';
    popup.style.opacity = '0';

    setTimeout(() => {
      popup.style.display = 'none';
      if (callback) callback();
    }, 400);
  }

  function show() {
    slideIn();
  }

  function rotate() {
    // Slide out, swap content, slide back in
    slideOut(() => {
      index = (index + 1) % purchases.length;
      render(purchases[index]);
      slideIn();
    });
  }

  render(purchases[0]);

  setTimeout(() => {
    show();
    setInterval(rotate, ROTATE_INTERVAL_MS);
  }, SHOW_DELAY_MS);
})();
