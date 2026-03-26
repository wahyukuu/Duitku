<!-- merender template layout -->
<?= $this->extend('layout/default') ?>

<!-- merender title halaman -->
<?= $this->section('title') ?>
<title>Laporan &mdash; DuitKu</title>
<?= $this->endSection() ?>

<!-- merender conten halaman -->
<?= $this->section('content') ?>
<div class="pt-24 max-w-7xl mx-auto px-6 space-y-6 animate-fade">
  <!-- CARD REKENING -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <div class="p-5 border rounded-xl shadow-sm">
      <p class="text-sm">Total Saldo Saat Ini</p>
      <h2 class="text-xl font-bold text-blue-600"><?= rupiah($total) ?></h2>
    </div>
    <div class="p-5 border rounded-xl shadow-sm">
      <p class="text-sm">Pendapatan Bulan Ini</p>
      <h2 id="masuk" class="text-xl font-bold text-green-600"></h2>
    </div>
    <div class="p-5 border rounded-xl shadow-sm">
      <p class="text-sm">Pengeluaran Bulan Ini</p>
      <h2 id="keluar" class="text-xl font-bold text-red-600"></h2>
    </div>
    <div class="p-5 border rounded-xl shadow-sm">
      <p class="text-sm">Saldo Rekening Utama</p>
      <h2 class="text-xl font-bold text-orange-600"><?= rupiah($utama['saldo']) ?></h2>
    </div>
  </div>
  <!-- ASET & HUTANG -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <div class="p-5 border rounded-xl shadow-sm">
      <p class="text-sm">Total Nilai Aset Saat ini</p>
      <h2 class="text-xl font-bold text-blue-600">Rp 12.500.000</h2>
    </div>
    <div class="p-5 border rounded-xl shadow-sm">
      <p class="text-sm">Total Piutang</p>
      <h2 id="piutang" class="text-xl font-bold text-green-600"></h2>
    </div>
    <div class="p-5 border rounded-xl shadow-sm">
      <p class="text-sm">Total Kewajiban Hutang</p>
      <h2 id="hutang" class="text-xl font-bold text-red-600"></h2>
    </div>
    <div class="p-5 border rounded-xl shadow-sm">
      <p class="text-sm">Saldo Rekening Utama</p>
      <h2 class="text-xl font-bold text-orange-600"></h2>
    </div>
  </div>

  <!-- FILTER -->
  <form id="formCetak" action="<?= base_url('laporan/preview') ?>" method="get" target="_blank" class="flex flex-wrap gap-4 items-end">

    <input name="from" type="date" class="border rounded px-3 py-2">

    <input name="to" type="date" class="border rounded px-3 py-2">

    <select name="jenis" class="border rounded px-3 py-2">
      <option value="Semua">Semua</option>
      <option value="Penghasilan">Penghasilan</option>
      <option value="Pengeluaran">Pengeluaran</option>
      <option value="Rencana">Rencana/Investasi</option>
    </select>

    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-xl">
      <i class="fa fa-file-pdf"></i> Cetak PDF
    </button>

  </form>

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
      fetch("<?= base_url('laporan/total') ?>", {
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

          document.getElementById('hutang').innerText =
            'Rp ' + Number(res.hutang).toLocaleString('id-ID');

          document.getElementById('piutang').innerText =
            'Rp ' + Number(res.piutang).toLocaleString('id-ID');

        });
    }

    loadTotalBulanIni();

    document.getElementById('formCetak').addEventListener('submit', function(e) {

      const from = document.querySelector('input[name="from"]').value;
      const to = document.querySelector('input[name="to"]').value;

      //cek logika tanggal
      if (new Date(to) < new Date(from)) {
        e.preventDefault();

        Swal.fire({
          icon: 'error',
          title: 'Periode tidak valid',
          text: 'Tanggal akhir tidak boleh lebih kecil dari tanggal awal.',
          confirmButtonColor: '#dc2626'
        });

        return false;
      }

      //cek filter kosong
      if (!from || !to) {
        e.preventDefault(); // tahan submit

        Swal.fire({
          icon: 'warning',
          title: 'Filter belum Diisi',
          text: 'Silakan pilih periode tanggal terlebih dahulu.',
          confirmButtonColor: '#dc2626'
        });

        return false;
      }

    });
  </script>
  <?= $this->endSection() ?>