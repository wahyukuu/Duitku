<!-- merender template layout -->
<?= $this->extend('layout/default') ?>

<!-- merender title halaman -->
<?= $this->section('title') ?>
<title>Aset &mdash; DuitKu</title>
<?= $this->endSection() ?>

<!-- merender conten halaman -->
<?= $this->section('content') ?>
<div class="pt-20 max-w-7xl mx-auto px-4 space-y-4 animate-fade">

  <!-- FILTER DATA ASET -->
  <div class="flex flex-wrap gap-2 items-end">
    <select id="perPage" class="border rounded-xl px-2 py-2">
      <option value="8">8</option>
      <option value="10">10</option>
      <option value="25">25</option>
    </select>
    <input type="date" id="dateFilter1" name="from" class="border rounded-lg px-3 py-2" />
    <input type="date" id="dateFilter2" name="to" class="border rounded-lg px-3 py-2" />
    <input type="text" id="search" placeholder="Cari aset..." class="border rounded-lg px-3 py-2 w-64">
    <select id="filterAset" name="filterAset" class="border rounded-lg px-3 py-2">
      <option value="">Semua Aset</option>
      <option value="Kendaraan">Kendaraan</option>
      <option value="Bangunan">Bangunan</option>
      <option value="Tanah">Tanah</option>
      <option value="Peralatan">Peralatan</option>
      <option value="Mesin">Mesin</option>
      <option value="Peralatan Lainnya">Peralatan Lainnya</option>
      <option value="Aset Lainnya">Aset Lainnya</option>
    </select>
    <button
      onclick="resetForm(); openForm()"
      class="bg-green-600 hover:bg-green-700 transition text-white px-4 py-2 rounded-lg flex items-center gap-2">
      <i class="">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus">
          <path d="M5 12h14" />
          <path d="M12 5v14" />
        </svg>
      </i> Tambah Aset
    </button>
    <button
      onclick="exportpdf();"
      class="bg-blue-600 hover:bg-blue-700 transition text-white px-4 py-2 rounded-lg flex items-center gap-2">
      <i class="">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-up-icon lucide-file-up">
          <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
          <path d="M14 2v5a1 1 0 0 0 1 1h5" />
          <path d="M12 12v6" />
          <path d="m15 15-3-3-3 3" />
        </svg>
      </i> Export PDF
    </button>
  </div>

  <div class="p-4 border rounded-xl shadow-sm bg-white w-fit flex items-center gap-4">

    <!-- ICON -->
    <div class="text-green-600 bg-green-100 p-3 rounded-xl shrink-0">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
        class="w-12 h-12">
        <path d="M12 18H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5" />
        <path d="m16 19 3 3 3-3" />
        <path d="M18 12h.01" />
        <path d="M19 16v6" />
        <path d="M6 12h.01" />
        <circle cx="12" cy="12" r="2" />
      </svg>
    </div>
    <!-- CONTENT -->
    <div>
      <p class="text-sm text-gray-600">
        Total Nilai Aset
      </p>
      <h2 id="totalAset" class="text-2xl font-bold text-green-600">
        Rp 0
      </h2>
    </div>
  </div>

  <!-- TABLE -->
  <div class="overflow-x-auto border rounded-xl shadow-sm">
    <table class="w-full text-sm">
      <thead class="bg-gray-100">
        <tr>
          <th class="p-3 text-left">Nama Aset</th>
          <th class="p-3">Jenis</th>
          <th class="p-3">Jumlah</th>
          <th class="p-3">Satuan</th>
          <th class="p-3">Cara Perolehan</th>
          <th class="p-3">Tahun</th>
          <th class="p-3">Detail</th>
          <th class="p-3">Nilai Beli</th>
          <th class="p-3">Aksi</th>
        </tr>
      </thead>
      <tbody id="asetBody">

      </tbody>
    </table>
    <div class="w-full flex justify-center mt-4 mb-3">
      <div id="pagination" class="flex gap-1"></div>
    </div>
  </div>
</div>

