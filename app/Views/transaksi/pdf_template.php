<!DOCTYPE html>
<html>

<head>
  <title>Riwayat Transaksi</title>
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
    <h1>Riwayat Transaksi DuitKu</h1>
    <div class="periode">
      Periode:
      <?= formatTanggalIndonesia($from, false) ?> -
      <?= formatTanggalIndonesia($to, false) ?><br>
    </div>
  </div>

  <table>
    <thead>
      <tr>
        <th>Tanggal</th>
        <th>Jenis</th>
        <th>Bidang</th>
        <th>Rincian</th>
        <th>Deskripsi</th>
        <th>Bank</th>
        <th>Jumlah</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($transaksi as $t): ?>
        <tr>
          <td><?= $t['tanggal'] ?></td>
          <td><?= $t['jenis'] ?></td>
          <td><?= $t['bidang'] ?></td>
          <td class="text-left"><?= $t['rincian'] ?></td>
          <td><?= $t['deskripsi'] ?></td>
          <td><?= $t['nama_bank'] ?></td>
          <td>Rp <?= number_format($t['jumlah'], 0, ',', '.') ?></td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>

  <div class="footer-fixed">
    &copy; <?= date('Y') ?> DuitKu - Laporan dihasilkan otomatis oleh sistem.<br>
    Dicetak: <?= formatTanggalIndonesia(date('Y-m-d H:i:s')) ?><br>
  </div>

</body>

</html>