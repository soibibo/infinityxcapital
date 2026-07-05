<div class="inline-flex items-center gap-6 mt-8 bg-white rounded-2xl px-8 py-4 shadow-md border border-gray-100 mx-auto max-w-lg">
  <div class="flex items-center gap-2 text-red-600">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock w-5 h-5">
      <circle cx="12" cy="12" r="10"></circle>
      <polyline points="12 6 12 12 16 14"></polyline>
    </svg>
    <span class="font-bold text-sm">Event ends in:</span>
  </div>
  <div class="flex items-center gap-2" id="countdown-display">
    <div class="flex items-center gap-2">
      <div class="text-center">
        <div id="cd-hours" class="text-2xl font-black text-gray-900 w-12">11</div>
        <div class="text-xs text-gray-400">HRS</div>
      </div>
    </div>
    <div class="flex items-center gap-2"><span class="text-red-600 font-bold text-xl">:</span>
      <div class="text-center">
        <div id="cd-minutes" class="text-2xl font-black text-gray-900 w-12">42</div>
        <div class="text-xs text-gray-400">MIN</div>
      </div>
    </div>
    <div class="flex items-center gap-2"><span class="text-red-600 font-bold text-xl">:</span>
      <div class="text-center">
        <div id="cd-seconds" class="text-2xl font-black text-gray-900 w-12">33</div>
        <div class="text-xs text-gray-400">SEC</div>
      </div>
    </div>
  </div>
  <div class="flex items-center gap-2 text-gray-600">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users w-4 h-4">
      <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
      <circle cx="9" cy="7" r="4"></circle>
      <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
      <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
    </svg>
    <span id="cd-participants" class="text-sm font-medium">12,847</span>
    <span class="text-sm text-gray-400">participants</span>
  </div>
</div>

@push('scripts')
<script>
  (function() {
    // Countdown timer — starts at 11:42:33 and ticks down
    // Uses localStorage so it persists across page loads (won't reset on refresh)
    const STORAGE_KEY = 'tesla_countdown';

    function getStoredTime() {
      try {
        const stored = localStorage.getItem(STORAGE_KEY);
        if (stored) {
          const parts = stored.split(':');
          return { h: parseInt(parts[0]), m: parseInt(parts[1]), s: parseInt(parts[2]) };
        }
      } catch (e) {}
      return null;
    }

    function getStartTime() {
      // First visit: 11h 42m 33s = 11*3600 + 42*60 + 33 = 42153 seconds
      const stored = getStoredTime();
      if (stored) return stored;
      return { h: 11, m: 42, s: 33 };
    }

    function saveTime(h, m, s) {
      try {
        localStorage.setItem(STORAGE_KEY, h + ':' + m + ':' + s);
      } catch (e) {}
    }

    let { h, m, s } = getStartTime();

    // Convert to total seconds
    let totalSec = h * 3600 + m * 60 + s;

    function pad(n) {
      return n.toString().padStart(2, '0');
    }

    function updateDisplay() {
      const hoursEl = document.getElementById('cd-hours');
      const minsEl = document.getElementById('cd-minutes');
      const secsEl = document.getElementById('cd-seconds');
      if (!hoursEl || !minsEl || !secsEl) return;

      const hh = Math.floor(totalSec / 3600);
      const mm = Math.floor((totalSec % 3600) / 60);
      const ss = totalSec % 60;

      hoursEl.textContent = pad(hh);
      minsEl.textContent = pad(mm);
      secsEl.textContent = pad(ss);

      saveTime(hh, mm, ss);
    }

    // Animate the participant counter
    function animateParticipants() {
      const el = document.getElementById('cd-participants');
      if (!el) return;
      let count = parseInt(el.textContent.replace(/,/g, '')) || 12847;
      setInterval(() => {
        // Increment slowly — adds ~1-3 per tick
        count += Math.floor(Math.random() * 2) + 1;
        el.textContent = count.toLocaleString();
      }, 30000); // every 30 seconds
    }

    // Tick down every second, but don't go below 0
    setInterval(() => {
      if (totalSec > 0) {
        totalSec--;
        updateDisplay();
      }
    }, 1000);

    // Initial render
    updateDisplay();
    animateParticipants();
  })();
</script>
@endpush