<?php require("config/config.php");
include("components/header.php") ?>
<div class="page-wrapper">
  <!-- Page header -->
  <div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
            Panoramica
          </div>
          <h2 class="page-title">
            Dashboard
          </h2>
        </div>

      </div>
    </div>
  </div>
  <!-- Page body -->
  <div class="page-body">
    <div class="container-xl">
      <div class="row row-deck row-cards">
        <div class="col-sm-6 col-lg-4">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="subheader">VENDITE</div>
                <div class="ms-auto lh-1">
                  <div class="dropdown">
                    <a class="dropdown-toggle status status-rss" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                      aria-expanded="false" id="sales-period" data-card-dropdown="vendite">Ultimi 7 giorni</a>
                    <div class="dropdown-menu dropdown-menu-end">
                      <a class="dropdown-item active" href="#" data-period="Ultimi 7 giorni">Ultimi 7 giorni</a>
                      <a class="dropdown-item" href="#" data-period="Ultimi 30 giorni">Ultimi 30 giorni</a>
                      <a class="dropdown-item" href="#" data-period="Ultimi 3 mesi">Ultimi 3 mesi</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="h1 mb-3" id="sales-count">0</div>
              <div class="d-flex mb-2">
                <div>Conversion rate</div>
                <div class="ms-auto">
                  <span class="text-green d-inline-flex align-items-center lh-1" id="conversion-rate">0%</span>
                </div>
              </div>
              <div class="progress ">
                <div class="progress-bar bg-rss" id="conversion-bar" style="width: 0%" role="progressbar"
                  aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
            <div class="card-footer pt-1 pb-1 subheader">Statistiche di vendite concluse nel tempo
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-lg-4">
          <div class="card ">
            <div class="card-body ">
              <div class="d-flex align-items-center">
                <div class="subheader">GUADAGNI</div>
                <div class="ms-auto lh-1">
                  <div class="dropdown">
                    <a class="dropdown-toggle status status-instagram" href="#" data-bs-toggle="dropdown"
                      aria-haspopup="true" aria-expanded="false" id="revenue-period"
                      data-card-dropdown="guadagni">Ultimi 3 mesi</a>
                    <div class="dropdown-menu dropdown-menu-end">
                      <a class="dropdown-item " href="#" data-period="Ultimi 7 giorni">Ultimi 7 giorni</a>
                      <a class="dropdown-item" href="#" data-period="Ultimi 30 giorni">Ultimi 30 giorni</a>
                      <a class="dropdown-item active" href="#" data-period="Ultimi 3 mesi">Ultimi 3 mesi</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="d-flex align-items-baseline">
                <div class="h1 mb-3 me-2" id="revenue-amount">AED 0.00</div>
                <div class="me-auto">
                  <span class="text-green d-inline-flex align-items-center lh-1" id="conversion-eur">€ 0</span>
                </div>
              </div>

            </div>
            <div id="chart-revenue-bg" class="chart-sm p-0"></div>
            <div class="card-footer pt-1 pb-1 subheader">Statistiche di guadagni nel tempo</div>
          </div>
        </div>

        <div class="col-sm-6 col-lg-4">
          <div class="card ">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="subheader">PRENOTAZIONI</div>
                <div class="ms-auto lh-1">
                  <div class="dropdown">
                    <a class="dropdown-toggle status status-indigo" href="#" data-bs-toggle="dropdown"
                      aria-haspopup="true" aria-expanded="false" id="bookings-period">Ultimi 3 mesi</a>
                    <div class="dropdown-menu dropdown-menu-end">
                      <a class="dropdown-item " href="#">Ultimi 7 giorni</a>
                      <a class="dropdown-item" href="#">Ultimi 30 giorni</a>
                      <a class="dropdown-item active" href="#">Ultimi 3 mesi</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="d-flex align-items-baseline">
                <div class="h1 mb-3 me-2" id="bookings-count">0</div>
                <div class="me-auto">

                </div>
              </div>

            </div>
            <div id="chart-new-clients" class="chart-sm"></div>
            <div class="card-footer pt-1 pb-1 subheader">form completati con o senza conferma</div>
          </div>
        </div>

        <div class="col-12">
          <div class="row row-cards">
            <div class="col-sm-6 col-lg-3">
              <div class="card card-sm">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-auto">
                      <span
                        class="text-primary"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="icon icon-tabler icons-tabler-outline icon-tabler-circle-check">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                          <path d="M9 12l2 2l4 -4" />
                        </svg>
                      </span>
                    </div>
                    <div class="col">
                      <div class="font-weight-medium">
                        0 Completati
                      </div>
                      <div class="text-secondary">
                        Prestazioni concluse.
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="card card-sm">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-auto">
                      <span class="text-green"><!-- Download SVG icon from http://tabler-icons.io/i/shopping-cart -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                          stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                          stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                          <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                          <path d="M17 17h-11v-14h-2" />
                          <path d="M6 5l14 1l-1 7h-13" />
                        </svg>
                      </span>
                    </div>
                    <div class="col">
                      <div class="font-weight-medium">
                        0 Ordini
                      </div>
                      <div class="text-secondary">
                        Prestazioni confermate.
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="card card-sm">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-auto">
                      <span class="text-yellow"><!-- Download SVG icon from http://tabler-icons.io/i/shopping-cart -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="icon icon-tabler icons-tabler-outline icon-tabler-phone-pause">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <path
                            d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2c-8.072 -.49 -14.51 -6.928 -15 -15a2 2 0 0 1 2 -2" />
                          <path d="M17 3v5" />
                          <path d="M21 3v5" />
                        </svg>
                      </span>
                    </div>
                    <div class="col">
                      <div class="font-weight-medium">
                        0 Recall
                      </div>
                      <div class="text-secondary">
                        Non conclusi da ricontattare.
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="card card-sm">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-auto">
                      <span class="text-red"><!-- Download SVG icon from http://tabler-icons.io/i/shopping-cart -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="icon icon-tabler icons-tabler-outline icon-tabler-xbox-x">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <path d="M12 21a9 9 0 0 0 9 -9a9 9 0 0 0 -9 -9a9 9 0 0 0 -9 9a9 9 0 0 0 9 9z" />
                          <path d="M9 8l6 8" />
                          <path d="M15 8l-6 8" />
                        </svg>
                      </span>
                    </div>
                    <div class="col">
                      <div class="font-weight-medium">
                        0 Annullate
                      </div>
                      <div class="text-secondary">
                        Prestazioni non concluse.
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include("components/footer.php"); ?>
</div>


