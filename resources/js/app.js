import './bootstrap';

import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';

Alpine.plugin(intersect);

// Auto-advancing image slider used by <x-image-slider>. start()/stop() are
// driven by x-intersect so timers never run for sliders that are off-screen
// or inside a hidden tab panel.
Alpine.data('imageSlider', (count, interval = 4000) => ({
    index: 0,
    timer: null,
    start() {
        if (count < 2 || this.timer) return;
        this.timer = setInterval(() => this.next(), interval);
    },
    stop() {
        clearInterval(this.timer);
        this.timer = null;
    },
    next() { this.index = (this.index + 1) % count; },
    prev() { this.index = (this.index - 1 + count) % count; },
    go(i) { this.index = i; },
    destroy() { this.stop(); },
}));

// Counts a stat up to its final value when it scrolls into view. Takes the
// target number plus any prefix/suffix ("500+" -> 500 and "+") so the markup
// stays the single source of truth, and respects prefers-reduced-motion.
Alpine.data('countUp', (target, decimals = 0, suffix = '', duration = 1600) => ({
    display: (0).toFixed(decimals) + suffix,
    done: false,
    start() {
        if (this.done) return;
        this.done = true;

        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (reduceMotion || duration <= 0) {
            this.display = target.toFixed(decimals) + suffix;
            return;
        }

        const startedAt = performance.now();
        const tick = (now) => {
            const progress = Math.min((now - startedAt) / duration, 1);
            // ease-out cubic so it decelerates into the final number
            const eased = 1 - Math.pow(1 - progress, 3);
            this.display = (target * eased).toFixed(decimals) + suffix;

            if (progress < 1) {
                requestAnimationFrame(tick);
            } else {
                this.display = target.toFixed(decimals) + suffix;
            }
        };
        requestAnimationFrame(tick);
    },
}));

window.Alpine = Alpine;

Alpine.start();