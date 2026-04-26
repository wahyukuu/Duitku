<?php

namespace App\Controllers;

use App\Models\AsetModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Aset extends ResourceController
{
    // // cara 1 tanpa constructor (use App\Models\AsetModelnya dihapus aja)
    // // pake cara ini biar bisa pake sintaks model lgsung di controller
    // /**
    //  * @var \App\Models\AsetModel
    //  */
    // protected $AsetModel = 'App\Models\AsetModel';
    // protected $format = 'json';

    //cara 2 dengan constructor (pake yang dikomen di baris 5)
    protected $aset;
    public function __construct()
    {
        $this->aset = new AsetModel();
    }
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        //mulai dari sini
        $data['aset'] = $this->aset->getAllAset(); // cara 2
        // $data['aset'] = $this->AsetModel->findAll(); // cara 1
        return view('aset/index', $data);
    }

    public function dataAjax()
    {
        $perPage = $this->request->getGet('perPage') ?? 5;
        $keyword = $this->request->getGet('keyword');
        $jenis   = $this->request->getGet('jenis');

        // $builder = $this->aset->getAllAset();

        if ($jenis && $jenis != 'Semua Aset') {
            $this->aset->where('jenis_aset', $jenis);
        }

        if ($keyword) {
            $this->aset->groupStart()
                ->like('nama_aset', $keyword)
                ->orLike('jenis_aset', $keyword)
                ->orLike('tahun_perolehan', $keyword)
                ->groupEnd();
        }

        $data  = $this->aset->paginate($perPage, 'aset');
        $pager = $this->aset->pager;

        return $this->response->setJSON([
            'data'      => $data,
            'current'   => $pager->getCurrentPage('aset'),
            'totalPage' => $pager->getPageCount('aset')
        ]);
    }

    public function totalNilai()
    {
        $total = $this->aset
            ->selectSum('nilai_sekarang')
            ->get()
            ->getRow()
            ->nilai_sekarang ?? 0;

        return $this->response->setJSON([
            'total' => (int) $total
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
            $this->aset->getAsetById($id)
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
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400);
        }

        // ambil semua data POST sekaligus
        $data = $this->request->getPost();

        // bersihkan format rupiah
        $data['nilai_perolehan'] = preg_replace('/[^0-9]/', '', $data['nilai_perolehan']);
        $data['nilai_sekarang']  = preg_replace('/[^0-9]/', '', $data['nilai_sekarang']);

        // ubah ke integer (optional tapi bagus)
        $data['nilai_perolehan'] = (int) $data['nilai_perolehan'];
        $data['nilai_sekarang']  = (int) $data['nilai_sekarang'];

        // DEBUG kalau perlu
        // dd($data);

        // pakai save biar validasi model pasti jalan
        if (!$this->aset->save($data)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->aset->errors(),
            ]);
        }

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Aset Baru berhasil ditambahkan'
        ]);
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

        $data = $this->request->getPost();

        $data['nilai_perolehan'] = preg_replace('/[^0-9]/', '', $data['nilai_perolehan']);
        $data['nilai_sekarang']  = preg_replace('/[^0-9]/', '', $data['nilai_sekarang']);

        $data['nilai_perolehan'] = (int) $data['nilai_perolehan'];
        $data['nilai_sekarang']  = (int) $data['nilai_sekarang'];

        if (!$this->aset->save($data)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->aset->errors(),
            ]);
        }

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Data Aset berhasil diperbarui'
        ]);
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
