<!doctype html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Admin</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Icons -->
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    rel="stylesheet" />
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen">
  <!-- LOGIN CARD -->
  <div
    class="bg-white w-full max-w-md p-8 rounded-2xl shadow-lg animate-fade">
    <h1 class="text-2xl font-bold text-center text-blue-600 mb-2">
      Duitku
    </h1>
    <p class="text-center text-gray-500 mb-6">
      Manajemen Keuangan yang Rapi & Terintegrasi
    </p>

    <form method="POST" action="/auth/masuk" class="needs-validation" novalidate="">
      <div class="mb-4">
        <div class="relative">
          <i class="fa fa-envelope absolute left-3 top-3 text-gray-400"></i>
          <input
            type="text"
            placeholder="Username"
            name="username"
            id="username"
            class="w-full pl-10 pr-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" />
        </div>
      </div>

      <div class="mb-4">
        <div class="relative">
          <i class="fa fa-lock absolute left-3 top-3 text-gray-400"></i>
          <input
            type="password"
            placeholder="Password"
            name="password"
            id="password"
            class="w-full pl-10 pr-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" />
        </div>
      </div>

      <button
        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg transition">
        <i class="fa fa-sign-in-alt"></i> Login
      </button>
    </form>
  </div>

  <hr class="my-20" />
</body>

</html>