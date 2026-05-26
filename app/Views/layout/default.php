<!doctype html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?= $this->renderSection('title') ?>

  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="<?= base_url('css/main.css') ?>">
  <script>
    tailwind.config = {
      theme: {
        fontFamily: {
          sans: ['"Plus Jakarta Sans"', 'sans-serif'],
        },
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

<body class="bg-slate-50 text-gray-800 overflow-x-hidden font-sans">
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

  </script>
</body>

</html>