<!-- merender template layout -->
<?= $this->extend('layout/default') ?>

<!-- merender title halaman -->
<?= $this->section('title') ?>
<title>Kategori &mdash; DuitKu</title>
<?= $this->endSection() ?>

<!-- merender conten halaman -->
<?= $this->section('content') ?>
<div class="pt-20 max-w-7xl mx-auto px-6 space-y-4 animate-fade">

  <!-- FILTER DATA TRANSAKSI -->
  <div class="flex flex-wrap gap-4 items-end">
    <button
      onclick="resetForm(); openForm()"
      class="bg-green-600 text-white px-4 py-2 rounded-lg"
      id="tambah-kategori">
      <i class="fa fa-plus"></i> Tambah
    </button>

    <select id="perPage" class="border rounded-lg px-2 py-2">
      <option value="10">10</option>
      <option value="15">15</option>
      <option value="25">25</option>
      <option value="30">30</option>
    </select>

    <input
      type="text"
      id="search"
      name="search"
      placeholder="Cari kategori..."
      class="border rounded-lg px-3 py-2 w-64">

    <select id="filterJenis" class="border rounded-lg px-2 py-2">
      <option value="">Semua Jenis</option>
      <option value="Penghasilan">Penghasilan</option>
      <option value="Pengeluaran">Pengeluaran</option>
    </select>
    <!-- cek apakah ada keyword atau tidak -->
    <?php
    $request = \Config\Services::request();
    $keyword = $request->getVar('search');
    if ($keyword != '') {
      $param = "?keyword=" . $keyword;
    } else {
      $param = '';
    }
    ?>
    <a class="bg-blue-500 text-white px-4 py-2 rounded-lg" href="/kategori/exportxls<?= $param; ?>">
      <i class="fas fa-download"></i>
      Export
    </a>

  </div>

  <?php if (session()->getFlashdata('success')) : ?>
    <div class="bg-green-100 text-green-700 px-4 py-2 rounded">
      <?= session()->getFlashdata('success') ?>
    </div>
  <?php endif; ?>

  <!-- TABLE -->
  <div class="overflow-x-auto border rounded-lg shadow-sm">
    <table class="w-full text-sm">
      <thead class="bg-gray-100">
        <tr>
          <th class="p-3 text-left">Jenis</th>
          <th class="p-3">Bidang</th>
          <th class="p-3">Rincian</th>
          <th class="p-3">Deskripsi</th>
          <th class="p-3">Aksi</th>
        </tr>
      </thead>
      <tbody id="kategoriBody"></tbody>
    </table>
    <div class="w-full flex justify-center mt-4 mb-3">
      <div id="pagination" class="flex gap-1"></div>
    </div>
  </div>
</div>

<!-- MODAL FORM TAMBAH KATEGORI -->
<div
  id="modal-tambah-kategori"
  onclick="closeForm()"
  class="hidden fixed inset-0 bg-black/40 flex items-center justify-center">

  <div
    onclick="event.stopPropagation()"
    class="bg-white p-6 rounded-xl w-full max-w-md animate-slide">
    <h2 class="font-bold mb-4">Form Kategori</h2>
    <form id="formKategori">
      <?= csrf_field(); ?>
      <input type="hidden" id="id_kategori">
      <select name="jenis" id="jenis" class="w-full border rounded-lg px-3 py-2 mb-3">
        <option value="">Pilih Jenis</option>
        <option value="Pemasukan">Pemasukan</option>
        <option value="Pengeluaran">Pengeluaran</option>
      </select>

      <select name="bidang" id="bidang" class="w-full border rounded-lg px-3 py-2 mb-3">
        <option value="">Pilih Bidang</option>
        <option value="Penghasilan">Penghasilan</option>
        <option value="Pengeluaran">Pengeluaran</option>
      </select>

      <input type="text" id="rincian" name="rincian" placeholder="Rincian"
        class="w-full border rounded-lg px-3 py-2 mb-3">

      <input type="text" id="deskripsi" name="deskripsi" placeholder="Deskripsi"
        class="w-full border rounded-lg px-3 py-2 mb-3">

      <div class="flex justify-end gap-2">
        <button type="button" onclick="closeForm()">Batal</button>
        <button type="submit"
          class="bg-blue-600 text-white px-4 py-2 rounded-lg">
          Simpan
        </button>
      </div>
    </form>

  </div>
</div>

