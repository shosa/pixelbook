<footer class="footer footer-transparent d-print-none">
    <div class="container-xl">
        <div class="row text-center align-items-center flex-row-reverse">

            <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                <ul class="list-inline list-inline-dots mb-0">
                    <li class="list-inline-item status status-dark h5">
                        Copyright &copy; 2024 Pixiod -
                        <a href="mailto:stefano.solidoro@icloud.com" class="link-secondary "><b>SS Software</b></a>.
                        All rights reserved.
                    </li>

                </ul>
            </div>
        </div>
    </div>
</footer>
<script src="<?php echo BASE_URL ?>/dist/js/tabler.min.js?1692870487" defer></script>
<script src="<?php echo BASE_URL ?>/dist/js/demo.min.js?1692870487" defer></script>
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('<?php echo BASE_URL; ?>/service-worker.js')
                .then((registration) => {
                    console.log('Service Worker registrato:', registration.scope);
                })
                .catch((error) => {
                    console.error('Registrazione Service Worker fallita:', error);
                });
        });
    }
</script>
</body>

</html>