<!-- merender template layout -->
<?= $this->extend('layout/default') ?>

<!-- merender title halaman -->
<?= $this->section('title') ?>
<title>Perencanaan &mdash; DuitKu</title>
<?= $this->endSection() ?>

<!-- merender conten halaman -->
<?= $this->section('content') ?>
<div class="pt-20 max-w-7xl mx-auto px-6 space-y-4 animate-fade">

  <!-- FILTER DATA TRANSAKSI -->
  <div class="flex flex-wrap gap-4 items-end">
    <button
      onclick="resetForm(); loadRekeningPrioritas(); openForm()"
      class="bg-green-600 text-white px-4 py-2 rounded-lg">
      <i class="fa fa-plus"></i> Tambah
    </button>

    <select id="perPage" class="border rounded-lg px-2 py-2">
      <option value="8">8</option>
      <option value="10">10</option>
      <option value="25">25</option>
    </select>

    <input
      type="text"
      id="search"
      placeholder="Cari rencana..."
      class="border rounded-lg px-3 py-2 w-64">

    <select id="filterJenis" class="border rounded-lg px-2 py-2">
      <option value="">Semua Jenis</option>
      <option value="Pendek">Pendek</option>
      <option value="Menengah">Menengah</option>
      <option value="Panjang">Panjang</option>
    </select>
  </div>

  <!-- TABLE -->
  <div class="overflow-x-auto border rounded-lg shadow-sm">
    <table class="w-full text-sm">
      <thead class="bg-gray-100">
        <tr>
          <th class="p-3 text-left">Deskripsi</th>
          <th class="p-3">Target</th>
          <th class="p-3">Rekening</th>
          <th class="p-3">Jumlah Sementara</th>
          <th class="p-3"> Jangka Waktu</th>
          <th class="p-3">Aksi</th>
        </tr>
      </thead>
      <tbody id="kategoriBody">

      </tbody>
    </table>
    <div class="w-full flex justify-center mt-4 mb-3">
      <div id="pagination" class="flex gap-1"></div>
    </div>
  </div>
</div>

