<!-- merender template layout -->
<?= $this->extend('layout/default') ?>

<!-- merender title halaman -->
<?= $this->section('title') ?>
<title>Dashboard &mdash; DuitKu</title>
<?= $this->endSection() ?>

<!-- merender conten halaman -->
<?= $this->section('content') ?>
<div class="pt-24 max-w-7xl mx-auto px-6 space-y-8 animate-fade">

  <!-- CARD -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

    <!-- CARD 1 -->
    <div class="p-5 border rounded-2xl shadow-sm flex items-center gap-4 hover:shadow-md transition">
      <div class="text-blue-600 text-4xl bg-blue-100 p-3 rounded-xl">
        <i class="fa-solid fa-coins"></i>
      </div>
      <div>
        <p class="text-sm text-gray-600">Total Saldo</p>
        <h2 class="text-xl font-bold text-blue-600">Rp. <?= rupiah($total) ?></h2>
      </div>
    </div>

    <!-- CARD 2 -->
    <div class="p-5 border rounded-2xl shadow-sm flex items-center gap-4 hover:shadow-md transition">
      <div class="text-green-600 text-4xl bg-green-100 p-3 rounded-xl">
        <i class="fa-solid fa-wallet"></i>
      </div>
      <div>
        <p class="text-sm text-gray-600">Pendapatan Bulan Ini</p>
        <h2 id="masuk" class="text-xl font-bold text-green-600"></h2>
      </div>
    </div>

    <!-- CARD 3 -->
    <div class="p-5 border rounded-2xl shadow-sm flex items-center gap-4 hover:shadow-md transition">
      <div class="text-red-600 text-4xl bg-red-100 p-3 rounded-xl">
        <i class="fa-solid fa-cart-shopping"></i>
      </div>
      <div>
        <p class="text-sm text-gray-600">Pengeluaran Bulan Ini</p>
        <h2 id="keluar" class="text-xl font-bold text-red-600"></h2>
      </div>
    </div>

    <!-- CARD 4 -->
    <div class="p-5 border rounded-2xl shadow-sm flex items-center gap-4 hover:shadow-md transition">
      <div class="text-orange-600 text-4xl bg-orange-100 p-3 rounded-xl">
        <i class="fa-solid fa-money-check"></i>
      </div>
      <div>
        <p class="text-sm text-gray-600">Rekening Utama</p>
        <h2 class="text-xl font-bold text-orange-600">Rp. <?= rupiah($utama['saldo']) ?></h2>
      </div>
    </div>

  </div>

  <!-- TABLE SECTION -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

    <!-- TABLE -->
    <div class="md:col-span-3 p-6 border rounded-2xl shadow-sm bg-white">

      <!-- HEADER -->
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">Transaksi Terakhir</h2>

        <div class="flex items-center gap-3">
          <form action="" method="get" class="flex items-center gap-3">
            <select id="perPage" name="perPage"
              onchange="this.form.submit()"
              class="border rounded-lg px-2 py-2">
              <option value="5" <?= ($perPage == 5) ? 'selected' : '' ?>>5</option>
              <option value="10" <?= ($perPage == 10) ? 'selected' : '' ?>>10</option>
              <option value="15" <?= ($perPage == 15) ? 'selected' : '' ?>>15</option>
              <option value="25" <?= ($perPage == 25) ? 'selected' : '' ?>>25</option>
            </select>
          </form>
          <a href="/transaksi"
            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg shadow hover:bg-blue-600 transition duration-200">
            Lihat Semua
            <i class="fa-solid fa-arrow-right"></i>
          </a>
        </div>
      </div>

      <!-- TABLE -->
      <div class="overflow-x-auto">
        <table class="w-full text-sm border-collapse tabular-nums">

          <thead>
            <tr class="bg-gray-100 text-gray-600">
              <th class="p-3 text-left">Tanggal</th>
              <th class="p-3 text-left">Jenis</th>
              <th class="p-3 text-left">Rincian</th>
              <th class="p-3 text-left">Deskripsi</th>
              <th class="p-3 text-left">Rekening</th>
              <th class="p-3 text-right">Jumlah</th>
            </tr>
          </thead>

          <tbody id="transaksiBody" class="divide-y">
            <?php foreach ($transaksi as $t) : ?>
              <tr class="hover:bg-gray-50">
                <td class="p-3"><?= date('d/m/Y', strtotime($t['tanggal'])) ?></td>
                <td class="p-3"><?= $t['jenis'] ?></td>
                <td class="p-3"><?= $t['rincian'] ?></td>
                <td class="p-3 text-gray-500"><?= $t['deskripsi'] ?></td>
                <td class="p-3"><?= $t['nama_bank'] ?></td>
                <td class="p-3 text-right font-medium 
                  <?= ($t['jenis'] == 'Penghasilan') ? 'text-green-600' : 'text-red-600' ?>">
                  <?= ($t['jenis'] == 'Penghasilan') ? '+' : '-' ?>
                  Rp <?= number_format($t['jumlah'], 0, ',', '.') ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- SIDE CARD -->
    <div class="p-6 border rounded-2xl shadow-sm bg-white flex flex-col justify-center items-center text-center">
      <p class="text-gray-500 text-sm mb-2">Insight</p>
      <h3 class="text-lg font-semibold">Keuangan Stabil 👍</h3>
      <p class="text-sm text-gray-400 mt-2">Pengeluaran masih terkendali bulan ini</p>
    </div>

  </div>
</div>
<!-- MODAL LOGOUT -->
<div id="modalLogout" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center">
  <div class="bg-white p-6 rounded-xl w-full max-w-sm animate-slide">
    <p class="mb-4">Yakin ingin logout?</p>
    <div class="flex justify-end gap-5"> <button onclick="closeLogout()">Batal</button> <button class="bg-red-600 text-white px-4 py-2 rounded-lg" onclick="window.location.href='<?= base_url('/auth/keluar') ?>'"> Logout </button> </div>
  </div>
</div>

<script>
  const openLogout = () => modalLogout.classList.remove("hidden");
  const closeLogout = () => modalLogout.classList.add("hidden");

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