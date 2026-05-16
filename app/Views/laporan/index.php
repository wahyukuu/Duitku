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
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
    <!-- CARD 1 -->
    <div class="p-5 border rounded-2xl shadow-sm flex items-center gap-4 hover:shadow-md transition">
      <div class="text-blue-600 text-4xl bg-blue-100 p-3 rounded-xl">
        <i class="">
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-wallet-icon lucide-wallet">
            <path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1" />
            <path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4" />
          </svg>
        </i>
      </div>
      <div>
        <p class="text-sm text-gray-600">Total Saldo Saat Ini</p>
        <h2 class="text-xl font-bold text-blue-600">Rp. <?= rupiah($total) ?></h2>
      </div>
    </div>

    <!-- CARD 2 -->
    <div class="p-5 border rounded-2xl shadow-sm flex items-center gap-4 hover:shadow-md transition">
      <div class="text-green-600 text-4xl bg-green-100 p-3 rounded-xl">
        <i class="">
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-banknote-arrow-down-icon lucide-banknote-arrow-down">
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
        <h2 id="masuk" class="text-xl font-bold text-green-600">Rp. <?= rupiah($masuk) ?></h2>
      </div>
    </div>

    <!-- CARD 3 -->
    <div class="p-5 border rounded-2xl shadow-sm flex items-center gap-4 hover:shadow-md transition">
      <div class="text-red-600 text-4xl bg-red-100 p-3 rounded-xl">
        <i class="">
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-banknote-arrow-up-icon lucide-banknote-arrow-up">
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
        <h2 id="keluar" class="text-xl font-bold text-red-600">Rp. <?= rupiah($keluar) ?></h2>
      </div>
    </div>

    <!-- CARD 4 -->
    <div class="p-5 border rounded-2xl shadow-sm flex items-center gap-4 hover:shadow-md transition">
      <div class="text-orange-600 text-4xl bg-orange-100 p-3 rounded-xl">
        <i class="">
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-cent-icon lucide-badge-cent">
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

  <!-- INVESTASI PENGHASILAN PENGELUARAN -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <!-- CARD 1 -->
    <div class="p-5 border rounded-2xl shadow-sm flex items-center gap-4 hover:shadow-md transition">
      <div class="text-green-600 text-4xl bg-green-100 p-3 rounded-xl">
        <i class="">
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-pile-icon lucide-circle-pile">
            <circle cx="12" cy="19" r="2" />
            <circle cx="12" cy="5" r="2" />
            <circle cx="16" cy="12" r="2" />
            <circle cx="20" cy="19" r="2" />
            <circle cx="4" cy="19" r="2" />
            <circle cx="8" cy="12" r="2" />
          </svg>
        </i>
      </div>
      <div>
        <p class="text-sm text-gray-600">Total Investasi</p>
        <h2 class="text-xl font-bold text-green-600">Rp. <?= rupiah($invest) ?></h2>
      </div>
    </div>

    <!-- CARD 2 -->
    <div class="p-5 border rounded-2xl shadow-sm flex items-center gap-4 hover:shadow-md transition">
      <div class="text-blue-600 text-4xl bg-blue-100 p-3 rounded-xl">
        <i class="">
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-banknote-arrow-down-icon lucide-banknote-arrow-down">
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
        <p class="text-sm text-gray-600">Total Pendapatan</p>
        <h2 id="tmasuk" class="text-xl font-bold text-blue-600">Rp. <?= rupiah($tmasuk) ?></h2>
      </div>
    </div>

    <!-- CARD 3 -->
    <div class="p-5 border rounded-2xl shadow-sm flex items-center gap-4 hover:shadow-md transition">
      <div class="text-red-600 text-4xl bg-red-100 p-3 rounded-xl">
        <i class="">
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-banknote-arrow-up-icon lucide-banknote-arrow-up">
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
        <p class="text-sm text-gray-600">Total Pengeluaran</p>
        <h2 id="tkeluar" class="text-xl font-bold text-red-600">Rp. <?= rupiah($tkeluar) ?></h2>
      </div>
    </div>

    <!-- CARD 4 -->
    <div class="p-5 border rounded-2xl shadow-sm flex items-center gap-4 hover:shadow-md transition">
      <div class="text-orange-600 text-4xl bg-orange-100 p-3 rounded-xl">
        <i class="">
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-star-icon lucide-square-star">
            <path d="M11.035 7.69a1 1 0 0 1 1.909.024l.737 1.452a1 1 0 0 0 .737.535l1.634.256a1 1 0 0 1 .588 1.806l-1.172 1.168a1 1 0 0 0-.282.866l.259 1.613a1 1 0 0 1-1.541 1.134l-1.465-.75a1 1 0 0 0-.912 0l-1.465.75a1 1 0 0 1-1.539-1.133l.258-1.613a1 1 0 0 0-.282-.866l-1.156-1.153a1 1 0 0 1 .572-1.822l1.633-.256a1 1 0 0 0 .737-.535z" />
            <rect x="3" y="3" width="18" height="18" rx="2" />
          </svg>
        </i>
      </div>
      <div>
        <p class="text-sm text-gray-600">Total Aset</p>
        <h2 class="text-l font-bold text-orange-600">Rp. <?= rupiah($aset) ?></h2>
      </div>
    </div>

  </div>

  <!-- ASET & HUTANG PIUTANG -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <!-- CARD 1 -->
    <div class="p-5 border rounded-2xl shadow-sm flex items-center gap-4 hover:shadow-md transition">
      <div class="text-amber-600 text-4xl bg-amber-100 p-3 rounded-xl">
        <i class="">
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building-icon lucide-building">
            <path d="M12 10h.01" />
            <path d="M12 14h.01" />
            <path d="M12 6h.01" />
            <path d="M16 10h.01" />
            <path d="M16 14h.01" />
            <path d="M16 6h.01" />
            <path d="M8 10h.01" />
            <path d="M8 14h.01" />
            <path d="M8 6h.01" />
            <path d="M9 22v-3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3" />
            <rect x="4" y="2" width="16" height="20" rx="2" />
          </svg>
        </i>
      </div>
      <div>
        <p class="text-sm text-gray-600">Aset Tetap</p>
        <h2 class="text-xl font-bold text-amber-600">Rp. <?= rupiah($fixedaset) ?></h2>
      </div>
    </div>

    <!-- CARD 2 -->
    <div class="p-5 border rounded-2xl shadow-sm flex items-center gap-4 hover:shadow-md transition">
      <div class="text-blue-600 text-4xl bg-blue-100 p-3 rounded-xl">
        <i class="">
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-coins-icon lucide-coins">
            <path d="M13.744 17.736a6 6 0 1 1-7.48-7.48" />
            <path d="M15 6h1v4" />
            <path d="m6.134 14.768.866-.5 2 3.464" />
            <circle cx="16" cy="8" r="6" />
          </svg>
        </i>
      </div>
      <div>
        <p class="text-sm text-gray-600">Aset Tidak Tetap</p>
        <h2 id="tmasuk" class="text-xl font-bold text-blue-600">Rp. <?= rupiah($nfixedaset) ?></h2>
      </div>
    </div>

    <!-- CARD 3 -->
    <div class="p-5 border rounded-2xl shadow-sm flex items-center gap-4 hover:shadow-md transition">
      <div class="text-red-600 text-4xl bg-red-100 p-3 rounded-xl">
        <i class="">
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-alert-icon lucide-book-alert">
            <path d="M12 13h.01" />
            <path d="M12 6v3" />
            <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20" />
          </svg>
        </i>
      </div>
      <div>
        <p class="text-sm text-gray-600">Total Hutang</p>
        <h2 id="hutang" class="text-xl font-bold text-red-600">Rp. <?= rupiah($hutang) ?></h2>
      </div>
    </div>

    <!-- CARD 4 -->
    <div class="p-5 border rounded-2xl shadow-sm flex items-center gap-4 hover:shadow-md transition">
      <div class="text-green-600 text-4xl bg-green-100 p-3 rounded-xl">
        <i class="">
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-plus-icon lucide-book-plus">
            <path d="M12 7v6" />
            <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20" />
            <path d="M9 10h6" />
          </svg>
        </i>
      </div>
      <div>
        <p class="text-sm text-gray-600">Total Piutang</p>
        <h2 id="piutang" class="text-l font-bold text-green-600">Rp. <?= rupiah($piutang) ?></h2>
      </div>
    </div>

  </div>

  <!-- FILTER -->
  <form id="formCetak" action="<?= base_url('laporan/preview') ?>" method="get" target="_blank" class="flex flex-wrap gap-4 items-end">

    <div class="relative w-full max-w-xs">
      <input
        name="from"
        type="date"
        class="w-full border border-gray-300 rounded-xl px-3 py-2
           shadow-sm bg-white text-gray-700
           focus:outline-none focus:ring-2 focus:ring-green-500
           focus:border-green-500
           transition duration-200">
    </div>

    <div class="relative w-full max-w-xs">
      <input
        name="to"
        type="date"
        class="w-full border border-gray-300 rounded-xl px-3 py-2
           shadow-sm bg-white text-gray-700
           focus:outline-none focus:ring-2 focus:ring-green-500
           focus:border-green-500
           transition duration-200">
    </div>

    <select name="jenis" class="border rounded-lg px-3 py-2">
      <option value="Semua">Semua</option>
      <option value="Penghasilan">Penghasilan</option>
      <option value="Pengeluaran">Pengeluaran</option>
      <option value="Rencana">Rencana/Investasi</option>
    </select>

    <button type="submit"
      class="bg-red-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
      <i class="">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-up-icon lucide-file-up">
          <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
          <path d="M14 2v5a1 1 0 0 0 1 1h5" />
          <path d="M12 12v6" />
          <path d="m15 15-3-3-3 3" />
        </svg>
      </i> Cetak PDF
    </button>

  </form>

  <script>
    // function loadTotalBulanIni() {
    //   fetch("<?= base_url('laporan/total') ?>", {
    //       headers: {
    //         'X-Requested-With': 'XMLHttpRequest'
    //       }
    //     })
    //     .then(res => res.json())
    //     .then(res => {
    //       console.log(res);
    //       document.getElementById('keluar').innerText =
    //         'Rp ' + Number(res.pengeluaran).toLocaleString('id-ID');

    //       document.getElementById('masuk').innerText =
    //         'Rp ' + Number(res.penghasilan).toLocaleString('id-ID');

    //       document.getElementById('tmasuk').innerText =
    //         'Rp ' + Number(res.thasil).toLocaleString('id-ID');

    //       document.getElementById('tkeluar').innerText =
    //         'Rp ' + Number(res.tkeluar).toLocaleString('id-ID');

    //       document.getElementById('hutang').innerText =
    //         'Rp ' + Number(res.hutang).toLocaleString('id-ID');

    //       document.getElementById('piutang').innerText =
    //         'Rp ' + Number(res.piutang).toLocaleString('id-ID');

    //     });
    // }

    // loadTotalBulanIni();

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