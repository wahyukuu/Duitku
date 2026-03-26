<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Rekening extends BaseController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */

    public function index()
    {
        $data['rekening'] = $this->rekening->getAllRekening();
        return view('rekening/index', $data);
    }

    public function dataAjax()
    {
        $perPage = $this->request->getGet('perPage') ?? 5;
        $keyword = $this->request->getGet('keyword');
        $jenis = $this->request->getGet('prioritas');
        if ($jenis) {
            $this->rekening->where('prioritas', $jenis);
        }
        if ($keyword) {
            $this->rekening
                ->groupStart()
                ->like('nama_bank', $keyword)
                ->orLike('no_rekening', $keyword)
                ->groupEnd();
        }

        $data = $this->rekening->paginate($perPage, 'rekening');
        $pager = $this->rekening->pager;

        return $this->response->setJSON([
            'data'      => $data,
            'current'   => $pager->getCurrentPage('rekening'),
            'totalPage' => $pager->getPageCount('rekening'),
            'totalData' => $pager->getTotal('rekening')
        ]);
    }

    public function simpanAjax()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400);
        }

        $data = [
            'nama_bank'     => $this->request->getPost('nama_bank'),
            'no_rekening'   => $this->request->getPost('no_rekening'),
            'saldo'         => $this->request->getPost('saldo'),
            'prioritas'     => $this->request->getPost('prioritas'),
        ];

        if (!$this->rekening->save($data)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->rekening->errors()
            ]);
        }

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Rekening Baru berhasil ditambahkan'
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
            $this->rekening->find($id)
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
            'nama_bank'     => $this->request->getPost('nama_bank'),
            'no_rekening'    => $this->request->getPost('no_rekening'),
            'saldo'   => $this->request->getPost('saldo'),
            'prioritas' => $this->request->getPost('prioritas'),
        ];

        $this->rekening->insertRekening($data);

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
            'id_rekening'   => $id,
            'nama_bank'     => $this->request->getPost('nama_bank'),
            'no_rekening'   => $this->request->getPost('no_rekening'),
            'saldo'         => $this->request->getPost('saldo'),
            'prioritas'     => $this->request->getPost('prioritas'),
        ];

        if (!$this->rekening->save($data)) {
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

        $this->rekening->delete($id);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
