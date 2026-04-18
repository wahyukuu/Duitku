<!-- merender template layout -->
<?= $this->extend('layout/default') ?>

<!-- merender title halaman -->
<?= $this->section('title') ?>
<title>Dashboard &mdash; DuitKu</title>
<?= $this->endSection() ?>

<!-- merender conten halaman -->
<?= $this->section('content') ?>
<div class="pt-24 max-w-7xl mx-auto px-6 space-y-6 animate-fade">
  <!-- CARD REKENING -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <div class="p-5 border rounded-xl shadow-sm flex items-center gap-4">
      <!-- icon -->
      <div class="text-blue-600 text-5xl">
        <i class="fa-solid fa-coins"></i>
      </div>
      <!-- text -->
      <div>
        <p class="text-sm">Total Saldo Saat Ini</p>
        <h2 class="text-xl font-bold text-blue-600">Rp. <?= rupiah($total) ?></h2>
      </div>
    </div>

    <div class="p-5 border rounded-xl shadow-sm flex items-center gap-4">
      <!-- ICON -->
      <div class="text-green-600 text-5xl">
        <i class="fa-solid fa-wallet"></i>
      </div>
      <!-- TEXT -->
      <div>
        <p class="text-sm">Pendapatan Bulan Ini</p>
        <h2 id="masuk" class="text-xl font-bold text-green-600"></h2>
      </div>
    </div>

    <div class="p-5 border rounded-xl shadow-sm flex items-center gap-4">
      <!-- icon -->
      <div class="text-red-600 text-5xl">
        <i class="fa-solid fa-cart-shopping"></i>
      </div>
      <!-- text -->
      <div>
        <p class="text-sm">Pengeluaran Bulan Ini</p>
        <h2 id="keluar" class="text-xl font-bold text-red-600"></h2>
      </div>
    </div>
    <div class="p-5 border rounded-xl shadow-sm flex items-center gap-4">
      <!-- icon -->
      <div class="text-orange-600 text-5xl">
        <i class="fa-solid fa-money-check"></i>
      </div>
      <!-- text -->
      <div>
        <p class="text-sm">Saldo Rekening Utama</p>
        <h2 class="text-xl font-bold text-orange-600">Rp. <?= rupiah($utama['saldo']) ?></h2>
      </div>
    </div>
  </div>

  <!-- MODAL LOGOUT -->
  <div
    id="modalLogout"
    class="hidden fixed inset-0 bg-black/40 flex items-center justify-center">
    <div class="bg-white p-6 rounded-xl w-full max-w-sm animate-slide">
      <p class="mb-4">Yakin ingin logout?</p>
      <div class="flex justify-end gap-2">
        <button onclick="closeLogout()">Batal</button>
        <button class="bg-red-600 text-white px-4 py-2 rounded" onclick="window.location.href='<?= base_url('/auth/keluar') ?>'">
          Logout
        </button>
      </div>
    </div>
  </div>

  <script>
    function loadTotalBulanIni() {
      fetch("<?= base_url('dashboard/total') ?>", {
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        })
        .then(res => res.json())
        .then(res => {

          document.getElementById('keluar').innerText =
            'Rp ' + Number(res.pengeluaran).toLocaleString('id-ID');

          document.getElementById('masuk').innerText =
            'Rp ' + Number(res.penghasilan).toLocaleString('id-ID');

        });
    }

    loadTotalBulanIni();
  </script>
  <?= $this->endSection() ?>