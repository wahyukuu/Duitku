<!DOCTYPE html>
<html>

<head>
  <title>Riwayat Transaksi</title>
  <style>
    body {
      font-family: sans-serif;
      font-size: 12px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
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
  </style>
</head>

<body>

  <h3>Riwayat Transaksi</h3>

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
          <td><?= $t['rincian'] ?></td>
          <td><?= $t['deskripsi'] ?></td>
          <td><?= $t['nama_bank'] ?></td>
          <td>Rp <?= number_format($t['jumlah'], 0, ',', '.') ?></td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>



</body>

</html>