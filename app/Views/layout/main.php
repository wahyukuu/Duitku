<?php include APPPATH . 'Views/components/icon.php'; ?>

<div class="min-h-screen bg-gray-50">

  <!-- MOBILE TOPBAR -->
  <header class="lg:hidden fixed top-0 left-0 right-0 h-16 bg-white border-b z-40 flex items-center px-4">

    <button onclick="toggleSidebar()" class="p-2 rounded hover:bg-gray-100">
      ☰
    </button>

    <h1 class="ml-3 font-bold text-blue-600">
      DuitKu
    </h1>

  </header>

  <!-- OVERLAY MOBILE -->
  <div
    id="sidebarOverlay"
    onclick="closeSidebar()"
    class="hidden fixed inset-0 bg-black/40 z-40 lg:hidden">
  </div>

  <!-- SIDEBAR -->
  <?php include 'sidebar.php'; ?>

  <!-- CONTENT -->
  <main
    id="mainContent"
    class="transition-all duration-300 lg:ml-64 pt-20 lg:pt-6 p-6">

    <?= $this->renderSection('content') ?>

  </main>

</div>

<script>
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebarOverlay');
  const mainContent = document.getElementById('mainContent');

  // MOBILE
  function toggleSidebar() {
    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
  }

  function closeSidebar() {
    sidebar.classList.add('-translate-x-full');
    overlay.classList.add('hidden');
  }

  // DESKTOP COLLAPSE
  function collapseSidebar() {

    sidebar.classList.toggle('w-64');
    sidebar.classList.toggle('w-20');

    mainContent.classList.toggle('lg:ml-64');
    mainContent.classList.toggle('lg:ml-20');

    document.querySelectorAll('.menu-text').forEach(el => {
      el.classList.toggle('hidden');
    });

    document.querySelectorAll('.group-title').forEach(el => {
      el.classList.toggle('hidden');
    });
  }
</script>