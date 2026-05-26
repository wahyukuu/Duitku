<?php

use Config\Menu;

$menus = Menu::sidebar();

?>

<aside
  id="sidebar"
  class="fixed top-0 left-0 z-50 h-screen w-64 bg-white border-r border-gray-200
  transition-all duration-300
  -translate-x-full lg:translate-x-0 flex flex-col">

  <!-- HEADER -->
  <div class="h-16 flex items-center justify-between px-4 border-b">

    <h1 class="font-bold text-blue-600 menu-text">
      DuitKu
    </h1>

    <!-- COLLAPSE BUTTON -->
    <button
      onclick="collapseSidebar()"
      class="hidden lg:flex p-2 rounded hover:bg-gray-100">

      ←

    </button>

  </div>

  <!-- MENU -->
  <nav class="flex-1 overflow-y-auto p-2">

    <?php foreach ($menus as $group => $items) : ?>

      <!-- GROUP -->
      <div class="group-title px-3 pt-4 pb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">

        <?= $group ?>

      </div>

      <div class="space-y-1">

        <?php foreach ($items as $menu) : ?>

          <?php if (in_array(session('level'), $menu['role'])) : ?>

            <a
              href="<?= base_url($menu['url']) ?>"
              class="flex items-center gap-3 p-3 rounded-lg text-sm transition-all
              <?= isActive($menu['url'])
                ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600'
                : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' ?>">

              <!-- ICON -->
              <div class="shrink-0">
                <?= icon($menu['icon']) ?>
              </div>

              <!-- TEXT -->
              <span class="menu-text whitespace-nowrap">
                <?= $menu['title'] ?>
              </span>

            </a>

          <?php endif; ?>

        <?php endforeach; ?>

      </div>

    <?php endforeach; ?>

  </nav>

  <!-- LOGOUT -->
  <div class="border-t p-2">

    <button
      onclick="openLogout()"
      class="w-full flex items-center gap-3 p-3 rounded-lg text-red-600 hover:bg-red-50">

      <?= icon('logout') ?>

      <span class="menu-text">
        Logout
      </span>

    </button>

  </div>

</aside>