<!-- Libs JS -->
<script src="<?php echo BASE_URL ?>/dist/libs/apexcharts/dist/apexcharts.min.js?1692870487" defer></script>
<script src="<?php echo BASE_URL ?>/dist/libs/jsvectormap/dist/js/jsvectormap.min.js?1692870487" defer></script>

<!-- Tabler Core -->
<script src="<?php echo BASE_URL ?>/dist/js/tabler.min.js?1692870487" defer></script>
<script src="<?php echo BASE_URL ?>/dist/js/demo.min.js?1692870487" defer></script>

<!-- SCRIPT CARD VENDITE -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const updateSalesData = (period) => {
      fetch('api/getPrenotazioniStats.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ periodo: period })
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            const { totale, conversionRate } = data.data;
            document.getElementById('sales-count').textContent = totale;
            document.getElementById('conversion-rate').textContent = `${conversionRate}%`;
            document.getElementById('conversion-bar').style.width = `${conversionRate}%`;
          } else {
            console.error('Errore API:', data.error);
          }
        })
        .catch(err => console.error('Errore nella richiesta:', err));
    };

    // Inizializza con "Ultimi 7 giorni"
    updateSalesData('Ultimi 7 giorni');

    // Gestisci il cambio del periodo
    const salesDropdown = document.getElementById('sales-period');
    if (salesDropdown) {
      const dropdownItems = salesDropdown.closest('.dropdown').querySelectorAll('.dropdown-item');
      dropdownItems.forEach(item => {
        item.addEventListener('click', (e) => {
          e.preventDefault();
          const period = e.target.dataset.period;

          // Aggiorna il dropdown attivo
          salesDropdown.textContent = period;
          dropdownItems.forEach(i => i.classList.remove('active'));
          e.target.classList.add('active');

          // Aggiorna i dati
          updateSalesData(period);
        });
      });
    }
  });
