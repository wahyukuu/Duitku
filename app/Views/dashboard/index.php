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
        <i class="">
          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-wallet-icon lucide-wallet">
            <path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1" />
            <path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4" />
          </svg>
        </i>
      </div>
      <div>
        <p class="text-sm text-gray-600">Total Saldo</p>
        <h2 class="text-xl font-bold text-blue-600">Rp. <?= rupiah($total) ?></h2>
      </div>
    </div>

    <!-- CARD 2 -->
    <div class="p-5 border rounded-2xl shadow-sm flex items-center gap-4 hover:shadow-md transition">
      <div class="text-green-600 text-4xl bg-green-100 p-3 rounded-xl">
        <i class="">
          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-banknote-arrow-down-icon lucide-banknote-arrow-down">
            <path d="M12 18H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5" />
            <path d="m16 19 3 3 3-3" />
            <path d="M18 12h.01" />
            <path d="M19 16v6" />
            <path d="M6 12h.01" />
            <circle cx="12" cy="12" r="2" />
          </svg>
        </i>
      </div>
      <div>
        <p class="text-sm text-gray-600">Pendapatan Bulan Ini</p>
        <h2 id="masuk" class="text-xl font-bold text-green-600"></h2>
      </div>
    </div>

    <!-- CARD 3 -->
    <div class="p-5 border rounded-2xl shadow-sm flex items-center gap-4 hover:shadow-md transition">
      <div class="text-red-600 text-4xl bg-red-100 p-3 rounded-xl">
        <i class="">
          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-banknote-arrow-up-icon lucide-banknote-arrow-up">
            <path d="M12 18H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5" />
            <path d="M18 12h.01" />
            <path d="M19 22v-6" />
            <path d="m22 19-3-3-3 3" />
            <path d="M6 12h.01" />
            <circle cx="12" cy="12" r="2" />
          </svg>
        </i>
      </div>
      <div>
        <p class="text-sm text-gray-600">Pengeluaran Bulan Ini</p>
        <h2 id="keluar" class="text-xl font-bold text-red-600"></h2>
      </div>
    </div>

    <!-- CARD 4 -->
    <div class="p-5 border rounded-2xl shadow-sm flex items-center gap-4 hover:shadow-md transition">
      <div class="text-orange-600 text-4xl bg-orange-100 p-3 rounded-xl">
        <i class="">
          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-cent-icon lucide-badge-cent">
            <path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z" />
            <path d="M12 7v10" />
            <path d="M15.4 10a4 4 0 1 0 0 4" />
          </svg>
        </i>
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
        <h2 class="text-lg font-semibold">
          Transaksi Terakhir
        </h2>

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
            <i class="">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info-icon lucide-info">
                <circle cx="12" cy="12" r="10" />
                <path d="M12 16v-4" />
                <path d="M12 8h.01" />
              </svg>
            </i>
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