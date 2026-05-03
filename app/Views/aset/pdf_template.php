<!DOCTYPE html>
<html>

<head>
  <title>Laporan Aset</title>
  <style>
    body {
      font-family: sans-serif;
      font-size: 12px;
    }

    .header-fixed h1 {
      margin: 0;
      font-size: 24px;
      color: #3e8af5;
      text-align: center;
    }

    .periode {
      margin-top: 4px;
      font-size: 13px;
      color: #4b5563;
      text-align: center;
    }

    table {
      width: 100%;
      margin: 12px auto;
      border-collapse: collapse;
      margin-top: 12px;
      font-family: DejaVu Sans, sans-serif;
    }

    th,
    td {
      border: 1px solid #000;
      padding: 6px;
      text-align: center;
    }

    th {
      background: #eee;
    }

    .footer-fixed {
      position: fixed;
      bottom: -100px;
      left: 0;
      right: 0;
      height: 100px;
      font-size: 12px;
      text-align: center;
      color: #666;
    }
  </style>
</head>

<body>
  <?php
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
  $tgl = date('j') . ' ' . $bulan[date('n')] . ' ' . date('Y');
  $jam = date('H:i');
  ?>

  <div class="header-fixed">
    <h1>Laporan Aset DuitKu</h1>
    <div class="periode">
      Periode:
      <?= formatTanggalIndonesia($from, false) ?> -
      <?= formatTanggalIndonesia($to, false) ?><br>
    </div>
  </div>

  <table>
    <thead>
      <tr>
        <th>Nama Aset</th>
        <th>Jenis</th>
        <th>Jumlah</th>
        <th>Satuan</th>
        <th>Cara</th>
        <th>Tahun</th>
        <th>Detail</th>
        <th>Nilai Beli</th>
        <th>Nilai Buku</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($aset as $t): ?>
        <tr>
          <td><?= $t['nama_aset'] ?></td>
          <td><?= $t['jenis_aset'] ?></td>
          <td><?= $t['jumlah'] ?></td>
          <td><?= $t['satuan'] ?></td>
          <td><?= $t['cara_perolehan'] ?></td>
          <td><?= $t['tahun_perolehan'] ?></td>
          <td><?= $t['detail'] ?></td>
          <td>Rp <?= number_format($t['nilai_perolehan'], 0, ',', '.') ?></td>
          <td>Rp <?= number_format($t['nilai_sekarang'], 0, ',', '.') ?></td>
        </tr>
      <?php endforeach ?>
      <tr>
        <td colspan="7" style="text-align:right;"><strong>Total Nilai Aset</strong></td>
        <td><strong>Rp <?= number_format($total1, 0, ',', '.') ?></strong></td>
        <td><strong>Rp <?= number_format($total2, 0, ',', '.') ?></strong></td>
      </tr>
    </tbody>
  </table>

  <div class="footer-fixed">
    &copy; <?= date('Y') ?> DuitKu - Laporan dihasilkan otomatis oleh sistem.<br>
    Dicetak: <?= formatTanggalIndonesia(date('Y-m-d H:i:s')) ?><br>
  </div>

</body>

</html>