<!-- MODAL FORM TAMBAH RENCANA -->
<div
  id="modal-tambah-rencana"
  onclick="closeForm()"
  class="hidden fixed inset-0 bg-black/40 flex items-center justify-center">

  <div
    onclick="event.stopPropagation()"
    class="bg-white p-6 rounded-xl w-full max-w-md animate-slide">
    <h2 class="font-bold mb-4">Form Rencana</h2>
    <form id="formRencana">
      <?= csrf_field(); ?>

      <input type="hidden" id="id_rencana">
      <input type="text" id="deskripsi" name="deskripsi" placeholder="Deskripsi Target"
        class="w-full border rounded-lg px-3 py-2 mb-3">
      <input type="text" id="target" name="target" placeholder="Jumlah Target"
        class="w-full border rounded-lg px-3 py-2 mb-3">
      <input type="hidden" id="id_rekening" name="id_rekening">
      <select id="nama_bank" name="nama_bank" class="w-full border rounded-lg px-3 py-2 mb-3">
        <option value="">Pilih Bank</option>
      </select>
      <input type="hidden" id="jlh_sementara" name="jlh_sementara" placeholder="Jumlah Target"
        class="w-full border rounded-lg px-3 py-2 mb-3">
      <div class="w-full bg-gray-200 rounded-full h-3 mb-3">
        <div
          id="progressBar"
          class="h-3 rounded-full bg-blue-600 transition-all"
          style="width: 0%">
        </div>
      </div>

      <p class="text-sm text-gray-600 mb-3">
        Progress: <span id="progressText">0%</span>
      </p>
      <select id="jangka" name="jangka" class="w-full border rounded-lg px-3 py-2 mb-3">
        <option value="">Pilih Waktu Realisasi</option>
        <option value="Pendek">Pendek</option>
        <option value="Menengah">Menengah</option>
        <option value="Panjang">Panjang</option>
      </select>

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

  function resetForm() {
    document.getElementById('formRencana').reset();

    document.getElementById('id_rencana').value = '';
    document.getElementById('id_rekening').value = '';
    document.getElementById('jlh_sementara').value = 0;

    // reset progress bar
    document.getElementById('progressBar').style.width = '0%';
    document.getElementById('progressBar').className =
      'h-3 rounded-full bg-blue-600 transition-all';
    document.getElementById('progressText').textContent = '0%';
  }

  // membuka modal
  function openForm() {
    document.getElementById('modal-tambah-rencana').classList.remove('hidden');
  }

  //menutup modal
  function closeForm() {
    document.getElementById('modal-tambah-rencana').classList.add('hidden');
  }

  //membuka modal hapus data
  function openDelete() {
    document.getElementById('modalDelete').classList.remove('hidden');
  }

  // menutup modal hapus data
  function closeDelete() {
    document.getElementById('modalDelete').classList.add('hidden');
  }

  // format warna saldo
  function warnaSaldo(nominal, pembanding) {
    if (nominal > pembanding) return 'text-green-600';
    if (nominal < pembanding) return 'text-red-600';
    return 'text-gray-500';
  }

  function formatRupiah(n) {
    if (!n) return '-';
    return 'Rp ' + Number(n).toLocaleString('id-ID');
  }

  //membuat tampilan pagination
  let currentPage = 1;

  function fetchRencana(page = 1) {
    currentPage = page;

    const perPage = document.getElementById('perPage').value;
    const keyword = document.getElementById('search').value;
    const jangka = document.getElementById('filterJenis').value;

    fetch(`<?= base_url('perencanaan/data') ?>?page_rencana=${page}&perPage=${perPage}&keyword=${keyword}&jangka=${jangka}`)
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
        <td class="p-3">${item.deskripsi}</td>
        <td class="p-3 text-center">${formatRupiah(item.target)}</td>
        <td class="p-3 text-center">${item.nama_bank}</td>
        <td class="p-3 text-center ${warnaSaldo(item.jlh_sementara, item.target)}">${formatRupiah(item.jlh_sementara)}</td>
        <td class="p-3 text-center">${item.jangka}</td>
        <td class="p-3 text-center">
          <div class="flex justify-center gap-3">
            <button class="text-green-600" 
            onclick="editRencana(${item.id_rencana})">
              <i class="fa fa-pen"></i>
            </button>
            <button onclick="hapusRencana(${item.id_rencana})" 
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
        onclick="${!disabled ? `fetchRencana(${page})` : ''}"
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
    fetchRencana(1);
  });

  // initial load
  fetchRencana();

  function loadRekeningPrioritas(selectedId = null) {
    fetch(`<?= base_url('perencanaan/tabungan') ?>`)
      .then(res => res.json())
      .then(data => {
        const select = document.getElementById('nama_bank');
        select.innerHTML = '<option value="">Pilih Bank</option>';

        data.forEach(item => {
          select.innerHTML += `
          <option value="${item.id_rekening}">
            ${item.nama_bank} - ${item.prioritas}
          </option>
        `;
        });

        if (selectedId) {
          select.value = selectedId;

          // 🔥 trigger onchange manual
          select.dispatchEvent(new Event('change'));
        }
      });
  }

  function updateProgress() {
    const target = Number(document.getElementById('target').value);
    const current = Number(document.getElementById('jlh_sementara').value);

    if (!target || target <= 0) return;

    let percent = Math.min((current / target) * 100, 100);

    const bar = document.getElementById('progressBar');
    const text = document.getElementById('progressText');

    bar.style.width = percent + '%';
    bar.className =
      percent >= 100 ?
      'h-3 rounded-full bg-green-600 transition-all' :
      'h-3 rounded-full bg-blue-600 transition-all';

    text.textContent = percent.toFixed(1) + '%';
  }

  document.getElementById('nama_bank').addEventListener('change', function() {
    const idRek = this.value;

    document.getElementById('id_rekening').value = idRek;

    if (!idRek) return;

    fetch(`<?= base_url('perencanaan/saldo') ?>/${idRek}`)
      .then(res => res.json())
      .then(res => {
        document.getElementById('jlh_sementara').value = res.saldo ?? 0;
        updateProgress(); // 🔥 trigger progress bar
      });
  });


  //mengedit data
  function editRencana(id) {
    fetch(`<?= base_url('perencanaan/show') ?>/${id}`)
      .then(res => res.json())
      .then(res => {
        document.getElementById('id_rencana').value = res.id_rencana;
        document.getElementById('deskripsi').value = res.deskripsi;
        document.getElementById('target').value = res.target;
        document.getElementById('jangka').value = res.jangka;

        loadRekeningPrioritas(res.id_rekening);
        // document.getElementById('id_rekening').value = res.id_rekening;

        openForm();
      });
  }

  //fungsi tambah atau edit tergantung ada id atau tidak
  document.getElementById('formRencana').addEventListener('submit', function(e) {
    e.preventDefault();

    const id = document.getElementById('id_rencana').value;

    const url = id ?
      `<?= base_url('perencanaan/update') ?>/${id}` :
      `<?= base_url('perencanaan/simpan') ?>`;

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

        if (url == `<?= base_url('perencanaan/update') ?>/${id}`) {

          Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Data berhasil Diedit',
            showConfirmButton: false,
            timer: 1700
          });
        } else {
          Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Data berhasil Ditambah',
            showConfirmButton: false,
            timer: 1500
          });
        }
        fetchRencana(currentPage); // reload data + pagination tetap
        this.reset();
        document.getElementById('id_rencana').value = '';
      });
  });

  //hapus data
  function deleteRencana(id) {
    fetch(`<?= base_url('perencanaan/delete') ?>/${id}`, {
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

        fetchRencana(currentPage);
      });
  }

  function hapusRencana(id) {
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
        deleteRencana(id);
      }
    });
  }

  function confirmDelete() {
    const id = document.getElementById('delete_id').value;

    fetch(`<?= base_url('perencanaan/delete') ?>/${id}`, {
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

        fetchRencana(currentPage);
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
      fetchRencana(1);
    }, 400);
  });

  //filter data tergantung jenis
  document.getElementById('filterJenis').addEventListener('change', () => {
    fetchRencana(1);
  });

  document.getElementById('target').addEventListener('input', updateProgress);
</script>
<?= $this->endSection() ?>