</script>
<!-- SCRIPT CARD GUADAGNI -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    let revenueChart;
    const conversioneEur = { rate: 0.0 }; // Salva il tasso di cambio corrente

    // Funzione per ottenere il tasso di cambio AED-EUR
    const fetchExchangeRate = () => {
      return fetch('https://api.exchangerate-api.com/v4/latest/AED') // Cambia con il tuo endpoint
        .then(response => response.json())
        .then(data => {
          if (data && data.rates && data.rates.EUR) {
            conversioneEur.rate = data.rates.EUR;
          } else {
            console.error('Errore nel recupero del tasso di cambio');
          }
        })
        .catch(err => console.error('Errore nella richiesta del tasso di cambio:', err));
    };

    const initializeRevenueChart = () => {
      if (!revenueChart) {
        revenueChart = new ApexCharts(document.getElementById('chart-revenue-bg'), {
          chart: {
            type: "area",
            fontFamily: 'inherit',
            height: 40.0,
            sparkline: { enabled: true },
            animations: { enabled: false }
          },
          dataLabels: {
            enabled: false,
          },
          fill: {
            opacity: 0.16,
            type: 'solid'
          },
          stroke: {
            width: 2,
            curve: "smooth",
            lineCap: "round"
          },
          series: [{ name: "Guadagni", data: [] }],
          tooltip: {
            theme: 'dark'
          },
          grid: {
            strokeDashArray: 4,
          },
          xaxis: {
            labels: { padding: 0 },
            tooltip: { enabled: false },
            axisBorder: { show: false },
            categories: []
          },
          yaxis: {
            labels: { padding: 4 }
          },
          colors: [tabler.getColor("instagram")],
          legend: {
            show: false
          }
        });
        revenueChart.render();
      }
    };

    const updateRevenueChart = async (period) => {
      await fetchExchangeRate(); // Assicurati di avere il tasso di cambio aggiornato
      fetch('api/getGuadagni.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ periodo: period })
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            const guadagni = data.data.map(item => item.guadagni);
            const dateLabels = data.data.map(item => item.data);
            const totaleGuadagni = guadagni.reduce((acc, val) => acc + val, 0);
            const conversioneEuro = totaleGuadagni * conversioneEur.rate;
            const maxGuadagno = Math.max(...guadagni);


            // Aggiorna il grafico
            if (revenueChart) {
              revenueChart.updateOptions({
                series: [{ name: "Guadagni", data: guadagni }],
                xaxis: { categories: dateLabels },
                annotations: {
                  yaxis: [
                    {
                      y: maxGuadagno,
                      borderColor: 'darkgrey',
                      strokeDashArray: 4,

                    }
                  ]
                }
              });
            }

            // Aggiorna il testo del totale guadagni
            document.getElementById('revenue-amount').textContent = `AED ${totaleGuadagni.toFixed(2)}`;
            const conversionElement = document.getElementById('conversion-eur');
            if (conversionElement) {
              conversionElement.textContent = `€ ${conversioneEuro.toFixed(2)}`;
            }
          } else {
            console.error('Errore API:', data.error);
          }
        })
        .catch(err => console.error('Errore nella richiesta:', err));
    };

    // Inizializza il grafico
    initializeRevenueChart();

    // Inizializza con "Ultimi 3 mesi"
    updateRevenueChart('Ultimi 3 mesi');

    // Gestisci il cambio del periodo
    const revenueDropdown = document.getElementById('revenue-period');
    if (revenueDropdown) {
      const dropdownItems = revenueDropdown.closest('.dropdown').querySelectorAll('.dropdown-item');
      dropdownItems.forEach(item => {
        item.addEventListener('click', (e) => {
          e.preventDefault();
          const period = e.target.dataset.period;

          // Aggiorna il dropdown attivo
          revenueDropdown.textContent = period;
          dropdownItems.forEach(i => i.classList.remove('active'));
          e.target.classList.add('active');

          // Aggiorna i dati e il grafico
          updateRevenueChart(period);
        });
      });
    }
  });
