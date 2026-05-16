<!-- merender template layout -->
<?= $this->extend('layout/default') ?>

<!-- merender title halaman -->
<?= $this->section('title') ?>
<title>Rekening &mdash; DuitKu</title>
<?= $this->endSection() ?>

<!-- merender conten halaman -->
<?= $this->section('content') ?>
<div class="pt-20 max-w-7xl mx-auto px-6 space-y-4 animate-fade">

  <!-- FILTER DATA TRANSAKSI -->
  <div class="flex flex-wrap gap-4 items-end">
    <button
      onclick="resetForm(); openForm()"
      class="bg-green-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-green-700 transition"
      id="tambah-rekening">
      <i class="">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus">
          <path d="M5 12h14" />
          <path d="M12 5v14" />
        </svg>
      </i> Tambah
    </button>

    <select id="perPage" class="border rounded-lg px-2 py-2">
      <option value="8">8</option>
      <option value="10">10</option>
      <option value="25">25</option>
    </select>

    <input
      type="text"
      id="search"
      placeholder="Cari rekening..."
      class="border rounded-lg px-3 py-2 w-64">

    <select id="filterJenis" class="border rounded-lg px-2 py-2">
      <option value="">Semua Jenis</option>
      <option value="Operasional">Operasional</option>
      <option value="Tabungan">Tabungan</option>
      <option value="Cadangan">Cadangan</option>
      <option value="Investasi">Investasi</option>
    </select>

  </div>
  <!-- TABLE -->
  <div class="overflow-x-auto border rounded-lg shadow-sm">
    <table class="w-full text-sm">
      <thead class="bg-gray-100">
        <tr>
          <th class="p-3 text-left">Nama Bank</th>
          <th class="p-3">Nomor Rekening</th>
          <th class="p-3">Saldo</th>
          <th class="p-3">Prioritas</th>
          <th class="p-3">Aksi</th>
        </tr>
      </thead>
      <tbody id="kategoriBody">
        <!-- isi data dari ajax -->
      </tbody>
    </table>
    <div class="w-full flex justify-center mt-4 mb-3">
      <div id="pagination" class="flex gap-1"></div>
    </div>
  </div>
</div>

<!-- MODAL FORM TAMBAH REKENING -->
<div
  id="modal-tambah-rekening"
  onclick="closeForm()"
  class="hidden fixed inset-0 bg-black/40 flex items-center justify-center">

  <div
    onclick="event.stopPropagation()"
    class="bg-white p-6 rounded-xl w-full max-w-md animate-slide">
    <h2 class="font-bold mb-4">Form Rekening</h2>
    <form id="formRekening">
      <?= csrf_field(); ?>
      <input type="hidden" id="id_rekening">

      <input type="text" id="nama_bank" name="nama_bank" placeholder="Nama Bank"
        class="w-full border rounded-lg px-3 py-2 mb-3">
      <input type="text" id="no_rekening" name="no_rekening" placeholder="Nomor Rekening"
        class="w-full border rounded-lg px-3 py-2 mb-3">
      <input type="text" id="saldo" name="saldo" placeholder="Saldo Awal"
        class="w-full border rounded-lg px-3 py-2 mb-3">
      <select name="prioritas" id="prioritas" class="w-full border rounded-lg px-3 py-2 mb-3">
        <option value="">Prioritas Penggunaan</option>
        <option value="Operasional">Operasional</option>
        <option value="Tabungan">Tabungan</option>
        <option value="Cadangan">Cadangan</option>
        <option value="Investasi">Investasi</option>
      </select>

      <div class="flex justify-end gap-3">
        <button type="button"
          class="px-4 py-2 border-2 border-red-400 text-red-500 rounded-lg hover:bg-red-100 transition"
          onclick="closeForm()">
          Batal
        </button>
        <button type="submit"
          class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
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
    <div class="flex justify-end gap-2">
      <button onclick="closeDelete()">Batal</button>
      <button class="bg-red-600 text-white px-4 py-2 rounded">Hapus</button>
    </div>
  </div>
</div>


