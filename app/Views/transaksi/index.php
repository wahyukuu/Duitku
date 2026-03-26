<!-- merender template layout -->
<?= $this->extend('layout/default') ?>

<!-- merender title halaman -->
<?= $this->section('title') ?>
<title>Transaksi &mdash; DuitKu</title>
<?= $this->endSection() ?>

<!-- merender conten halaman -->
<?= $this->section('content') ?>
<div class="pt-20 max-w-7xl mx-auto px-4 space-y-4 animate-fade">

  <!-- FILTER DATA TRANSAKSI -->
  <div class="flex flex-wrap gap-4 items-end">
    <select id="perPage" class="border rounded px-2 py-2">
      <option value="8">8</option>
      <option value="10">10</option>
      <option value="25">25</option>
    </select>
    <input type="date" id="dateFilter1" class="border rounded px-3 py-2" />
    <input type="date" id="dateFilter2" class="border rounded px-3 py-2" />
    <input type="text" id="search" placeholder="Cari transaksi..." class="border rounded px-3 py-2 w-64">
    <select id="filterBidang" name="filterBidang" class="border rounded px-3 py-2">
      <option>Semua Bidang</option>
      <option value="Penghasilan">Penghasilan</option>
      <option value="Pengeluaran">Pengeluaran</option>
      <option value="Mutasi">Mutasi</option>
      <option value="Rencana">Rencana/Tabungan</option>
    </select>
    <button
      onclick="resetForm(); openForm()"
      class="bg-green-600 text-white px-4 py-2 rounded">
      <i class="fa fa-plus"></i> Tambah
    </button>
  </div>

  <!-- TABLE -->
  <div class="overflow-x-auto border rounded-xl shadow-sm">
    <table class="w-full text-sm">
      <thead class="bg-gray-100">
        <tr>
          <th class="p-3 text-left">Tanggal</th>
          <th class="p-3">Jenis</th>
          <th class="p-3">Bidang</th>
          <th class="p-3">Rincian</th>
          <th class="p-3">Deskripsi</th>
          <th class="p-3">Rekening</th>
          <th class="p-3">Jumlah</th>
          <th class="p-3">Aksi</th>
        </tr>
      </thead>
      <tbody id="transaksiBody">

      </tbody>
    </table>
    <div class="w-full flex justify-center mt-4 mb-3">
      <div id="pagination" class="flex gap-1"></div>
    </div>
  </div>
</div>

