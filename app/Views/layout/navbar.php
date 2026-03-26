<!-- NAVBAR -->
<nav class="bg-white border-b shadow-sm fixed w-full z-50">
  <div
    class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
    <h1 class="font-bold text-xl text-blue-600">Admin - DuitKu</h1>
    <ul class="flex gap-2 items-center">
      <li class="hover:bg-lime-200 px-3 py-2 rounded transition">
        <a href="/dashboard">
          Dashboard
        </a>
      </li>
      <?php if (session('level') == 'Admin') : ?>
        <li class="hover:bg-sky-200 px-3 py-2 rounded transition">
          <a href="/admin">
            Admin
          </a>
        </li>
      <?php endif; ?>
      <li class="hover:bg-amber-200 px-3 py-2 rounded transition">
        <a href="/transaksi">
          Transaksi</a>
      </li>
      <?php if (session('level') == 'Admin') : ?>
        <li class="hover:bg-green-200 px-3 py-2 rounded transition">
          <a href="/rekening">
            Rekening
          </a>
        </li>
      <?php endif; ?>
      <li class="hover:bg-blue-200 px-3 py-2 rounded transition">
        <a href="/perencanaan">
          Perencanaan
        </a>
      </li>
      <?php if (session('level') == 'Admin') : ?>
        <li class="hover:bg-yellow-200 px-3 py-2 rounded transition">
          <a href="/kategori">
            Kategori
          </a>
        </li>
      <?php endif; ?>
      <li class="hover:bg-orange-100 px-3 py-2 rounded transition">
        <a href="/laporan">
          Laporan
        </a>
      </li>
      <button
        onclick="openLogout()"
        class="text-red-600 hover:bg-red-50 px-3 py-2 rounded transition">
        <i class="fa-solid fa-right-from-bracket"></i>
      </button>
    </ul>
  </div>
</nav>