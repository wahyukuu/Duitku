<?php

if (!function_exists('formatTanggalIndonesia')) {

  function formatTanggalIndonesia($datetime, $withTime = true)
  {
    date_default_timezone_set('Asia/Jakarta');

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

    $timestamp = strtotime($datetime);

    $tgl = date('j', $timestamp) . ' ' .
      $bulan[date('n', $timestamp)] . ' ' .
      date('Y', $timestamp);

    if ($withTime) {
      $jam = date('H:i', $timestamp);
      return $tgl . ' | ' . $jam . ' WIB';
    }

    return $tgl;
  }
}
