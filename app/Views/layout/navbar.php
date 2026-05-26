<!-- NAVBAR -->
<nav class="bg-white/80 backdrop-blur-md border-b border-gray-200/50 shadow-[0_4px_30px_rgba(0,0,0,0.05)] fixed w-full z-50 transition-all">
  <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
    <h1 class="font-bold text-xl text-blue-600">Admin - DuitKu</h1>
    
    <!-- DESKTOP MENU -->
    <ul class="hidden lg:flex gap-2 items-center">
      <li class="hover:bg-lime-200 px-3 py-2 rounded transition">
        <a href="<?= base_url('dashboard') ?>">Dashboard</a>
      </li>
      <?php if (session('level') == 'Admin') : ?>
        <li class="hover:bg-sky-200 px-3 py-2 rounded transition">
          <a href="<?= base_url('admin') ?>">Admin</a>
        </li>
      <?php endif; ?>
      <li class="hover:bg-amber-200 px-3 py-2 rounded transition">
        <a href="<?= base_url('transaksi') ?>">Transaksi</a>
      </li>
      <?php if (session('level') == 'Admin') : ?>
        <li class="hover:bg-blue-200 px-3 py-2 rounded transition">
          <a href="<?= base_url('aset') ?>">Aset</a>
        </li>
      <?php endif; ?>
      <?php if (session('level') == 'Admin') : ?>
        <li class="hover:bg-green-200 px-3 py-2 rounded transition">
          <a href="<?= base_url('rekening') ?>">Rekening</a>
        </li>
      <?php endif; ?>
      <li class="hover:bg-blue-200 px-3 py-2 rounded transition">
        <a href="<?= base_url('perencanaan') ?>">Perencanaan</a>
      </li>
      <?php if (session('level') == 'Admin') : ?>
        <li class="hover:bg-yellow-200 px-3 py-2 rounded transition">
          <a href="<?= base_url('kategori') ?>">Kategori</a>
        </li>
      <?php endif; ?>
      <li class="hover:bg-orange-100 px-3 py-2 rounded transition">
        <a href="<?= base_url('laporan') ?>">Laporan</a>
      </li>
      <button onclick="openLogout()" class="text-red-600 hover:bg-red-50 px-3 py-2 rounded transition">
        <i>
          <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out">
            <path d="m16 17 5-5-5-5" />
            <path d="M21 12H9" />
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
          </svg>
        </i>
      </button>
    </ul>

    <!-- MOBILE HAMBURGER -->
    <button onclick="toggleMobileMenu()" class="lg:hidden text-gray-600 hover:bg-gray-100 p-2 rounded transition">
      <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
    </button>
  </div>
</nav>

<!-- MOBILE MENU DROPDOWN -->
<div id="mobileMenu" class="hidden fixed top-[68px] inset-x-0 bg-white border-b shadow-md z-40 lg:hidden overflow-y-auto max-h-[calc(100vh-68px)]">
  <ul class="flex flex-col p-4 space-y-2">
    <li class="hover:bg-lime-200 px-3 py-3 rounded transition">
      <a href="<?= base_url('dashboard') ?>" class="block w-full">Dashboard</a>
    </li>
    <?php if (session('level') == 'Admin') : ?>
      <li class="hover:bg-sky-200 px-3 py-3 rounded transition">
        <a href="<?= base_url('admin') ?>" class="block w-full">Admin</a>
      </li>
    <?php endif; ?>
    <li class="hover:bg-amber-200 px-3 py-3 rounded transition">
      <a href="<?= base_url('transaksi') ?>" class="block w-full">Transaksi</a>
    </li>
    <?php if (session('level') == 'Admin') : ?>
      <li class="hover:bg-blue-200 px-3 py-3 rounded transition">
        <a href="<?= base_url('aset') ?>" class="block w-full">Aset</a>
      </li>
    <?php endif; ?>
    <?php if (session('level') == 'Admin') : ?>
      <li class="hover:bg-green-200 px-3 py-3 rounded transition">
        <a href="<?= base_url('rekening') ?>" class="block w-full">Rekening</a>
      </li>
    <?php endif; ?>
    <li class="hover:bg-blue-200 px-3 py-3 rounded transition">
      <a href="<?= base_url('perencanaan') ?>" class="block w-full">Perencanaan</a>
    </li>
    <?php if (session('level') == 'Admin') : ?>
      <li class="hover:bg-yellow-200 px-3 py-3 rounded transition">
        <a href="<?= base_url('kategori') ?>" class="block w-full">Kategori</a>
      </li>
    <?php endif; ?>
    <li class="hover:bg-orange-100 px-3 py-3 rounded transition">
      <a href="<?= base_url('laporan') ?>" class="block w-full">Laporan</a>
    </li>
    <hr class="my-2 border-gray-200">
    <li>
      <button onclick="openLogout()" class="w-full text-left text-red-600 hover:bg-red-50 px-3 py-3 rounded transition flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out"><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/></svg>
        Logout
      </button>
    </li>
  </ul>
</div>

<!-- MODAL LOGOUT -->
<div id="modalLogout" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-[60]">
  <div class="bg-white p-6 mx-4 rounded-xl w-full max-w-sm animate-slide">
    <p class="mb-4">Yakin ingin logout?</p>
    <div class="flex justify-end gap-3">
      <button class="px-4 py-2 rounded-lg text-red-500 border-2 border-red-500 bg-white hover:bg-gray-100" onclick="closeLogout()">Batal</button>
      <button class="bg-red-500 text-white px-4 py-2 rounded-lg" onclick="window.location.href='<?= base_url('/auth/keluar') ?>'">Logout</button>
    </div>
  </div>
</div>

<script>
  // Script is defined in default.php, but just in case we need toggles here
  const modalLogout = document.getElementById('modalLogout');
  const mobileMenu = document.getElementById('mobileMenu');
  
  const openLogout = () => {
    modalLogout.classList.remove("hidden");
    if(mobileMenu) mobileMenu.classList.add("hidden");
  };
  const closeLogout = () => modalLogout.classList.add("hidden");
  
  const toggleMobileMenu = () => {
    if (mobileMenu.classList.contains("hidden")) {
      mobileMenu.classList.remove("hidden");
      mobileMenu.classList.add("show");
    } else {
      mobileMenu.classList.remove("show");
      mobileMenu.classList.add("hidden");
    }
  };
</script>