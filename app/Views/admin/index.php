<!-- merender template layout -->
<?= $this->extend('layout/default') ?>

<!-- merender title halaman -->
<?= $this->section('title') ?>
<title>Admin &mdash; DuitKu</title>
<?= $this->endSection() ?>

<!-- merender conten halaman -->
<?= $this->section('content') ?>
<div class="pt-20 max-w-7xl mx-auto px-6 space-y-4 animate-fade">

  <!-- FILTER DATA TRANSAKSI -->
  <div class="flex flex-wrap gap-4 items-end">
    <button
      onclick="resetForm(); openForm('tambah')"
      class="bg-green-600 text-white px-4 py-2 rounded-lg"
      id="tambah-admin">
      <i class="fa fa-plus"></i> Tambah
    </button>

    <select id="perPage" class="border rounded px-2 py-2">
      <option value="5">5</option>
      <option value="10">10</option>
    </select>

    <input
      type="text"
      id="search"
      placeholder="Cari admin..."
      class="border rounded px-3 py-2 w-64">

    <select id="filterJenis" class="border rounded px-2 py-2">
      <option value="">Semua Jenis</option>
      <option value="Admin">Admin</option>
      <option value="Biasa">User Biasa</option>
    </select>

  </div>

  <?php if (session()->getFlashdata('success')) : ?>
    <div class="bg-green-100 text-green-700 px-4 py-2 rounded">
      <?= session()->getFlashdata('success') ?>
    </div>
  <?php endif; ?>

  <!-- TABLE -->
  <div class="overflow-x-auto border rounded-xl shadow-sm">
    <table class="w-full text-sm">
      <thead class="bg-gray-100">
        <tr>
          <th class="p-3 text-left">No.</th>
          <th class="p-3">Username</th>
          <th class="p-3">Password</th>
          <th class="p-3">Level</th>
          <th class="p-3">Aksi</th>
        </tr>
      </thead>
      <tbody id="adminBody"></tbody>
    </table>
    <div class="w-full flex justify-center mt-4 mb-3">
      <div id="pagination" class="flex gap-1"></div>
    </div>
  </div>
</div>

