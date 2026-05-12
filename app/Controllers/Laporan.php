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
        $data = [
            'total' => $this->rekening->totalSaldoAllRekening(),
            'masuk' => $this->transaksi->totalByBulanDanBidang('Penghasilan'),
            'keluar' => $this->transaksi->totalByBulanDanBidang('Pengeluaran'),
            'utama' => $this->rekening->getRekeningPrioritas() //pake rekening BSI
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

        $pengeluaran = $this->transaksi->totalByBulanDanBidang('Pengeluaran');
        $penghasilan = $this->transaksi->totalByBulanDanBidang('Penghasilan');
        $sisahutang = $this->transaksi->jlhSisaHutang();
        $sisapiutang = $this->transaksi->jlhSisaPiutang();

        return $this->response->setJSON([
            'pengeluaran' => $pengeluaran['jumlah'] ?? 0,
            'penghasilan' => $penghasilan['jumlah'] ?? 0,
            'hutang' => $sisahutang,
            'piutang' => $sisapiutang,
        ]);
    }

    public function preview()
    {
        $from   = $this->request->getGet('from');
        $to     = $this->request->getGet('to');
        $jenis  = $this->request->getGet('jenis');

        $transaksi = $this->transaksi
            ->where('tanggal >=', $from)
            ->where('tanggal <=', $to)
            ->whereNotIn('rincian', ['Mutasi', 'Rencana'])
            ->findAll();

        $prioritas = $this->rekening->getRekeningPrioritas();

        $sisahutang = $this->transaksi->jlhSisaHutang();
        $sisapiutang = $this->transaksi->jlhSisaPiutang();
        $totalSaldo = $this->rekening->totalSaldoAllRekening();

        $totalPenghasilan = 0;
        $totalPengeluaran = 0;
        $totalRencana = 0;

        foreach ($transaksi as $trx) {
            if ($trx['jenis'] == 'Penghasilan') {
                $totalPenghasilan += $trx['jumlah'];
            } elseif ($trx['jenis'] == 'Pengeluaran') {
                $totalPengeluaran += $trx['jumlah'];
            } elseif ($trx['jenis'] == 'Rencana') {
                $totalRencana += $trx['jumlah'];
            }
        }

        $totalHutang = $this->transaksi->totalHutang();
        $totalPiutang = $this->transaksi->totalPiutang();
        $totalRencana = $this->transaksi->totalRencana();
        $totalAset = $this->aset
            ->selectSum('nilai_sekarang')
            ->get()
            ->getRow()
            ->nilai_sekarang ?? 0;;
        $totalInvestasi = $this->transaksi->totalInvestasi();
        // $totalAset = $totalSaldo + $totalRencana + $totalInvestasi + $nilaiAsetTetap;
        // $kewajiban = $thutang;
        $data['from'] = $from ?: date('Y-m-01');
        $data['to']   = $to ?: date('Y-m-t');
        $data = [
            'from' => $from,
            'to' => $to,
            'pemasukan' => $totalPenghasilan,
            'pengeluaran' => $totalPengeluaran,
            'rencana' => $totalRencana,
            'operasional' => $prioritas['saldo'],
            'saldo' => $totalSaldo,
            'thutang' => $totalHutang,
            'hutang' => $sisahutang,
            'piutang' => $sisapiutang,
            'rencana' => $totalRencana,
            'investasi' => $totalInvestasi,
            // 'kekayaan' => $totalAset - $kewajiban,
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