<!-- MODAL FORM -->
<div
  id="modal-tambah-transaksi"
  class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50"
  onclick="closeForm()">
  <div
    class="bg-white p-6 rounded-xl w-full max-w-md animate-slide"
    onclick="event.stopPropagation()">
    <h2 class="font-bold mb-4">Form Transaksi</h2>
    <form action="" id="formTransaksi">
      <?= csrf_field(); ?>
      <input type="hidden" id="id_transaksi" name="id_transaksi">
      <input type="hidden" id="id_rencana" name="id_rencana">
      <input type="date" id="tanggal" name="tanggal" class="w-full border rounded px-3 py-2 mb-3" />
      <select id="jenis" name="jenis" class="w-full border rounded px-3 py-2 mb-3">
        <option value="Penghasilan">Penghasilan</option>
        <option value="Pengeluaran">Pengeluaran</option>
        <option value="Mutasi">Mutasi</option>
        <option value="Rencana">Rencana/Investasi</option>
      </select>
      <select id="bidang" name="bidang" class="w-full border rounded px-3 py-2 mb-3">
        <option value="">Pilih Bidang</option>
      </select>
      <select id="rincian" name="rincian" class="w-full border rounded px-3 py-2 mb-3">
        <option value="">Pilih Rincian</option>
      </select>
      <input type="text" id="deskripsi" name="deskripsi" placeholder="Deskripsi belanja" class="w-full border rounded px-3 py-2 mb-3" />
      <input type="number" id="jumlah" name="jumlah" placeholder="Jumlah" class="w-full border rounded px-3 py-2 mb-4" />
      <input type="hidden" id="id_rekening" name="id_rekening">
      <select id="nama_bank" name="nama_bank" class="w-full border rounded px-3 py-2 mb-3">
        <option value="">Pilih Bank</option>
      </select>
      <div class="flex justify-end gap-2">
        <button type="button" onclick="closeForm()" class="px-4 py-2">Batal</button>
        <button class="bg-blue-600 text-white px-4 py-2 rounded">
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
  //modal untuk logout
  const openLogout = () => modalLogout.classList.remove("hidden");
  const closeLogout = () => modalLogout.classList.add("hidden");

  //reset form untuk mengosongkan inputan
  function resetForm() {
    document.getElementById('formTransaksi').reset();

    document.getElementById('id_transaksi').value = '';
    document.getElementById('id_rekening').value = '';
    document.getElementById('deskripsi').value = '';
    document.getElementById('jumlah').value = '';
    document.getElementById('bidang').value = '';
    document.getElementById('jenis').value = '';
    document.getElementById('rincian').value = '';
    document.getElementById('id_rencana').value = '';
  }

  // membuka modal form transaksi
  function openForm() {
    document.getElementById('modal-tambah-transaksi').classList.remove('hidden');
  }

  //menutup modal form transaksi
  function closeForm() {
    document.getElementById('modal-tambah-transaksi').classList.add('hidden');
  }

  //membuka modal hapus data
  function openDelete() {
    document.getElementById('modalDelete').classList.remove('hidden');
  }

  // menutup modal hapus data
  function closeDelete() {
    document.getElementById('modalDelete').classList.add('hidden');
  }

  // format warna saldo transaksi
  function warnaSaldo(jenis) {
    if (jenis == 'Penghasilan') return 'text-green-600';
    if (jenis == 'Pengeluaran') return 'text-red-600';
    if (jenis == 'Rencana') return 'text-blue-600';
    return 'text-gray-500';
  }

  // format rupiah untuk data jumlah transaksi
  function formatRupiah(n) {
    if (!n) return '-';
    return 'Rp ' + Number(n).toLocaleString('id-ID');
  }

  //mengambil data pada halaman index dengan ajax
  let currentPage = 1;

  function fetchTransaksi(page = 1) {
    currentPage = page;

    const perPage = document.getElementById('perPage').value;
    const keyword = document.getElementById('search').value;
    const bidang = document.getElementById('filterBidang').value;

    fetch(`<?= base_url('transaksi/data') ?>?page_transaksi=${page}&perPage=${perPage}&keyword=${keyword}&bidang=${bidang}`)
      .then(res => res.json())
      .then(res => {
        renderTable(res.data);
        renderPagination(res.totalPage, res.current);
      });
  }

  // menampilkan data tabel dengan ajax
  function renderTable(data) {
    const tbody = document.getElementById('transaksiBody');
    tbody.innerHTML = '';

    data.forEach(item => {
      tbody.innerHTML += `
      <tr class="border-t">
        <td class="p-3">${item.tanggal}</td>
        <td class="p-3">${item.jenis}</td>
        <td class="p-3">${item.bidang}</td>
        <td class="p-3">${item.rincian}</td>
        <td class="p-3">${item.deskripsi}</td>
        <td class="p-3 text-center">${item.nama_bank}</td>
        <td class="p-3 text-center ${warnaSaldo(item.jenis)}">${formatRupiah(item.jumlah)}</td>
        <td class="p-3 text-center">
          <div class="flex justify-center gap-3">
            <button class="text-green-600" 
            onclick="editTransaksi(${item.id_transaksi})">
              <i class="fa fa-pen"></i>
            </button>
            <button onclick="hapusTransaksi(${item.id_transaksi})" 
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
        onclick="${!disabled ? `fetchTransaksi(${page})` : ''}"
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

  document.getElementById('search').addEventListener('keyup', () => {
    fetchTransaksi(1);
  });

  document.getElementById('filterBidang').addEventListener('change', () => {
    fetchTransaksi(1);
  });

  document.getElementById('perPage').addEventListener('change', () => {
    fetchTransaksi(1);
  });

  // initial load untuk memuat data transaksi
  fetchTransaksi();

  //mengedit data
  async function editTransaksi(id) {
    const response = await fetch(`<?= base_url('transaksi/show') ?>/${id}`);
    const res = await response.json();

    console.log(res);

    openForm();

    // isi dulu yang tidak tergantung dropdown
    document.getElementById('id_transaksi').value = res.id_transaksi;
    document.getElementById('tanggal').value = res.tanggal;
    document.getElementById('deskripsi').value = res.deskripsi;
    document.getElementById('jumlah').value = res.jumlah;

    // ========================
    // SET JENIS + TRIGGER CHANGE
    // ========================
    document.getElementById('jenis').value = res.jenis;
    document.getElementById('jenis').dispatchEvent(new Event('change'));

    // tunggu sebentar agar fetch bidang & bank selesai
    await new Promise(resolve => setTimeout(resolve, 300));

    // ========================
    // SET BIDANG
    // ========================
    document.getElementById('bidang').value = res.bidang;
    document.getElementById('bidang').dispatchEvent(new Event('change'));

    await new Promise(resolve => setTimeout(resolve, 300));

    // ========================
    // SET RINCIAN & BANK
    // ========================
    document.getElementById('rincian').value = res.rincian;
    document.getElementById('nama_bank').value = res.id_rekening;

    document.getElementById('id_rekening').value = res.id_rekening;
    document.getElementById('id_rencana').value = res.id_rencana;
  }

  //kalo jenis berubah input
  document.getElementById('jenis').addEventListener('change', function() {
    const jenis = this.value;

    const bidang = document.getElementById('bidang');
    bidang.innerHTML = '<option value="">Pilih Bidang</option>';

    //bagian bidang
    if (jenis === 'Rencana') {
      //jika yang dipilih investasi/tabungan 
      // ===== BIDANG (STATIC) =====
      bidang.innerHTML = `
      <option value="">Pilih Bidang</option>
      <option value="Tabungan">Tabungan</option>
      <option value="Investasi">Investasi</option>
      <option value="Cadangan">Cadangan</option>
      `;
    } else if (jenis === 'Mutasi') {
      bidang.innerHTML = `
      <option value="">Pilih Bidang</option>
      <option value="Mutasi">Mutasi Rekening</option>
      <option value="Rencana">Rencana & Investasi</option>
      `;
    } else {
      fetch(`<?= base_url('transaksi/kategori') ?>/${jenis}`)
        .then(res => res.json())
        .then(data => {
          data.forEach(item => {
            bidang.innerHTML += `
            <option value="${item.rincian}">
              ${item.rincian}
            </option>
          `;
          });
        });
    }

    //bagian rekening
    const bank = document.getElementById('nama_bank');
    bank.innerHTML = '<option value="">Pilih Bank</option>';
    fetch(`<?= base_url('transaksi/rekening') ?>/${jenis}`)
      .then(res => res.json())
      .then(data => {
        data.forEach(item => {
          bank.innerHTML += `
            <option value="${item.id_rekening}">
              ${item.nama_bank} - ${item.prioritas}
            </option>
          `;
        });
      });
  });

  //kalo bidang berubah inputan
  document.getElementById('bidang').addEventListener('change', function() {
    const jenis = document.getElementById('jenis').value;
    const bidang = this.value;
    const rincian = document.getElementById('rincian');

    rincian.innerHTML = '<option value="">Pilih Rincian</option>';

    // ================== RENCANA ==================
    if (jenis === 'Rencana' && bidang !== '') {
      fetch(`<?= base_url('transaksi/rencana') ?>`)
        .then(res => res.json())
        .then(data => {
          data.forEach(item => {
            rincian.innerHTML += `
                        <option value="${item.deskripsi}" data-id="${item.id_rencana}">
                            ${item.deskripsi}
                        </option>
                    `;
          });
        });
    }

    // ================== MUTASI ==================
    else if (jenis === 'Mutasi' && bidang !== '') {
      rincian.innerHTML += `
            <option value="Mutasi">Mutasi Rekening</option>
            <option value="Rencana">Rencana Investasi</option>
        `;
    }

    // ================== PENGHASILAN / PENGELUARAN ==================
    else if (bidang !== '') {
      fetch(`<?= base_url('transaksi/rincian') ?>/${bidang}`)
        .then(res => res.json())
        .then(data => {
          data.forEach(item => {
            rincian.innerHTML += `
                        <option value="${item.deskripsi}">
                            ${item.deskripsi}
                        </option>
                    `;
          });
        });
    }
  });

  //kalo rincian berubah inputan
  document.getElementById('rincian').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const id = selectedOption.dataset.id || '';

    document.getElementById('id_rencana').value = id;

  });

  // kalo nama bank berubah inputan
  document.getElementById('nama_bank').addEventListener('change', function() {
    document.getElementById('id_rekening').value = this.value;
  });

  //fungsi tambah atau edit tergantung ada id atau tidak
  document.getElementById('formTransaksi').addEventListener('submit', function(e) {
    e.preventDefault();

    const id = document.getElementById('id_transaksi').value;

    const url = id ?
      `<?= base_url('transaksi/update') ?>/${id}` :
      `<?= base_url('transaksi/simpan') ?>`;

    fetch(url, {
        method: 'POST',
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: new FormData(this)
      })
      .then(res => res.json())
      .then(res => {
        // 🔴 Kalau gagal (termasuk saldo tidak cukup)
        if (!res.status) {
          Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: res.message
          });
          return; // STOP di sini
        }

        // 🟢 Kalau sukses baru lanjut
        closeForm();

        if (id) {
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

        fetchTransaksi(currentPage);
        document.getElementById('formTransaksi').reset();
        document.getElementById('id_transaksi').value = '';
      });
  });

  // MENGHAPUS DATA
  function deleteTransaksi(id) {
    fetch(`<?= base_url('transaksi/delete') ?>/${id}`, {
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

        if (document.querySelectorAll('#transaksiBody tr').length === 1 && currentPage > 1) {
          currentPage--;
        }

        fetchTransaksi(currentPage);
      });
  }

  function hapusTransaksi(id) {
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
        deleteTransaksi(id);
      }
    });
  }

  function confirmDelete() {
    const id = document.getElementById('delete_id').value;

    fetch(`<?= base_url('transaksi/delete') ?>/${id}`, {
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

        if (document.querySelectorAll('#transaksiBody tr').length === 1 && currentPage > 1) {
          currentPage--;
        }

        fetchRencana(currentPage);
      })
      .catch(err => {
        console.error(err);
        alert('Gagal menghapus data');
      });
  }
</script>
<?= $this->endSection() ?>