<!-- MODAL FORM TAMBAH ADMIN -->
<div
  id="modal-tambah-admin"
  onclick="closeForm()"
  class="hidden fixed inset-0 bg-black/40 flex items-center justify-center">

  <div
    onclick="event.stopPropagation()"
    class="bg-white p-6 rounded-xl w-full max-w-md animate-slide">
    <h2 id="modalTitle" class="font-bold mb-4"></h2>
    <form id="formAdmin">
      <?= csrf_field(); ?>
      <input type="hidden" id="id_admin" name="id_admin">
      <input type="text" id="username" name="username" placeholder="username..."
        class="w-full border rounded px-3 py-2 mb-3">
      <small id="errorUsername" class="text-red-500"></small>

      <div class="relative mb-3">
        <input
          type="password"
          id="password"
          name="password"
          placeholder="Kosongkan jika tidak ingin ubah Password"
          class="w-full border rounded px-3 py-2 pr-10">

        <button
          type="button"
          onclick="togglePassword()"
          class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
          <!-- Eye Open -->
          <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M2.458 12C3.732 7.943 7.523 5 12 5
           c4.477 0 8.268 2.943 9.542 7
           -1.274 4.057-5.065 7-9.542 7
           -4.477 0-8.268-2.943-9.542-7z" />
          </svg>

          <!-- Eye Off -->
          <svg id="eyeClose" xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M13.875 18.825A10.05 10.05 0 0112 19
           c-4.477 0-8.268-2.943-9.542-7
           a9.956 9.956 0 012.042-3.368M6.223 6.223
           A9.956 9.956 0 0112 5c4.477 0
           8.268 2.943 9.542 7
           a9.956 9.956 0 01-4.132 5.411M15 12a3 3 0 00-3-3m0 0
           a3 3 0 00-2.12.879m2.12-.879L3 3" />
          </svg>
        </button>
      </div>

      <select name="level" id="level" class="w-full border rounded px-3 py-2 mb-3">
        <option value="">Pilih Level User</option>
        <option value="Admin">Admin</option>
        <option value="Biasa">User Biasa</option>
      </select>

      <div class="flex justify-end gap-2">
        <button type="button" onclick="closeForm()">Batal</button>
        <button type="submit"
          class="bg-blue-600 text-white px-4 py-2 rounded">
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

  //toggle untuk inputan password
  function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeOpen = document.getElementById('eyeOpen');
    const eyeClose = document.getElementById('eyeClose');

    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      eyeOpen.classList.add('hidden');
      eyeClose.classList.remove('hidden');
    } else {
      passwordInput.type = 'password';
      eyeOpen.classList.remove('hidden');
      eyeClose.classList.add('hidden');
    }
  }

  //reset form untuk mengosongkan inputan
  function resetForm() {
    document.getElementById('formAdmin').reset();

    document.getElementById('id_admin').value = '';
    document.getElementById('username').value = '';
    document.getElementById('password').placeholder = 'Password...'
    document.getElementById('level').value = '';
  }

  // membuka modal
  function openForm(mode = 'tambah') {

    const title = document.getElementById('modalTitle')

    if (mode === 'edit') {
      title.innerText = 'Edit Admin'
    } else {
      title.innerText = 'Tambah Admin'
    }

    document
      .getElementById('modal-tambah-admin')
      .classList.remove('hidden')
  }

  //menutup modal
  function closeForm() {
    // document.getElementById('modalTitle').innerText = '';
    document.getElementById('modal-tambah-admin').classList.add('hidden');
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

  function fetchAdmin(page = 1) {
    currentPage = page;

    const tbody = document.getElementById('adminBody');
    tbody.innerHTML = `
      <tr>
      <td colspan="5" class="text-center p-6 text-gray-500">
      Loading data...
      </td>
      </tr>
      `;

    const perPage = document.getElementById('perPage').value;
    const keyword = document.getElementById('search').value;
    const level = document.getElementById('filterJenis').value;

    fetch(`<?= base_url('admin/data') ?>?page_admin=${page}&perPage=${perPage}&keyword=${keyword}&level=${level}`)
      .then(res => res.json())
      .then(res => {
        renderTable(res.data);
        renderPagination(res.totalPage, res.current);
      });
  }

  // menampilkan data tabel dengan ajax
  function renderTable(data) {
    const tbody = document.getElementById('adminBody');
    tbody.innerHTML = '';

    const perPage = document.getElementById('perPage').value;
    let no = (currentPage - 1) * perPage + 1;

    data.forEach(item => {
      tbody.innerHTML += `
<tr class="border-t">
  <td class="p-2">${no++}</td>
  <td class="p-2 text-center">${item.username}</td>
  <td class="p-2 text-center">••••••••••••••••</td>
  <td class="p-2 text-center">${item.level ?? '-'}</td>
  <td class="p-2 text-center">
    <div class="flex justify-center gap-3">
      <button class="text-green-600"
        onclick="editAdmin(${item.id_admin})">
        <i class="fa fa-pen"></i>
      </button>
      <button onclick="hapusAdmin(${item.id_admin})"
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
    ${disabled ? 'disabled' : '' }
    onclick="${!disabled ? `fetchAdmin(${page})` : ''}"
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
    fetchAdmin(1);
  });

  // initial load
  fetchAdmin();

  //mengedit data
  function editAdmin(id) {
    fetch(`<?= base_url('admin/show') ?>/${id}`)
      .then(res => res.json())
      .then(res => {
        document.getElementById('id_admin').value = res.id_admin;
        document.getElementById('username').value = res.username;
        document.getElementById('password').value = '';
        document.getElementById('password').placeholder =
          'Kosongkan jika tidak ingin mengubah password';
        document.getElementById('level').value = res.level;

        openForm('edit');
      });
  }

  //fungsi tambah atau edit tergantung ada id atau tidak
  document.getElementById('formAdmin').addEventListener('submit', function(e) {
    e.preventDefault();

    const id = document.getElementById('id_admin').value;

    const url = id ?
      `<?= base_url('admin/update') ?>/${id}` :
      `<?= base_url('admin/simpan') ?>`;

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
        fetchAdmin(currentPage); // reload data + pagination tetap
        this.reset();
        document.getElementById('id_admin').value = '';
      });
  });

  //hapus data
  function deleteAdmin(id) {
    fetch(`<?= base_url('admin/delete') ?>/${id}`, {
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

        if (document.querySelectorAll('#adminBody tr').length === 1 && currentPage > 1) {
          currentPage--;
        }

        fetchAdmin(currentPage);
      });
  }

  function hapusAdmin(id) {
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
        deleteAdmin(id);
      }
    });
  }

  function confirmDelete() {
    const id = document.getElementById('delete_id').value;

    fetch(`<?= base_url('admin/delete') ?>/${id}`, {
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

        if (document.querySelectorAll('#adminBody tr').length === 1 && currentPage > 1) {
          currentPage--;
        }

        fetchAdmin(currentPage);
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
      fetchAdmin(1);
    }, 400);
  });

  //filter data tergantung jenis
  document.getElementById('filterJenis').addEventListener('change', () => {
    fetchAdmin(1);
  });
</script>
<?= $this->endSection() ?>