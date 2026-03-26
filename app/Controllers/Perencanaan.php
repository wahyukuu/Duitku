<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Perencanaan extends BaseController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $data['rencana'] = $this->rencana->getAllRencana();
        return view('perencanaan/index', $data);
    }

    public function dataAjax()
    {
        $perPage = $this->request->getGet('perPage') ?? 5;
        $keyword = $this->request->getGet('keyword');
        $jenis   = $this->request->getGet('jangka');

        $builder = $this->rencana->getRencanaJoinRekening();

        if ($jenis) {
            $builder->where('rencana.jangka', $jenis);
        }

        if ($keyword) {
            $builder->groupStart()
                ->like('rencana.deskripsi', $keyword)
                ->orLike('rekening.nama_bank', $keyword)
                ->orLike('rencana.jangka', $keyword)
                ->groupEnd();
        }

        $data  = $builder->paginate($perPage, 'rencana');
        $pager = $this->rencana->pager;

        return $this->response->setJSON([
            'data'      => $data,
            'current'   => $pager->getCurrentPage('rencana'),
            'totalPage' => $pager->getPageCount('rencana')
        ]);
    }

    public function tabunganInvestasi()
    {
        $data = $this->rekening->getRekeningTabungan();
        return $this->response->setJSON($data);
    }

    public function simpanAjax()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400);
        }

        $data = [
            'deskripsi' => $this->request->getPost('deskripsi'),
            'target' => $this->request->getPost('target'),
            'id_rekening' => $this->request->getPost('id_rekening'),
            'jlh_sementara' => $this->request->getPost('jlh_sementara'),
            'jangka' => $this->request->getPost('jangka'),
        ];

        if (!$this->rencana->save($data)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->rencana->errors()
            ]);
        }

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Data berhasil ditambahkan'
        ]);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id)
    {
        return $this->response->setJSON(
            $this->rencana->find($id)
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
            'deskripsi' => $this->request->getPost('deskripsi'),
            'target' => $this->request->getPost('target'),
            'id_rekening' => $this->request->getPost('id_rekening'),
            'nama_bank' => $this->request->getPost('nama_bank'),
            'jlh_sementara' => $this->request->getPost('jlh_sementara'),
            'jangka' => $this->request->getPost('jangka'),
        ];

        $this->rencana->tambahRencana($data);

        return redirect()->back()->with('success', 'Rekening berhasil ditambahkan');
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
    public function update($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400);
        }

        $data = [
            'id_rencana'    => $id, // penting untuk save() update
            'deskripsi'     => $this->request->getPost('deskripsi'),
            'target'        => $this->request->getPost('target'),
            'id_rekening'   => $this->request->getPost('id_rekening'),
            'jlh_sementara' => $this->request->getPost('jlh_sementara'),
            'jangka'        => $this->request->getPost('jangka'),
        ];

        if (!$this->rencana->save($data)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->rencana->errors()
            ]);
        }

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Data berhasil diupdate'
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
    public function delete($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        $this->rencana->delete($id);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
