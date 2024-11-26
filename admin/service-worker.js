const CACHE_NAME = 'app-pixiod-v1.0';
const urlsToCache = [
    '/dist/css/tabler.min.css',
];

// Installa il service worker e cachea le risorse
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                return cache.addAll(urlsToCache);
            })
    );
});

// Gestisce le richieste di rete
self.addEventListener('fetch', (event) => {
    event.respondWith(
        caches.match(event.request)
            .then((response) => {
                // Cache hit - ritorna la risposta dal cache
                if (response) {
                    return response;
                }
                return fetch(event.request);
            })
    );
});