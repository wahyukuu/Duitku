<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Laporan Keuangan</title>
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
      font-size: 14px;
    }

    .pemasukan {
      color: #16a34a;
    }

    .ready {
      color: #f5930b;
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

    .page-break {
      page-break-before: always;
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

  <h3>A. Aset Lancar</h3>
  <table class="summary">
    <tr>
      <td class="label">Piutang</td>
      <td class="value piutang">
        <?= rupiah($piutang); ?>
      </td>
    </tr>
    <tr>
      <td class="label">Saldo Operasional</td>
      <td class="value operasional">
        <?= rupiah($operasional); ?>
      </td>
    </tr>
    <tr class="saldo-row">
      <td class="label saldo">Saldo Seluruh Rekening</td>
      <td class="value saldo">
        <?= rupiah($saldo); ?>
      </td>
    </tr>
    <tr>
      <td class="label">Total Investasi</td>
      <td class="value rencana">
        <?= rupiah($investasi); ?>
      </td>
    </tr>
  </table>

  <!-- bagian Aset Tetap -->
  <h3>B. Aset Tetap</h3>
  <table class="summary">
    <tr>
      <td class="label">Kendaraan</td>
      <td class="value rencana">
        <?= rupiah($kendaraan); ?>
      </td>
    </tr>
    <tr>
      <td class="label">Bangunan</td>
      <td class="value rencana">
        <?= rupiah($bangunan); ?>
      </td>
    </tr>
    <tr>
      <td class="label">Tanah</td>
      <td class="value rencana">
        <?= rupiah($tanah); ?>
      </td>
    </tr>
    <tr>
      <td class="label">Peralatan</td>
      <td class="value rencana">
        <?= rupiah($peralatan); ?>
      </td>
    </tr>
    <tr>
      <td class="label">Mesin</td>
      <td class="value rencana">
        <?= rupiah($mesin); ?>
      </td>
    </tr>
    <tr>
      <td class="label">Peralatan Lainnya</td>
      <td class="value rencana">
        <?= rupiah($peralatanl); ?>
      </td>
    </tr>
    <tr>
      <td class="label">Aset Lainnya</td>
      <td class="value rencana">
        <?= rupiah($asetl); ?>
      </td>
    </tr>
  </table>

  <!-- bagian HUTANG -->
  <h3>C. Kewajiban</h3>
  <table class="summary">
    <tr>
      <td class="label">Hutang</td>
      <td class="value hutang">
        <?= rupiah($hutang); ?>
      </td>
    </tr>

  </table>

  <div class="page-break"></div>

  <!-- bagian ARUS KAS -->
  <h3>D. Arus Kas</h3>
  <table class="summary">
    <tr>
      <td class="label">Penghasilan</td>
      <td class="value pemasukan">
        Rp <?= number_format($pemasukan, 0, ',', '.') ?>
      </td>
    </tr>
    <tr>
      <td class="label">Pengeluaran</td>
      <td class="value pengeluaran">
        Rp <?= number_format($pengeluaran, 0, ',', '.') ?>
      </td>
    </tr>
    <tr>
      <td class="label">Saldo Tersedia</td>
      <td class="value ready">
        Rp <?= number_format($ready, 0, ',', '.') ?>
      </td>
    </tr>

  </table>

  <!-- bagian Total HARTA -->
  <h3>E. Total Kekayaan</h3>
  <table class="summary">

    <tr class="saldo-row">
      <td class="label saldo">Total Nilai Aset</td>
      <td class="value saldo">
        <?= rupiah($aset); ?>
      </td>
    </tr>
    <tr class="saldo-row">
      <td class="label saldo">Total Kewajiban</td>
      <td class="value saldo">
        <?= rupiah($kewajiban); ?>
      </td>
    </tr>
    <tr class="saldo-row">
      <td class="label saldo">Total Kekayaan</td>
      <td class="value saldo">
        <?= rupiah($kekayaan); ?>
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