</script>

<script>
 document.addEventListener("DOMContentLoaded", function () {
  let bookingsChart;

  const initializeBookingsChart = () => {
    if (!bookingsChart) {
      bookingsChart = new ApexCharts(document.getElementById("chart-new-clients"), {
        chart: {
          type: "bar",
          fontFamily: "inherit",
          height: 40,
          sparkline: {
            enabled: true,
          },
          animations: {
            enabled: false,
          },
        },
        plotOptions: {
          bar: {
            columnWidth: "50%",
            colors: {
              backgroundBarColors: ['transparent'], // Colore per barre vuote (se presente)
              backgroundBarOpacity: 1,
            },
            borderRadius: 0, // Arrotondamento degli angoli delle barre
          },
        },
        dataLabels: {
          enabled: false,
        },
        fill: {
          type: "solid",
          colors: ["#4263eb"], // Colore di riempimento delle barre
        },
        stroke: {
          colors: ["#4263eb"], // Colore del bordo
          width: 2, // Spessore del bordo
        },
        series: [
          {
            name: "Prenotazioni",
            data: [], // I dati verranno aggiornati dinamicamente
          },
        ],
        tooltip: {
          theme: "dark",
        },
        grid: {
          strokeDashArray: 4,
        },
        xaxis: {
          labels: {
            padding: 0,
          },
          tooltip: {
            enabled: false,
          },
          axisBorder: {
            show: false,
          },
          categories: [], // Etichette per l'asse X
        },
        yaxis: {
          labels: {
            padding: 4,
          },
        },
        legend: {
          show: false,
        },
      });
      bookingsChart.render();
    }
  };
    const updateBookingsData = (period) => {
      fetch("api/getPrenotazioni.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({ periodo: period }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            const prenotazioni = data.data.map((item) => item.prenotazioni);
            const dateLabels = data.data.map((item) => item.data);
            const maxPrenotazioni = Math.max(...prenotazioni); // Calcola il massimo valore

            // Aggiorna il grafico
            if (bookingsChart) {
              bookingsChart.updateOptions({
                series: [{ name: "Prenotazioni", data: prenotazioni }],
                xaxis: { categories: dateLabels },
                annotations: {
                  yaxis: [
                    {
                      y: maxPrenotazioni,
                      borderColor: 'darkgrey',
                      strokeDashArray: 6,

                    }
                  ]
                }
              });
            }

            // Aggiorna il conteggio totale prenotazioni
            const bookingsCountElement = document.getElementById("bookings-count");
            if (bookingsCountElement) {
              bookingsCountElement.textContent = prenotazioni.reduce((acc, val) => acc + val, 0);
            }
          } else {
            console.error("Errore API:", data.error);
          }
        })
        .catch((err) => console.error("Errore nella richiesta:", err));
    };

    // Inizializza il grafico
    initializeBookingsChart();

    // Inizializza con "Ultimi 3 mesi"
    updateBookingsData("Ultimi 3 mesi");

    // Gestisci il cambio del periodo
    const bookingsDropdown = document.getElementById("bookings-period");
    if (bookingsDropdown) {
      const dropdownItems = bookingsDropdown.closest(".dropdown").querySelectorAll(".dropdown-item");
      dropdownItems.forEach((item) => {
        item.addEventListener("click", (e) => {
          e.preventDefault();
          const period = e.target.textContent;



          // Aggiorna il dropdown attivo
          bookingsDropdown.textContent = period;
          dropdownItems.forEach((i) => i.classList.remove("active"));
          e.target.classList.add("active");

          // Aggiorna i dati e il grafico
          updateBookingsData(period);
        });
      });
    }
  });

</script>



<?php include(BASE_PATH . "/components/footer.php"); ?>