<script>
  // membuka modal
  function openForm() {
    document.getElementById('modal-tambah-rekening').classList.remove('hidden');
  }

  //menutup modal
  function closeForm() {
    document.getElementById('modal-tambah-rekening').classList.add('hidden');
  }

  //membuka modal hapus data
  function openDelete() {
    document.getElementById('modalDelete').classList.remove('hidden');
  }

  //reset form untuk mengosongkan inputan
  function resetForm() {
    document.getElementById('formRekening').reset();

    document.getElementById('id_rekening').value = '';
    document.getElementById('nama_bank').value = '';
    document.getElementById('no_rekening').value = '';
    document.getElementById('saldo').value = '';
    document.getElementById('prioritas').value = '';
  }

  // menutup modal hapus data
  function closeDelete() {
    document.getElementById('modalDelete').classList.add('hidden');
  }

  // format warna saldo
  function warnaSaldo(nominal) {
    if (nominal > 100000) return 'text-green-600';
    if (nominal < 100000) return 'text-red-600';
    return 'text-gray-500';
  }

  function formatRupiah(n) {
    if (!n) return '-';
    return 'Rp ' + Number(n).toLocaleString('id-ID');
  }

  //membuat tampilan pagination
  let currentPage = 1;

  function fetchRekening(page = 1) {
    currentPage = page;

    const perPage = document.getElementById('perPage').value;
    const keyword = document.getElementById('search').value;
    const prioritas = document.getElementById('filterJenis').value;

    fetch(`<?= base_url('rekening/data') ?>?page_rekening=${page}&perPage=${perPage}&keyword=${keyword}&prioritas=${prioritas}`)
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
        <td class="p-3">${item.nama_bank}</td>
        <td class="p-3 text-center">${item.no_rekening}</td>
        <td class="p-3 text-center ${warnaSaldo(item.saldo)}">${formatRupiah(item.saldo)}</td>
        <td class="p-3 text-center">${item.prioritas ?? '-'}</td>
        <td class="p-3 text-center">
          <div class="flex justify-center gap-3">
            <button class="text-green-600" 
            onclick="editRekening(${item.id_rekening})">
              <i class="fa fa-pen"></i>
            </button>
            <button onclick="hapusRekening(${item.id_rekening})" 
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
        onclick="${!disabled ? `fetchRekening(${page})` : ''}"
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
    fetchRekening(1);
  });

  // initial load
  fetchRekening();

  //mengedit data
  function editRekening(id) {
    fetch(`<?= base_url('rekening/show') ?>/${id}`)
      .then(res => res.json())
      .then(res => {
        document.getElementById('id_rekening').value = res.id_rekening;
        document.getElementById('nama_bank').value = res.nama_bank;
        document.getElementById('no_rekening').value = res.no_rekening;
        document.getElementById('saldo').value = res.saldo;
        document.getElementById('prioritas').value = res.prioritas;

        openForm();
      });
  }

  //fungsi tambah atau edit tergantung ada id atau tidak
  document.getElementById('formRekening').addEventListener('submit', function(e) {
    e.preventDefault();

    const id = document.getElementById('id_rekening').value;

    const url = id ?
      `<?= base_url('rekening/update') ?>/${id}` :
      `<?= base_url('rekening/simpan') ?>`;

    fetch(url, {
        method: 'POST',
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: new FormData(this)
      })
      .then(res => res.json())
      .then(res => {
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

        if (url == `<?= base_url('rekening/update') ?>/${id}`) {
          Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Data berhasil Diedit',
            showConfirmButton: false,
            timer: 1400
          });
        } else {
          Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Data berhasil Ditambah',
            showConfirmButton: false,
            timer: 1400
          });
        }
        fetchRekening(currentPage); // reload data + pagination tetap
        this.reset();
        document.getElementById('id_rekening').value = '';
      });
  });

  //hapus data
  function deleteRekening(id) {
    fetch(`<?= base_url('rekening/delete') ?>/${id}`, {
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

        if (document.querySelectorAll('#kategoriBody tr').length === 1 && currentPage > 1) {
          currentPage--;
        }

        fetchRekening(currentPage);
      });
  }

  function hapusRekening(id) {
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
        deleteRekening(id);
      }
    });
  }

  function confirmDelete() {
    const id = document.getElementById('delete_id').value;

    fetch(`<?= base_url('rekening/delete') ?>/${id}`, {
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

        fetchRekening(currentPage);
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
      fetchRekening(1);
    }, 400);
  });

  //filter data tergantung jenis
  document.getElementById('filterJenis').addEventListener('change', () => {
    fetchRekening(1);
  });
</script>
<?= $this->endSection() ?>