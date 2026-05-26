<!doctype html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Admin DuitKu</title>

  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        fontFamily: {
          sans: ['"Plus Jakarta Sans"', 'sans-serif'],
        },
        extend: {
          animation: {
            fade: "fadeIn 0.6s ease-out",
          },
          keyframes: {
            fadeIn: {
              "0%": { opacity: 0, transform: "translateY(20px)" },
              "100%": { opacity: 1, transform: "translateY(0)" }
            }
          }
        }
      }
    }
  </script>

  <!-- Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-gradient-to-br from-slate-900 via-blue-900 to-blue-700 flex items-center justify-center min-h-screen font-sans">
  
  <!-- BACKGROUND DECORATIONS -->
  <div class="absolute inset-0 overflow-hidden pointer-events-none">
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
  </div>

  <!-- LOGIN CARD -->
  <div class="relative z-10 w-full max-w-md p-10 mx-4 bg-white/80 backdrop-blur-xl border border-white/40 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] animate-fade">
    <div class="text-center mb-8">
      <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-blue-600 to-blue-400 text-white shadow-lg mb-4">
        <i class="fa fa-wallet text-2xl"></i>
      </div>
      <h1 class="text-3xl font-bold text-gray-800 tracking-tight">DuitKu</h1>
      <p class="text-gray-500 mt-2 text-sm font-medium">Manajemen Keuangan Rapi & Terintegrasi</p>
    </div>

    <form method="POST" action="<?= base_url('auth/masuk') ?>" class="needs-validation space-y-5" novalidate="">
      
      <div>
        <div class="relative group">
          <i class="fa fa-envelope absolute left-4 top-3.5 text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
          <input
            type="text"
            placeholder="Username"
            name="username"
            id="username"
            class="w-full pl-11 pr-4 py-3 bg-white/50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all placeholder-gray-400" />
        </div>
      </div>

      <div>
        <div class="relative group">
          <i class="fa fa-lock absolute left-4 top-3.5 text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
          <input
            type="password"
            placeholder="Password"
            name="password"
            id="password"
            class="w-full pl-11 pr-4 py-3 bg-white/50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all placeholder-gray-400" />
        </div>
      </div>

      <button
        class="w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-semibold py-3 rounded-xl shadow-lg shadow-blue-500/30 transform hover:-translate-y-0.5 transition-all duration-200 flex justify-center items-center gap-2">
        <i class="fa fa-sign-in-alt"></i> Masuk Sekarang
      </button>
    </form>
  </div>

</body>

</html>