<!-- MODAL FORM -->
<div
  id="modal-tambah-aset"
  class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50"
  onclick="closeForm()">

  <div class="bg-white p-4 rounded-2xl w-full max-w-3xl max-h-[90vh] flex flex-col"
    onclick="event.stopPropagation()">

    <!-- HEADER FIXED -->
    <div class="p-2 border-b sticky top-0 bg-white z-10">
      <h2 class="text-xl font-bold">Form Aset</h2>
    </div>

    <!-- content -->
    <div class="p-6 overflow-y-auto">
      <form id="formAset" class="grid grid-cols-2 gap-4">
        <?= csrf_field(); ?>

        <input type="hidden" id="id_aset" name="id_aset">

        <!-- Nama Aset -->
        <div>
          <label class="block text-sm font-medium mb-1">Nama Aset</label>
          <input type="text" id="nama_aset" name="nama_aset"
            placeholder="Masukkan nama aset"
            class="w-full border rounded-lg px-3 py-2" />
        </div>

        <!-- Jenis Aset -->
        <div>
          <label class="block text-sm font-medium mb-1">Jenis Aset</label>
          <select id="jenis_aset" name="jenis_aset"
            class="w-full border rounded-lg px-3 py-2">
            <option value="Kendaraan">Kendaraan</option>
            <option value="Bangunan">Bangunan</option>
            <option value="Tanah">Tanah</option>
            <option value="Peralatan">Peralatan</option>
            <option value="Mesin">Mesin</option>
            <option value="Peralatan Lainnya">Peralatan Lainnya</option>
            <option value="Aset Lainnya">Aset Lainnya</option>
          </select>
        </div>

        <!-- Jumlah -->
        <div>
          <label class="block text-sm font-medium mb-1">Jumlah</label>
          <input type="number" id="jumlah" name="jumlah"
            placeholder="Masukkan jumlah"
            class="w-full border rounded-lg px-3 py-2" />
        </div>

        <!-- Satuan -->
        <div>
          <label class="block text-sm font-medium mb-1">Satuan</label>
          <input type="text" id="satuan" name="satuan"
            placeholder="Contoh: Unit, Buah, Meter"
            class="w-full border rounded-lg px-3 py-2" />
        </div>

        <!-- Cara Perolehan -->
        <div>
          <label class="block text-sm font-medium mb-1">Cara Perolehan</label>
          <select id="cara_perolehan" name="cara_perolehan"
            class="w-full border rounded-lg px-3 py-2">
            <option value="Pembelian">Pembelian</option>
            <option value="Hibah">Hibah</option>
            <option value="Warisan">Warisan</option>
            <option value="Bagi Hasil">Bagi Hasil</option>
          </select>
        </div>

        <!-- Tahun Perolehan -->
        <div>
          <label class="block text-sm font-medium mb-1">Tahun Perolehan</label>
          <input type="date" id="tahun_perolehan" name="tahun_perolehan"
            class="w-full border rounded-lg px-3 py-2" />
        </div>

        <!-- Lokasi -->
        <div class="col-span-2">
          <label class="block text-sm font-medium mb-1">Lokasi</label>
          <input type="text" id="lokasi" name="lokasi"
            placeholder="Lokasi aset"
            class="w-full border rounded-lg px-3 py-2" />
        </div>

        <!-- Detail -->
        <div class="col-span-2">
          <label class="block text-sm font-medium mb-1">Detail Aset</label>
          <textarea id="detail" name="detail"
            rows="3"
            placeholder="Deskripsi atau keterangan tambahan"
            class="w-full border rounded-lg px-3 py-2"></textarea>
        </div>

        <!-- Nilai Perolehan -->
        <div>
          <label class="block text-sm font-medium mb-1">Nilai Perolehan</label>
          <div class="relative">
            <span class="absolute left-3 top-2.5 text-gray-400">Rp</span>
            <input
              type="text"
              id="nilai_perolehan"
              name="nilai_perolehan"
              class="w-full border rounded-lg pl-10 pr-3 py-2"
              placeholder="0"
              oninput="formatRupiah1(this)" />
          </div>
        </div>

        <!-- Nilai Sekarang -->
        <div>
          <label class="block text-sm font-medium mb-1">Nilai Sekarang</label>
          <div class="relative">
            <span class="absolute left-3 top-2.5 text-gray-400">Rp</span>
            <input
              type="text"
              id="nilai_sekarang"
              name="nilai_sekarang"
              class="w-full border rounded-lg pl-10 pr-3 py-2"
              placeholder="0"
              oninput="formatRupiah1(this)" />
          </div>
        </div>

        <!-- Button -->
        <div class="col-span-2 flex justify-end gap-3 mt-4">
          <button type="button" onclick="closeForm()"
            class="px-4 py-2 border-2 border-red-400 text-red-500 rounded-lg">
            Batal
          </button>
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
            Simpan
          </button>
        </div>

      </form>
    </div>


  </div>
</div>

<!-- MODAL DELETE -->
<div
  id="modalDelete"
  class="hidden fixed inset-0 bg-black/40 flex items-center justify-center">
  <div class="bg-white p-6 rounded-xl w-full max-w-sm animate-slide">
    <p class="mb-4">Yakin ingin menghapus data?</p>
    <div class="flex justify-end gap-2">
      <button onclick="closeDelete()">Batal</button>
      <button class="bg-red-600 text-white px-4 py-2 rounded">Hapus</button>
    </div>
  </div>
</div>


