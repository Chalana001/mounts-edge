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

// Conversion events stay dormant until GA4 is configured in the production
// environment. Tracking these high-intent actions gives the hotel a clearer
// picture of which SEO pages create real enquiries, without requiring every
// CTA component to embed analytics-specific JavaScript.
//
// This is the single event vocabulary for the site: generate_lead plus
// contact_phone_click / contact_email_click / contact_whatsapp_click /
// contact_map_click. Links can declare data-conversion="contact_*" as a
// fallback when their href protocol doesn't reveal intent (e.g. a button
// that opens WhatsApp via JS); anything else is not a conversion event.
const trackConversion = (name, parameters = {}) => {
    if (typeof window.gtag === 'function') {
        window.gtag('event', name, parameters);
    }
};

const CONVERSION_EVENTS = [
    'contact_phone_click',
    'contact_email_click',
    'contact_whatsapp_click',
    'contact_map_click',
];

document.addEventListener('click', (event) => {
    if (!(event.target instanceof Element)) return;

    const declared = event.target.closest('[data-conversion]');
    if (declared) {
        const name = declared.getAttribute('data-conversion');
        if (CONVERSION_EVENTS.includes(name)) {
            trackConversion(name, { link_url: declared.href || window.location.href });
        }
        return;
    }

    const link = event.target.closest('a[href]');
    if (!link) return;

    let eventName = null;

    if (link.protocol === 'tel:') {
        eventName = 'contact_phone_click';
    } else if (link.protocol === 'mailto:') {
        eventName = 'contact_email_click';
    } else if (/^https:\/\/wa\.me\//i.test(link.href)) {
        eventName = 'contact_whatsapp_click';
    } else if (/^https:\/\/(www\.)?google\.[^/]+\/maps/i.test(link.href)) {
        eventName = 'contact_map_click';
    }

    if (eventName) {
        trackConversion(eventName, { link_url: link.href });
    }
});

document.addEventListener('submit', (event) => {
    if (!(event.target instanceof HTMLFormElement)) return;

    if (event.target.action.includes('/send-enquiry')) {
        trackConversion('generate_lead', { lead_source: 'website_enquiry_form' });
    }
});
