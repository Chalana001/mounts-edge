/**
 * axios used to be imported here and exposed as window.axios, but nothing in
 * this app ever called it -- every form is a standard POST -- and it accounted
 * for roughly 35 KB of the 84 KB JS bundle. Removed rather than shipped unused.
 *
 * If an AJAX call is needed later, prefer fetch() with the CSRF token from the
 * <meta name="csrf-token"> tag already present in layouts/app.blade.php:
 *
 *   fetch(url, {
 *       method: 'POST',
 *       headers: {
 *           'Content-Type': 'application/json',
 *           'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
 *           'X-Requested-With': 'XMLHttpRequest',
 *       },
 *       body: JSON.stringify(data),
 *   });
 */

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
