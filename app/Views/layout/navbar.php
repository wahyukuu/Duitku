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
        <li class="hover:bg-blue-200 px-3 py-2 rounded transition">
          <a href="/aset">
            Aset
          </a>
        </li>
      <?php endif; ?>
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
        <i class="">
          <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out">
            <path d="m16 17 5-5-5-5" />
            <path d="M21 12H9" />
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
          </svg>
        </i>
      </button>
    </ul>
  </div>
</nav>

<!-- MODAL LOGOUT -->
<div
  id="modalLogout"
  class="hidden fixed inset-0 bg-black/40 flex items-center justify-center">
  <div class="bg-white p-6 rounded-xl w-full max-w-sm animate-slide">
    <p class="mb-4">Yakin ingin logout?</p>
    <div class="flex justify-end gap-3">
      <button class="px-4 py-2 rounded-lg text-red-500 border-2 border-red-500 bg-white hover:bg-gray-100"
        onclick="closeLogout()">
        Batal
      </button>
      <button class="bg-red-500 text-white px-4 py-2 rounded-lg"
        onclick="window.location.href='<?= base_url('/auth/keluar') ?>'">
        Logout
      </button>
    </div>
  </div>
</div>

<script>
  const openLogout = () => modalLogout.classList.remove("hidden");
  const closeLogout = () => modalLogout.classList.add("hidden");
</script>