<script>
  // membuka modal form aset
  function openForm() {
    document.getElementById('modal-tambah-aset').classList.remove('hidden');
  }

  //menutup modal form aset
  function closeForm() {
    document.getElementById('modal-tambah-aset').classList.add('hidden');
  }

  //reset form untuk mengosongkan inputan
  function resetForm() {
    document.getElementById('formAset').reset();

    document.getElementById('id_aset').value = '';
    document.getElementById('nama_aset').value = '';
    document.getElementById('jenis_aset').value = '';
    document.getElementById('jumlah').value = '';
    document.getElementById('satuan').value = '';
    document.getElementById('cara_perolehan').value = '';
    document.getElementById('tahun_perolehan').value = '';
    document.getElementById('lokasi').value = '';
    document.getElementById('detail').value = '';
    document.getElementById('nilai_perolehan').value = '';
    document.getElementById('nilai_sekarang').value = '';
  }


  //membuka modal hapus data
  function openDelete() {
    document.getElementById('modalDelete').classList.remove('hidden');
  }

  // menutup modal hapus data
  function closeDelete() {
    document.getElementById('modalDelete').classList.add('hidden');
  }

  function formatRupiah1(input) {
    let angka = input.value.replace(/[^0-9]/g, '');
    let format = new Intl.NumberFormat('id-ID').format(angka);
    input.value = format;
  }

  //mengambil data pada halaman index dengan ajax
  let currentPage = 1;

  function fetchAset(page = 1) {
    currentPage = page;

    const perPage = document.getElementById('perPage').value;
    const keyword = document.getElementById('search').value;
    const jenis = document.getElementById('filterAset').value;

    fetch(`<?= base_url('aset/data') ?>?page_aset=${page}&perPage=${perPage}&keyword=${keyword}&jenis=${jenis}`)
      .then(res => res.json())
      .then(res => {
        renderTable(res.data);
        renderPagination(res.totalPage, res.current);

        // update total langsung dari response
        document.getElementById('totalAset').innerText =
          'Rp ' + Number(res.total).toLocaleString('id-ID');
      });
  }

  // menampilkan data tabel dengan ajax
  function renderTable(data) {
    const tbody = document.getElementById('asetBody');
    tbody.innerHTML = '';

    data.forEach(item => {
      tbody.innerHTML += `
      <tr class="border-t">
      <td class="p-3">${item.nama_aset}</td>
      <td class="p-3">${item.jenis_aset}</td>
      <td class="p-3">${item.jumlah}</td>
      <td class="p-3">${item.satuan}</td>
      <td class="p-3">${item.cara_perolehan}</td>
      <td class="p-3 text-center">${item.tahun_perolehan}</td>
      <td class="p-3 text-center ">${item.detail}</td>
      <td class="p-3 text-center">Rp. ${Number(item.nilai_perolehan).toLocaleString('id-ID')}</td>
      <td class="p-3 text-center">
      <div class="flex justify-center gap-3">
      <button class="text-green-600"
      onclick="editAset(${item.id_aset})">
      <i class="fa fa-pen"></i>
      </button>
      <button onclick="hapusAset(${item.id_aset})"
      class="text-red-600">
      <i class="fa fa-trash"></i>
      </button>
      </div>
      </td>
      </tr>
      `;
    });
  }

  //merender pagination
  function renderPagination(total, current) {
    const el = document.getElementById('pagination');
    el.innerHTML = '';

    if (total <= 1) return;

    const createBtn = (label, page, disabled = false, active = false) => {
      return `
  <button ${disabled ? 'disabled' : '' } onclick="${!disabled ? `fetchAset(${page})` : ''}" class="px-3 py-1 border rounded text-sm transition ${active ? 'bg-blue-600 text-white cursor-default' : 'hover:bg-gray-100'} ${disabled ? 'opacity-50 cursor-not-allowed' : ''}"> ${label}
  </button>
  `;
    };

    /* PREV */
    el.innerHTML += createBtn(
      '‹',
      current - 1,
      current === 1
    );

    const range = 2; // jumlah halaman kiri-kanan
    let start = Math.max(1, current - range);
    let end = Math.min(total, current + range);

    if (start > 1) {
      el.innerHTML += createBtn(1, 1);
      if (start > 2) el.innerHTML += `<span class="px-2 py-1">…</span>`;
    }

    for (let i = start; i <= end; i++) {
      el.innerHTML += createBtn(i, i, false, i === current);
    }

    if (end < total) {
      if (end < total - 1) el.innerHTML += `<span class="px-2 py-1">…</span>`;
      el.innerHTML += createBtn(total, total);
    }

    /* NEXT */
    el.innerHTML += createBtn(
      '›',
      current + 1,
      current === total
    );
  }

  document.getElementById('search').addEventListener('keyup', () => {
    fetchAset(1);
  });

  document.getElementById('filterAset').addEventListener('change', () => {
    fetchAset(1);
  });

  document.getElementById('perPage').addEventListener('change', () => {
    fetchAset(1);
  });

  // initial load untuk memuat data transaksi
  fetchAset();

  //mengedit data
  async function editAset(id) {
    const response = await fetch(`<?= base_url('aset/show') ?>/${id}`);
    const res = await response.json();

    console.log(res);

    openForm();

    // isi dulu yang tidak tergantung 
    document.getElementById('id_aset').value = res.id_aset;
    document.getElementById('nama_aset').value = res.nama_aset;
    document.getElementById('jenis_aset').value = res.jenis_aset;
    document.getElementById('jumlah').value = res.jumlah;
    document.getElementById('satuan').value = res.satuan;
    document.getElementById('cara_perolehan').value = res.cara_perolehan;
    document.getElementById('tahun_perolehan').value = res.tahun_perolehan;
    document.getElementById('lokasi').value = res.lokasi;
    document.getElementById('detail').value = res.detail;
    document.getElementById('nilai_perolehan').value = res.nilai_perolehan;
    document.getElementById('nilai_sekarang').value = res.nilai_sekarang;
  }

  //fungsi tambah atau edit tergantung ada id atau tidak
  document.getElementById('formAset').addEventListener('submit', function(e) {
    e.preventDefault();

    const id = document.getElementById('id_aset').value;

    const url = id ?
      `<?= base_url('aset/update') ?>/${id}` :
      `<?= base_url('aset') ?>`;

    const formData = new FormData(this);

    // bersihkan format rupiah
    formData.set('nilai_perolehan',
      document.getElementById('nilai_perolehan').value.replace(/\D/g, '')
    );

    formData.set('nilai_sekarang',
      document.getElementById('nilai_sekarang').value.replace(/\D/g, '')
    );

    //biar kalo ada id methodnya berubah jadi PUT bukan POST
    if (id) {
      formData.append('_method', 'PUT');
    }
    fetch(url, {
        method: 'POST',
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData,
      })
      .then(res => res.json())
      .then(res => {
        // kalau gagal
        if (!res.status) {
          let pesan = '';

          if (res.errors) {
            Object.values(res.errors).forEach(err => {
              pesan += err + '<br>';
            });
          } else {
            pesan = res.message;
          }

          Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal',
            html: pesan
          });

          return;
        }

        // 🟢 Kalau sukses baru lanjut
        closeForm();

        if (id) {
          Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Data Aset berhasil Diedit',
            showConfirmButton: false,
            timer: 1700
          });
        } else {
          Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Data Aset berhasil Ditambah',
            showConfirmButton: false,
            timer: 1500
          });
        }

        fetchAset(currentPage);
        document.getElementById('formAset').reset();
        document.getElementById('id_aset').value = '';
      });
  });

  // MENGHAPUS DATA
  function deleteAset(id) {
    fetch(`<?= base_url('aset') ?>/${id}`, {
        method: 'DELETE',
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      .then(res => res.json())
      .then(res => {
        if (!res.status) {
          Swal.fire('Gagal', res.message, 'error');
          return;
        }

        Swal.fire({
          position: 'top-end',
          icon: 'success',
          title: 'Berhasil dihapus',
          showConfirmButton: false,
          timer: 1500
        });

        if (document.querySelectorAll('#asetBody tr').length === 1 && currentPage > 1) {
          currentPage--;
        }

        fetchAset(currentPage);
      });
  }

  function hapusAset(id) {
    Swal.fire({
      title: 'Yakin hapus?',
      text: 'Data tidak bisa dikembalikan',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#dc2626',
      confirmButtonText: 'Hapus',
      cancelButtonText: 'Batal'
    }).then(result => {
      if (result.isConfirmed) {
        deleteAset(id);
      }
    });
  }

  function confirmDelete() {
    const id = document.getElementById('delete_id').value;

    fetch(`<?= base_url('aset') ?>/${id}`, {
        method: 'DELETE',
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      .then(res => res.json())
      .then(res => {
        if (!res.status) {
          alert(res.message);
          return;
        }

        closeDelete();

        if (document.querySelectorAll('#asetBody tr').length === 1 && currentPage > 1) {
          currentPage--;
        }

        fetchAset(currentPage);
      })
      .catch(err => {
        console.error(err);
        alert('Gagal menghapus data');
      });
  }

  //cetak Riwayat Aset
  function exportpdf() {
    const perPage = document.getElementById('perPage').value;
    const keyword = document.getElementById('search').value;
    const jenis = document.getElementById('filterAset').value;
    const from = document.getElementById('dateFilter1').value;
    const to = document.getElementById('dateFilter2').value;

    const url = `<?= base_url('aset/export') ?>?perPage=${perPage}&keyword=${keyword}&jenis=${jenis}&from=${from}&to=${to}`;

    window.open(url, '_blank');
  }
</script>
<?= $this->endSection() ?>