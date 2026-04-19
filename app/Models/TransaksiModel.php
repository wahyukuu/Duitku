<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table            = 'transaksi';
    protected $primaryKey       = 'id_transaksi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'tanggal',
        'jenis',
        'bidang',
        'rincian',
        'deskripsi',
        'jumlah',
        'id_rekening',
        'nama_bank',
        'id_rencana',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getAllTransaksi()
    {
        return $this->findAll();
    }

    public function getTransaksiById($id_transaksi)
    {
        return $this->find($id_transaksi);
    }

    public function getTransaksiTerakhir($batas)
    {
        return $this->orderBy('id_transaksi', 'DESC')
            ->limit($batas)
            ->findAll();
    }

    public function updateTransaksi($id_transaksi, $data)
    {
        return $this->update($id_transaksi, $data);
    }

    public function tambahTransaksi($data)
    {
        return $this->insert($data);
    }

    public function hapusTransaksi($id_transaksi)
    {
        return $this->delete($id_transaksi);
    }

    public function filterByTanggal($from, $to)
    {
        return $this->where('tanggal >=', $from)
            ->where('tanggal <=', $to)
            ->findAll();
    }

    public function filterMingguan()
    {
        return $this->where('tanggal >=', date('Y-m-d', strtotime('-7 days')))
            ->findAll();
    }

    public function filterBulanan($bulan, $tahun)
    {
        return $this->where('MONTH(tanggal)', $bulan)
            ->where('YEAR(tanggal)', $tahun)
            ->findAll();
    }

    public function filterByKategori($id_kategori)
    {
        return $this->where('id_kategori', $id_kategori)
            ->findAll();
    }

    public function totalByBulanDanBidang($jenis)
    {
        $awalBulan  = date('Y-m-01');
        $akhirBulan = date('Y-m-t');

        return $this->selectSum('jumlah')
            ->where('jenis', $jenis)
            ->where('tanggal >=', $awalBulan)
            ->where('tanggal <=', $akhirBulan)
            ->whereNotIn('rincian', ['Mutasi', 'Rencana'])
            ->first();
    }

    public function getTransaksiJoinRekening()
    {
        return $this
            ->select('transaksi.*, rekening.nama_bank')
            ->join('rekening', 'rekening.id_rekening = transaksi.id_rekening');
    }

    public function getTransaksiJoinRekeningLast($batas)
    {
        return $this->select('transaksi.*, rekening.nama_bank')
            ->join('rekening', 'rekening.id_rekening = transaksi.id_rekening')
            ->orderBy('id_transaksi', 'DESC')
            ->limit($batas)
            ->findAll();
    }

    public function getSaldoByTanggal($id_rek, $tanggal)
    {
        $masuk = $this->selectSum('jumlah')
            ->where('id_rekening', $id_rek)
            ->where('jenis', 'Penghasilan')
            ->where('tanggal <=', $tanggal)
            ->get()
            ->getRow()->jumlah ?? 0;

        $keluar = $this->selectSum('jumlah')
            ->where('id_rekening', $id_rek)
            ->where('jenis', 'Pengeluaran')
            ->where('tanggal <=', $tanggal)
            ->get()
            ->getRow()->jumlah ?? 0;

        return (int)$masuk - (int)$keluar;
    }

    public function recalculateSaldoRekening($id_rek)
    {
        $transaksi = $this->where('id_rekening', $id_rek)
            ->orderBy('tanggal', 'ASC')
            ->orderBy('id_transaksi', 'ASC')
            ->findAll();

        $saldo = 0;

        foreach ($transaksi as $trx) {
            if (in_array($trx['jenis'], ['Penghasilan', 'Rencana'])) {
                $saldo += (int)$trx['jumlah'];
            } else {
                $saldo -= (int)$trx['jumlah'];
            }
        }

        // update saldo terakhir ke rekening
        model('RekeningModel')->update($id_rek, [
            'saldo' => $saldo
        ]);

        return $saldo;
    }

    //total jumlah rencana/investasi
    public function totalRencana()
    {
        return $this->selectSum('jumlah')
            ->where('rincian', 'Rencana')
            ->get()
            ->getRow()
            ->jumlah ?? 0;;
    }

    public function totalInvestasi()
    {
        return $this->selectSum('jumlah')
            ->where('rincian', 'Rencana')
            ->get()
            ->getRow()
            ->jumlah ?? 0;;
    }

    //total jumlah hutang
    public function totalHutang()
    {
        return $this->selectSum('jumlah')
            ->where('jenis', 'Penghasilan')
            ->where('bidang', 'Penghasilan Non PNS')
            ->where('rincian', 'Hutang')
            ->get()
            ->getRow()
            ->jumlah ?? 0;;
    }

    // hitung sisa hutang yang harus dibayar
    public function jlhSisaHutang()
    {
        $jenis = 'Penghasilan';
        $bidang = 'Penghasilan Non PNS';
        $rincian = 'Hutang';
        $jenis1 = 'Pengeluaran';
        $bidang1 = 'Hari Tertentu';
        $rincian1 = 'Bayar Hutang';

        $hutang = $this->selectSum('jumlah')
            ->where('jenis', $jenis)
            ->where('bidang', $bidang)
            ->where('rincian', $rincian)
            ->get()
            ->getRow()
            ->jumlah ?? 0;

        $bayar = $this->selectSum('jumlah')
            ->where('jenis', $jenis1)
            ->where('bidang', $bidang1)
            ->where('rincian', $rincian1)
            ->get()
            ->getRow()
            ->jumlah ?? 0;

        return (int) $hutang - (int) $bayar;
    }

    //total jumlah piutang
    public function totalPiutang()
    {
        return $this->selectSum('jumlah')
            ->where('jenis', 'Pengeluaran')
            ->where('bidang', 'Hari Tertentu')
            ->where('rincian', 'Piutang')
            ->get()
            ->getRow()
            ->jumlah ?? 0;;
    }

    // hitung sisa piutang yang belum dibayar orang lain
    public function jlhSisaPiutang()
    {
        $jenis = 'Pengeluaran';
        $bidang = 'Hari Tertentu';
        $rincian = 'Piutang';
        $jenis1 = 'Penghasilan';
        $bidang1 = 'Penghasilan Non PNS';
        $rincian1 = 'Pembayaran Piutang';

        $piutang = $this->selectSum('jumlah')
            ->where('jenis', $jenis)
            ->where('bidang', $bidang)
            ->where('rincian', $rincian)
            ->get()
            ->getRow()
            ->jumlah ?? 0;

        $bayar = $this->selectSum('jumlah')
            ->where('jenis', $jenis1)
            ->where('bidang', $bidang1)
            ->where('rincian', $rincian1)
            ->get()
            ->getRow()
            ->jumlah ?? 0;

        return (int) $piutang - (int) $bayar;
    }
}
