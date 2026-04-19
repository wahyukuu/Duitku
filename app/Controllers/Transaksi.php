<?php


namespace App\Controllers;

use App\Models\TransaksiModel;
use App\Models\RekeningModel;
use App\Models\KategoriModel;
use App\Models\RencanaModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Dompdf\Dompdf;
use PHPUnit\Event\Test\AfterTestMethodFinished;

class Transaksi extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    protected $transaksi;
    protected $kategori;
    protected $rencana;
    protected $rekening;
    protected $db;
    public function __construct()
    {
        $this->transaksi = new TransaksiModel();
        $this->kategori = new KategoriModel();
        $this->rencana = new RencanaModel();
        $this->rekening = new RekeningModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data = [
            'transaksi' => $this->transaksi->getAllTransaksi()
        ];
        return view('transaksi/index', $data);
    }

    public function dataAjax()
    {
        $perPage = $this->request->getGet('perPage') ?? 5;
        $keyword = $this->request->getGet('keyword');
        $bidang   = $this->request->getGet('bidang');

        $builder = $this->transaksi->getTransaksiJoinRekening();

        if ($bidang && $bidang !== 'Semua Bidang') {
            $builder->where('transaksi.jenis', $bidang);
        }

        if ($keyword) {
            $builder->groupStart()
                ->like('transaksi.jenis', $keyword)
                ->orLike('transaksi.bidang', $keyword)
                ->orLike('transaksi.rincian', $keyword)
                ->orLike('transaksi.deskripsi', $keyword)
                ->groupEnd();
        }

        $data  = $builder->paginate($perPage, 'transaksi');
        $pager = $this->transaksi->pager;

        return $this->response->setJSON([
            'data'      => $data,
            'current'   => $pager->getCurrentPage('transaksi'),
            'totalPage' => $pager->getPageCount('transaksi')
        ]);
    }

    public function tabunganInvestasi()
    {
        $data = $this->rekening->getRekeningTabungan();
        return $this->response->setJSON($data);
    }

    public function semuaRekening()
    {
        $data = $this->rekening->findAll();
        return $this->response->setJSON($data);
    }

    public function kategoriByBidang($jenis)
    {
        $data = $this->kategori
            ->select('rincian')
            ->where('bidang', $jenis)
            ->groupBy('rincian')
            ->orderBy('rincian', 'ASC')
            ->findAll();

        return $this->response->setJSON($data);
    }

    public function kategoriByRincian($bidang)
    {
        $bidang = urldecode($bidang);
        $data = $this->kategori
            ->where('rincian', $bidang)
            ->findAll();

        return $this->response->setJSON($data);
    }

    public function kategoriByRencana()
    {
        $data = $this->rencana
            ->findAll();

        return $this->response->setJSON($data);
    }

    public function rekeningByBidang($jenis)
    {
        if ($jenis === 'Rencana') {
            $data = $this->rekening
                ->whereIn('prioritas', ['Tabungan', 'Investasi'])
                ->findAll();
        } else {
            $data = $this->rekening->findAll();
        }

        return $this->response->setJSON($data);
    }

    public function simpanAjax()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400);
        }

        $tanggal = $this->request->getPost('tanggal');
        $jenis = $this->request->getPost('jenis');
        $bidang = $this->request->getPost('bidang');
        $rincian = $this->request->getPost('rincian');
        $deskripsi = $this->request->getPost('deskripsi');
        $jumlah = (int) $this->request->getPost('jumlah');
        $id_rek = $this->request->getPost('id_rekening');
        $bank = $this->request->getPost('nama_bank');
        $id_ren = $this->request->getPost('id_rencana');

        // validasi
        if (!$tanggal || !$jenis || !$bidang || !$rincian || !$jumlah || !$id_rek) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Semua field wajib diisi'
            ]);
        }

        // cek saldo dulu sebelum simpan transaksi
        $rek = $this->rekening->find($id_rek);
        if ($jenis === 'Pengeluaran' || $jenis === 'Mutasi') {
            if ($jumlah > $rek['saldo']) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Saldo Rekening ini ga cukup Bray'
                ]);
            }
        }

        // Ambil saldo berdasarkan histori sampai tanggal tersebut
        $saldoTanggalItu = $this->transaksi->getSaldoByTanggal($id_rek, $tanggal);

        // Tentukan apakah transaksi ini mengurangi saldo
        $pengurangSaldo = false;

        if ($jenis === 'Pengeluaran' || $jenis === 'Mutasi') {
            $pengurangSaldo = true;
        }

        // Jika transaksi mengurangi saldo, cek apakah cukup
        if ($pengurangSaldo && $jumlah > $saldoTanggalItu) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Saldo pada tanggal tersebut tidak mencukupi'
            ]);
        }

        $data = [
            'tanggal' => $tanggal,
            'jenis' => $jenis,
            'bidang' => $bidang,
            'rincian' => $rincian,
            'deskripsi' => $deskripsi,
            'jumlah' => $jumlah,
            'id_rekening' => $id_rek,
            'nama_bank' => $bank,
            'id_rencana' => $id_ren
        ];

        $this->db->transStart();

        // simpan transaksi
        $this->transaksi->insert($data);

        // hitung saldo baru
        $saldoAwal = (int) $rek['saldo'];
        $jumlah = (int) $jumlah;
        if ($jenis === 'Penghasilan' || $jenis === 'Rencana') {
            $saldoBaru = $saldoAwal + $jumlah;
        } else {
            $saldoBaru = $saldoAwal - $jumlah;
        }

        // update rekening yang jadi tujuan
        $this->rekening->update($id_rek, [
            'saldo' => $saldoBaru
        ]);

        //cek jika rencana, maka update kolom jlh_sementaranya
        if ($jenis === 'Rencana' && !empty($id_ren)) {

            $renc = $this->rencana->find($id_ren);

            if ($renc) { // pastikan datanya ada
                $saldoSementara = (int) ($renc['jlh_sementara'] ?? 0);
                $jlhs = $saldoSementara + (int) $jumlah;

                $this->rencana->update($id_ren, [
                    'jlh_sementara' => $jlhs
                ]);
            }
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Gagal menyimpan transaksi'
            ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Transaksi berhasil ditambahkan'
        ]);
    }


    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        return $this->response->setJSON(
            $this->transaksi->find($id)
        );
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $data = [
            'jenis' => $this->request->getPost('jenis'),
            'bidang' => $this->request->getPost('bidang'),
            'rincian' => $this->request->getPost('rincian'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'jumlah' => $this->request->getPost('jumlah'),
            'id_rekening' => $this->request->getPost('id_rekening'),
        ];

        $this->transaksi->insert($data);

        return redirect()->back()->with('success', 'Transaksi berhasil ditambahkan');
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400);
        }

        $id_transaksi = $this->request->getPost('id_transaksi');
        //ambil data transaksi sebelum datanya diubah
        $trx = $this->transaksi->find($id_transaksi);
        if (!$trx) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        $tanggal = $this->request->getPost('tanggal');
        $jenis = $this->request->getPost('jenis');
        $bidang = $this->request->getPost('bidang');
        $rincian = $this->request->getPost('rincian');
        $deskripsi = $this->request->getPost('deskripsi');
        $jumlah = (int) $this->request->getPost('jumlah');
        $id_rek = $this->request->getPost('id_rekening');
        $bank = $this->request->getPost('nama_bank');
        $id_ren = $this->request->getPost('id_rencana');

        $data = [
            'tanggal' => $tanggal,
            'jenis' => $jenis,
            'bidang' => $bidang,
            'rincian' => $rincian,
            'deskripsi' => $deskripsi,
            'jumlah' => $jumlah,
            'id_rekening' => $id_rek,
            'nama_bank' => $bank,
            'id_rencana' => $id_ren,
        ];

        // ==============================
        // VALIDASI SALDO HISTORI
        // ==============================

        $saldoSebelum = $this->transaksi
            ->select("SUM(CASE 
                WHEN jenis IN ('Penghasilan','Rencana') 
                THEN jumlah 
                ELSE -jumlah 
                END
                ) as saldo", false)
            ->where('id_rekening', $id_rek)
            ->where('tanggal <', $tanggal)
            ->where('id_transaksi !=', $id_transaksi)
            ->get()
            ->getRow()
            ->saldo ?? 0;

        $saldoSimulasi = $saldoSebelum;

        if (in_array($jenis, ['Penghasilan', 'Rencana'])) {
            $saldoSimulasi += $jumlah;
        } else {
            $saldoSimulasi -= $jumlah;
        }

        if ($saldoSimulasi < 0) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Saldo tidak mencukupi pada tanggal tersebut'
            ]);
        }

        // ==============================
        // PROSES UPDATE + RECALC
        // ==============================
        $this->db->transStart();

        // update transaksi
        $this->transaksi->update($id_transaksi, $data);

        // cek jika jenis == Rencana, update kolom jlh_sementara
        if ($jenis === 'Rencana' && !empty($id_ren)) {

            $renc = $this->rencana->find($id_ren);

            if ($renc) { // pastikan datanya ada
                $jlhi = (int) $jumlah; //jumlah di form input
                $jlhd = (int) $renc['jlh_sementara']; //jlh_sementara di tabel rencana
                if ($jlhi > $jlhd) {
                    $jlhs = $jlhd + ($jlhi - $jlhd);
                } else {
                    $jlhs = $jlhd - ($jlhd - $jlhi);
                }

                $this->rencana->update($id_ren, [
                    'jlh_sementara' => $jlhs
                ]);
            }
        }

        // recalc rekening lama jika pindah
        if ($trx['id_rekening'] != $id_rek) {
            $this->transaksi->recalculateSaldoRekening($trx['id_rekening']);
        }

        // recalc rekening baru
        $saldoAkhir = $this->transaksi->recalculateSaldoRekening($id_rek);

        // kalau saldo akhir minus → rollback
        if ($saldoAkhir < 0) {
            $this->db->transRollback();
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Saldo tidak mencukupi setelah perubahan'
            ]);
        }

        $this->db->transComplete();

        return $this->response->setJSON([
            'status' => true
        ]);
    }

    public function saldoRekening($id)
    {
        $rekening = $this->rekening
            ->select('saldo')
            ->find($id);

        return $this->response->setJSON($rekening);
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        if (!$id) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'ID tidak ditemukan'
            ]);
        }

        // ambil data transaksi dulu
        $trx = $this->transaksi->find($id);

        $this->db->transStart();
        if (!$trx) { //validasi kalo data transaksi ga ada
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Data transaksi tidak ditemukan'
            ]);
        }
        $jumlah = $trx['jumlah'];
        $jenis = $trx['jenis'];
        $rincian = $trx['rincian'];
        $id_rek = $trx['id_rekening'];
        $id_ren = $trx['id_rencana'];

        // ambil saldo rekening
        $rekening = $this->rekening->find($id_rek);
        if (!$rekening) { //validasi kalo datanya ga ada
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Rekening tidak ditemukan'
            ]);
        }
        $saldo = $rekening['saldo'];

        // 🔥 BALIKKAN EFEK INSERT
        if ($jenis == 'Penghasilan' || $jenis == 'Rencana') {
            $saldoBaru = $saldo - $jumlah;
        } else {
            $saldoBaru = $saldo + $jumlah;
        }

        // update saldo rekening
        if ($jenis == 'Mutasi') {
            $idr = 1;
            $this->rekening->update($idr, [
                'saldo' => $saldoBaru
            ]);
        } elseif ($jenis === 'Rencana') {
            //ambil data rencana yg dipilih
            $renc = $this->rencana->find($id_ren);
            if (!$renc) { //validasi kalo datanya ga ada
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Data rencana tidak ditemukan'
                ]);
            }
            $jlhs = $renc['jlh_sementara'];
            $this->rekening->update($id_rek, [
                'saldo' => $saldoBaru
            ]);
            $jlhs1 = $jlhs - $jumlah;
            $this->rencana->update($id_ren, [
                'jlh_sementara' => $jlhs1
            ]);
        } else {
            $this->rekening->update($id_rek, [
                'saldo' => $saldoBaru
            ]);
        }

        // hapus transaksi
        $this->transaksi->delete($id);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Gagal menghapus data'
            ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function exportPDF()
    {
        helper('tglindo');
        $request = service('request');

        $keyword = $request->getGet('keyword');
        $bidang  = $request->getGet('bidang');
        $from    = $request->getGet('from');
        $to      = $request->getGet('to');

        $builder = $this->transaksi
            ->select('transaksi.*, rekening.nama_bank')
            ->join('rekening', 'rekening.id_rekening = transaksi.id_rekening');

        // FILTER 🔽
        if ($keyword) {
            $builder->groupStart()
                ->like('deskripsi', $keyword)
                ->orLike('rincian', $keyword)
                ->groupEnd();
        }

        if ($bidang && $bidang != 'Semua Bidang') {
            $builder->where('jenis', $bidang);
        }

        if ($from && $to) {
            $builder->where('tanggal >=', $from)
                ->where('tanggal <=', $to);
        }

        $data = [
            'transaksi' => $builder->orderBy('tanggal', 'ASC')->findAll(),
            'from'      => $from,
            'to'        => $to
        ];

        // LOAD VIEW
        $html = view('transaksi/pdf_template', $data);

        // DOMPDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("Riwayat_Transaksi.pdf", ["Attachment" => false]);
    }
}