<!-- MODAL DELETE -->
<div
  id="modalDelete"
  class="hidden fixed inset-0 bg-black/40 flex items-center justify-center">
  <div class="bg-white p-6 rounded-xl w-full max-w-sm animate-slide">
    <p class="mb-4">Yakin ingin menghapus data?</p>

    <input type="hidden" id="delete_id">

    <div class="flex justify-end gap-2">
      <button onclick="closeDelete()">Batal</button>
      <button
        onclick="confirmDelete()"
        class="bg-red-600 text-white px-4 py-2 rounded">
        Hapus
      </button>
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
  const openLogout = () => modalLogout.classList.remove("hidden");
  const closeLogout = () => modalLogout.classList.add("hidden");

  //reset form untuk mengosongkan inputan
  function resetForm() {
    document.getElementById('formKategori').reset();

    document.getElementById('id_kategori').value = '';
    document.getElementById('jenis').value = '';
    document.getElementById('bidang').value = '';
    document.getElementById('rincian').value = '';
    document.getElementById('deskripsi').value = '';
  }

  // membuka modal
  function openForm() {
    document.getElementById('modal-tambah-kategori').classList.remove('hidden');
  }

  //menutup modal
  function closeForm() {
    document.getElementById('modal-tambah-kategori').classList.add('hidden');
  }

  //membuka modal hapus data
  function openDelete() {
    document.getElementById('modalDelete').classList.remove('hidden');
  }

  // menutup modal hapus data
  function closeDelete() {
    document.getElementById('modalDelete').classList.add('hidden');
  }


  //membuat tampilan pagination
  let currentPage = 1;

  function fetchKategori(page = 1) {
    currentPage = page;

    const perPage = document.getElementById('perPage').value;
    const keyword = document.getElementById('search').value;
    const bidang = document.getElementById('filterJenis').value;

    fetch(`<?= base_url('kategori/data') ?>?page_kategori=${page}&perPage=${perPage}&keyword=${keyword}&bidang=${bidang}`)
      .then(res => res.json())
      .then(res => {
        renderTable(res.data);
        renderPagination(res.totalPage, res.current);
      });
  }

  // menampilkan data tabel dengan ajax
  function renderTable(data) {
    const tbody = document.getElementById('kategoriBody');
    tbody.innerHTML = '';

    data.forEach(item => {
      tbody.innerHTML += `
      <tr class="border-t">
        <td class="p-2">${item.jenis}</td>
        <td class="p-2 text-center">${item.bidang}</td>
        <td class="p-2 text-center text-green-600">${item.rincian ?? '-'}</td>
        <td class="p-2 text-center">${item.deskripsi ?? '-'}</td>
        <td class="p-2 text-center">
          <div class="flex justify-center gap-3">
            <button class="text-green-600" 
            onclick="editKategori(${item.id_kategori})">
              <i class="fa fa-pen"></i>
            </button>
            <button onclick="hapusKategori(${item.id_kategori})" 
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
      <button
        ${disabled ? 'disabled' : ''}
        onclick="${!disabled ? `fetchKategori(${page})` : ''}"
        class="
          px-3 py-1 border rounded
          text-sm
          transition
          ${active ? 'bg-blue-600 text-white cursor-default' : 'hover:bg-gray-100'}
          ${disabled ? 'opacity-50 cursor-not-allowed' : ''}
        ">
        ${label}
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

  document.getElementById('perPage').addEventListener('change', () => {
    fetchKategori(1);
  });

  // initial load
  fetchKategori();

  //mengedit data
  function editKategori(id) {
    fetch(`<?= base_url('kategori/show') ?>/${id}`)
      .then(res => res.json())
      .then(res => {
        document.getElementById('id_kategori').value = res.id_kategori;
        document.getElementById('jenis').value = res.jenis;
        document.getElementById('bidang').value = res.bidang;
        document.getElementById('rincian').value = res.rincian;
        document.getElementById('deskripsi').value = res.deskripsi;

        openForm();
      });
  }

  //fungsi tambah atau edit tergantung ada id atau tidak
  document.getElementById('formKategori').addEventListener('submit', function(e) {
    e.preventDefault();

    const id = document.getElementById('id_kategori').value;

    const url = id ?
      `<?= base_url('kategori/update') ?>/${id}` :
      `<?= base_url('kategori/simpan') ?>`;

    fetch(url, {
        method: 'POST',
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: new FormData(this)
      })
      .then(res => res.json())
      .then(res => {
        //validasi
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

        closeForm();

        if (id) {
          Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Data Berhasil Diedit',
            showConfirmButton: false,
            timer: 1200
          });
        } else {
          Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Data Berhasil Ditambah',
            showConfirmButton: false,
            timer: 1200
          });
        }
        fetchKategori(currentPage); // reload data + pagination tetap
        this.reset();
        document.getElementById('id_kategori').value = '';
      });
  });

  //hapus data
  function deleteKategori(id) {
    fetch(`<?= base_url('kategori/delete') ?>/${id}`, {
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
          timer: 2000
        });

        if (document.querySelectorAll('#kategoriBody tr').length === 1 && currentPage > 1) {
          currentPage--;
        }

        fetchKategori(currentPage);
      });
  }

  function hapusKategori(id) {
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
        deleteKategori(id);
      }
    });
  }

  function confirmDelete() {
    const id = document.getElementById('delete_id').value;

    fetch(`<?= base_url('kategori/delete') ?>/${id}`, {
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

        if (document.querySelectorAll('#kategoriBody tr').length === 1 && currentPage > 1) {
          currentPage--;
        }

        fetchKategori(currentPage);
      })
      .catch(err => {
        console.error(err);
        alert('Gagal menghapus data');
      });
  }

  //pencarian data realtime
  let searchTimer = null;

  document.getElementById('search').addEventListener('keyup', function() {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => {
      fetchKategori(1);
    }, 400);
  });

  //filter data tergantung jenis
  document.getElementById('filterJenis').addEventListener('change', () => {
    fetchKategori(1);
  });

  function exportExcel() {
    const keyword = document.getElementById('search').value;
    fetch()
    // mulai dari sini
  }
</script>
<?= $this->endSection() ?>