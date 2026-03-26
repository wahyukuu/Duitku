<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Dashboard extends BaseController
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
        return view('dashboard/index', $data);
    }

    public function getTotalBulanIni()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/');
        }

        $pengeluaran = $this->transaksi->totalByBulanDanBidang('Pengeluaran');

        $penghasilan = $this->transaksi->totalByBulanDanBidang('Penghasilan');

        return $this->response->setJSON([
            'pengeluaran' => $pengeluaran['jumlah'] ?? 0,
            'penghasilan' => $penghasilan['jumlah'] ?? 0
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
