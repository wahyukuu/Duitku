<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Cetak Laporan</title>
  <style>
    @page {
      size: A4 portrait;
      margin: 100px 50px 80px 50px;
    }

    .header-fixed {
      position: fixed;
      top: -75px;
      left: 0;
      right: 0;
    }

    body {
      font-family: DejaVu Sans, sans-serif;
      margin: 0;
      /* WAJIB 0 */
      color: #111827;
    }

    .header-fixed h1 {
      margin: 0;
      font-size: 24px;
      color: #3e8af5;
    }

    .periode {
      margin-top: 4px;
      font-size: 13px;
      color: #4b5563;
    }

    .summary {
      width: 100%;
      border-collapse: collapse;
      margin-top: 0px;
    }

    .summary td {
      padding: 14px;
      height: 20px;
      border-bottom: 1px solid #e5e7eb;
    }

    .label {
      font-size: 14px;
    }

    .value {
      text-align: right;
      font-weight: bold;
      font-size: 15px;
    }

    .pemasukan {
      color: #16a34a;
    }

    .piutang {
      color: #16a34a;
    }

    .pengeluaran {
      color: #dc2626;
    }

    .hutang {
      color: #dc2626;
    }

    .rencana {
      color: #2563eb;
    }

    .operasional {
      color: #e97c00;
    }

    .saldo-row {
      background-color: #ffffff;
    }

    .saldo {
      font-size: 14px;
    }

    .footer-fixed {
      position: fixed;
      bottom: -120px;
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
    <h1>Laporan Keuangan DuitKu</h1>
    <div class="periode">
      Periode:
      <?= formatTanggalIndonesia($from, false) ?> -
      <?= formatTanggalIndonesia($to, false) ?><br>
    </div>
  </div>

  <h3>A. Laporan Kas Umum</h3>
  <table class="summary">
    <tr>
      <td class="label">Total Pemasukan</td>
      <td class="value pemasukan">
        Rp <?= number_format($pemasukan, 0, ',', '.') ?>
      </td>
    </tr>
    <tr>
      <td class="label">Total Pengeluaran</td>
      <td class="value pengeluaran">
        Rp <?= number_format($pengeluaran, 0, ',', '.') ?>
      </td>
    </tr>

  </table>

  <!-- bagian Rencana/Pembiayaan/Investasi -->
  <h3>B. Laporan Rencana/Investasi</h3>
  <table class="summary">
    <tr>
      <td class="label">Total Rencana</td>
      <td class="value rencana">
        Rp <?= number_format($rencana, 0, ',', '.') ?>
      </td>
    </tr>
  </table>


  <!-- bagian HUTANG -->
  <h3>C. Laporan Hutang/Piutang</h3>
  <table class="summary">
    <tr>
      <td class="label">Total Hutang Belum Bayar</td>
      <td class="value hutang">
        Rp <?= number_format($hutang, 0, ',', '.') ?>
      </td>
    </tr>
    <tr>
      <td class="label">Total Piutang Belum Dibayar</td>
      <td class="value piutang">
        Rp <?= number_format($piutang, 0, ',', '.') ?>
      </td>
    </tr>
  </table>

  <!-- bagian Total HARTA -->
  <h3>D. Total Saldo/Harta</h3>
  <table class="summary">
    <tr>
      <td class="label">Sisa Saldo Operasional</td>
      <td class="value operasional">
        Rp <?= number_format($operasional, 0, ',', '.') ?>
      </td>
    </tr>
    <tr class="saldo-row">
      <td class="label saldo">Total Saldo Seluruh Rekening Saat Ini</td>
      <td class="value saldo">
        Rp <?= number_format($saldo, 0, ',', '.') ?>
      </td>
    </tr>
  </table>

  <!-- bagian Tanda Tangan -->
  <!-- <div style="margin-top:60px; text-align:center;">
    <p>Mengetahui,</p>
    <img src="<?= FCPATH . 'assets/why-08.png' ?>" width="80">
    <p><strong>Wahyu Kurniawan</strong></p>
  </div> -->

  <div class="footer-fixed">
    &copy; <?= date('Y') ?> DuitKu - Laporan dihasilkan otomatis oleh sistem.<br>
    Dicetak: <?= formatTanggalIndonesia(date('Y-m-d H:i:s')) ?><br>
  </div>

</body>

</html>