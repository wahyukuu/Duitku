<?php

namespace Config;

class Menu
{
  public static function sidebar()
  {
    return [

      'MAIN' => [

        [
          'title' => 'Dashboard',
          'url'   => 'dashboard',
          'icon'  => 'dashboard',
          'role'  => ['Admin', 'User']
        ],

        [
          'title' => 'Laporan',
          'url'   => 'laporan',
          'icon'  => 'laporan',
          'role'  => ['Admin', 'User']
        ],

      ],

      'TRANSAKSI' => [

        [
          'title' => 'Transaksi',
          'url'   => 'transaksi',
          'icon'  => 'transaksi',
          'role'  => ['Admin', 'User']
        ],

        [
          'title' => 'Perencanaan',
          'url'   => 'perencanaan',
          'icon'  => 'perencanaan',
          'role'  => ['Admin', 'User']
        ],

      ],

      'MASTER DATA' => [

        [
          'title' => 'Admin',
          'url'   => 'admin',
          'icon'  => 'admin',
          'role'  => ['Admin']
        ],

        [
          'title' => 'Rekening',
          'url'   => 'rekening',
          'icon'  => 'rekening',
          'role'  => ['Admin']
        ],

        [
          'title' => 'Kategori',
          'url'   => 'kategori',
          'icon'  => 'kategori',
          'role'  => ['Admin']
        ],

      ],

    ];
  }
}
