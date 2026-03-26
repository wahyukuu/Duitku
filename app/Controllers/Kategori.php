<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Kategori extends BaseController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */



    public function index()
    {
        $data['kategori'] = $this->kategori->getAllKategori();
        return view('kategori/index', $data);
    }

    public function dataAjax()
    {
        $perPage = $this->request->getGet('perPage') ?? 5;
        $keyword = $this->request->getGet('keyword');
        $jenis = $this->request->getGet('bidang');
        if ($jenis) {
            $this->kategori->where('bidang', $jenis);
        }
        if ($keyword) {
            $this->kategori
                ->groupStart()
                ->like('jenis', $keyword)
                ->orLike('bidang', $keyword)
                ->orLike('rincian', $keyword)
                ->orLike('deskripsi', $keyword)
                ->groupEnd();
        }

        $data = $this->kategori->paginate($perPage, 'kategori');
        $pager = $this->kategori->pager;

        return $this->response->setJSON([
            'data'      => $data,
            'current'   => $pager->getCurrentPage('kategori'),
            'totalPage' => $pager->getPageCount('kategori'),
            'totalData' => $pager->getTotal('kategori')
        ]);
    }

    public function simpanAjax()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400);
        }

        $data = [
            'jenis'     => $this->request->getPost('jenis'),
            'bidang'    => $this->request->getPost('bidang'),
            'rincian'   => $this->request->getPost('rincian'),
            'deskripsi' => $this->request->getPost('deskripsi'),
        ];

        // validasi simpel
        if (!$this->kategori->save($data)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->kategori->errors()
            ]);
        }

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Kategori berhasil ditambahkan'
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
            $this->kategori->find($id)
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
            'jenis'     => $this->request->getPost('jenis'),
            'bidang'    => $this->request->getPost('bidang'),
            'rincian'   => $this->request->getPost('rincian'),
            'deskripsi' => $this->request->getPost('deskripsi'),
        ];

        $this->kategori->insertKategori($data);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan');
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
            'id_kategori' => $id,
            'jenis' => $this->request->getPost('jenis'),
            'bidang' => $this->request->getPost('bidang'),
            'rincian' => $this->request->getPost('rincian'),
            'deskripsi' => $this->request->getPost('deskripsi'),
        ];

        if (!$this->kategori->save($data)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->kategori->errors()
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

        $this->kategori->delete($id);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
