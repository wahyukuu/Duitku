<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Dompdf\Dompdf;

class Laporan extends BaseController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $bulan = (int)date('M');
        $tahun = (int)date('Y');

        $totalPenghasilan = $this->transaksi->totalByBidang('Penghasilan');
        $totalPengeluaran = $this->transaksi->totalByBidang('Pengeluaran');
        $asetTetap = $this->aset->totalNilaiAset();
        $totalsaldo = $this->rekening->totalSaldoAllRekening();
        $totalRencana = $this->transaksi->totalRencana();
        $asetTidakTetap = $totalsaldo + $totalRencana;
        $totalAset = $asetTetap + $asetTidakTetap;
        $sisahutang = $this->transaksi->sisaHutang();
        $sisapiutang = $this->transaksi->sisaPiutang();

        $data = [
            'total' => $totalsaldo,
            'masuk' => $this->transaksi->totalByBulanDanBidang('Penghasilan'),
            'keluar' => $this->transaksi->totalByBulanDanBidang('Pengeluaran'),
            'utama' => $this->rekening->getRekeningPrioritas(), //pake rekening BSI
            'tmasuk' => $totalPenghasilan,
            'tkeluar' => $totalPengeluaran,
            'invest' => $this->transaksi->totalRencana(),
            'aset' => $totalAset,
            'fixedaset' => $asetTetap,
            'nfixedaset' => $asetTidakTetap,
            'hutang'      => (int)$sisahutang,
            'piutang'     => (int)$sisapiutang,
            // 'utama' => $this->rekening->countRekeningPrioritas()
        ];
        // dd($data['utama']);
        return view('laporan/index', $data);
    }

    public function getTotalBulanIni()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/');
        }

        $penghasilan = $this->transaksi->totalByBulanDanBidang('Penghasilan');
        $pengeluaran = $this->transaksi->totalByBulanDanBidang('Pengeluaran');
        $sisahutang = $this->transaksi->sisaHutang();
        $sisapiutang = $this->transaksi->sisaPiutang();
        $totalPenghasilan = $this->transaksi->totalByBidang('Penghasilan');
        $totalPengeluaran = $this->transaksi->totalByBidang('Pengeluaran');

        return $this->response->setJSON([
            'pengeluaran' => (int)$pengeluaran,
            'penghasilan' => (int)$penghasilan,
            'thasil'      => (int)$totalPenghasilan,
            'tkeluar'     => (int)$totalPengeluaran,
            'hutang'      => (int)$sisahutang,
            'piutang'     => (int)$sisapiutang,
        ]);
    }

    public function preview()
    {
        $from   = $this->request->getGet('from');
        $to     = $this->request->getGet('to');
        $jenis  = $this->request->getGet('jenis');

        //ambil data transaksi
        $transaksi = $this->transaksi->getTotalTransaksi($from, $to);
        $totalPenghasilan = 0;
        $totalPengeluaran = 0;
        $totalRencana = 0;
        foreach ($transaksi as $trx) {
            if ($trx['jenis'] == 'Penghasilan') {
                $totalPenghasilan += $trx['jumlah']; //hitung total penghasilan
            } elseif ($trx['jenis'] == 'Pengeluaran') {
                $totalPengeluaran += $trx['jumlah']; //hitung total pengeluaran
            } elseif ($trx['jenis'] == 'Rencana') {
                $totalRencana += $trx['jumlah']; //hitung total rencana/investasi
            }
        }
        $saldoTersedia = $totalPenghasilan - $totalPengeluaran;

        //total piutang
        $totalPiutang = $this->transaksi->totalPiutang();
        $sisapiutang = $this->transaksi->sisaPiutang();
        //rekening prioritas (BSI)
        $prioritas = $this->rekening->getRekeningPrioritas();
        //saldo seluruh rekening
        $totalSaldo = $this->rekening->totalSaldoAllRekening();
        // total rencana/investasi
        $totalRencana = $this->transaksi->totalRencana();

        // aset tetap
        $kendaraan = $this->aset->getByJenisAset('Kendaraan');
        $bangunan = $this->aset->getByJenisAset('Bangunan');
        $tanah = $this->aset->getByJenisAset('Tanah');
        $peralatan = $this->aset->getByJenisAset('Peralatan');
        $mesin = $this->aset->getByJenisAset('Mesin');
        $peralatanl = $this->aset->getByJenisAset('Peralatan Lainnya');
        $asetl = $this->aset->getByJenisAset('Aset Lainnya');

        // kewajiban
        $totalHutang = $this->transaksi->totalHutang();
        $sisahutang = $this->transaksi->sisaHutang();

        // bagian kekayaan
        $asetTetap = $this->aset->totalNilaiAset();
        $kewajiban = $totalHutang;
        $totalAset = $totalSaldo + $totalRencana + $asetTetap;
        $totalHarta = $totalAset - $totalHutang;

        $data['from'] = $from ?: date('Y-m-01');
        $data['to']   = $to ?: date('Y-m-t');
        $data = [
            'from' => $from,
            'to' => $to,
            'pemasukan' => $totalPenghasilan,
            'pengeluaran' => $totalPengeluaran,
            'ready' => $saldoTersedia,
            'piutang' => $sisapiutang,
            'operasional' => $prioritas['saldo'],
            'saldo' => $totalSaldo,
            'investasi' => $totalRencana,
            'kendaraan' => $kendaraan,
            'bangunan' => $bangunan,
            'tanah' => $tanah,
            'peralatan' => $peralatan,
            'mesin' => $mesin,
            'peralatanl' => $peralatanl,
            'asetl' => $asetl,
            'hutang' => $sisahutang,
            'aset' => $totalAset,
            'kewajiban' => $kewajiban,
            'kekayaan' => $totalHarta,
        ];

        helper('tglindo');
        $html = view('laporan/pdf_template', $data);

        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true);
        $options->set('chroot', FCPATH); // penting

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream('Laporan.pdf', ['Attachment' => false]);
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
        //
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
        //
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
        //
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
        //
    }
}
