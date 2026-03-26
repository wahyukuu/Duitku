<?php

if (!function_exists('rupiah')) {
  function rupiah($angka)
  {
    return number_format($angka, 0, ',', '.');
  }
}

if (!function_exists('tanggal_indo')) {
  function tanggal_indo($tanggal)
  {
    if (!$tanggal) return '-';

    $bulan = [
      1 => 'Januari',
      'Februari',
      'Maret',
      'April',
      'Mei',
      'Juni',
      'Juli',
      'Agustus',
      'September',
      'Oktober',
      'November',
      'Desember'
    ];

    $pecah = explode('-', date('Y-m-d', strtotime($tanggal)));

    return $pecah[2] . ' ' . $bulan[(int)$pecah[1]] . ' ' . $pecah[0];
  }

  if (!function_exists('bulan_ini_id')) {
    function bulan_ini_id()
    {
      $bulan = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
      ];

      return $bulan[(int) date('m')];
    }
  }
}
