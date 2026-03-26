<?php

function format_tanggal_indo($tanggal)
{
  if (!$tanggal) return '-'; // kalau null atau kosong

  $bulanIndo = [
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

  $tgl = date('Y-m-d', strtotime($tanggal));
  list($tahun, $bulan, $hari) = explode('-', $tgl);

  return $hari . ' ' . $bulanIndo[(int)$bulan] . ' ' . $tahun;
}
