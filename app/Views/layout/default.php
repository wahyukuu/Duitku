<!doctype html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?= $this->renderSection('title') ?>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          animation: {
            fade: "fadeIn 0.4s ease-in-out",
            slide: "slideUp 0.4s ease-in-out",
          },
          keyframes: {
            fadeIn: {
              "0%": {
                opacity: 0
              },
              "100%": {
                opacity: 1
              }
            },
            slideUp: {
              "0%": {
                transform: "translateY(10px)",
                opacity: 0
              },
              "100%": {
                transform: "translateY(0)",
                opacity: 1
              },
            },
          },
        },
      },
    };
  </script>

  <!-- Icons -->
  <!-- Development version -->
  <!-- <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script> -->


  <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" /> -->

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



</head>

<body class="bg-white text-gray-800">
  <!-- NAVBAR -->
  <?= $this->include('layout/navbar') ?>

  <!-- CONTENT -->
  <?= $this->renderSection('content') ?>

  <!-- Production version (for icon) -->
  <script src="https://unpkg.com/lucide@latest"></script>

  <script>
    const modalForm = document.getElementById("modalForm");
    const modalDelete = document.getElementById("modalDelete");
    const modalLogout = document.getElementById("modalLogout");

    // const openForm = () => modalForm.classList.remove("hidden");
    // const closeForm = () => modalForm.classList.add("hidden");

    // const openDelete = () => modalDelete.classList.remove("hidden");
    // const closeDelete = () => modalDelete.classList.add("hidden");

    // const openLogout = () => modalLogout.classList.remove("hidden");
    // const closeLogout = () => modalLogout.classList.add("hidden");

    new Chart(document.getElementById("chartSaldo"), {
      type: "bar",
      data: {
        labels: ["BCA", "Mandiri", "BRI", "Dana"],
        datasets: [{
          label: "Saldo",
          data: [12500000, 8200000, 5100000, 3750000],
        }, ],
      },
    });
  </script>
</body>

</html>