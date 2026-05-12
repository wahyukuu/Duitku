<?php

namespace App\Controllers;

use App\Models\AsetModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Dompdf\Dompdf;

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

        // 🧱 BASE BUILDER (bersih)
        $builder = $this->aset->builder();

        // 🔍 FILTER JENIS
        if (!empty($jenis)) {
            $builder->where('jenis_aset', $jenis);
        }

        // 🔍 FILTER KEYWORD
        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('nama_aset', $keyword)
                ->orLike('jenis_aset', $keyword)
                ->orLike('tahun_perolehan', $keyword)
                ->groupEnd();
        }

        // 🧮 TOTAL (CLONE BIAR SAMA FILTER)
        $totalBuilder = clone $builder;
        $total = $totalBuilder
            ->selectSum('nilai_sekarang')
            ->get()
            ->getRow()
            ->nilai_sekarang ?? 0;

        // 📄 DATA + PAGINATION (PAKAI MODEL, BUKAN BUILDER)
        $model = new \App\Models\AsetModel();

        // apply filter ulang ke model (WAJIB)
        if (!empty($jenis)) {
            $model->where('jenis_aset', $jenis);
        }

        if (!empty($keyword)) {
            $model->groupStart()
                ->like('nama_aset', $keyword)
                ->orLike('jenis_aset', $keyword)
                ->orLike('tahun_perolehan', $keyword)
                ->groupEnd();
        }

        $data  = $model->paginate($perPage, 'aset');
        $pager = $model->pager;

        return $this->response->setJSON([
            'data'      => $data,
            'total'     => (int) $total,
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
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        if (!$id) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Data tidak Ditemuka'
            ]);
        }

        $this->aset->delete($id);
        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function exportPDF()
    {
        helper('tglindo');
        $request = service('request');

        $keyword = $request->getGet('keyword');
        $jenis  = $request->getGet('jenis');
        $from    = $request->getGet('from');
        $to      = $request->getGet('to');

        $builder = $this->aset->builder();

        // FILTER 🔽
        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('nama_aset', $keyword)
                ->like('jenis_aset', $keyword)
                ->like('tahun_perolehan', $keyword)
                ->orLike('cara_perolehan', $keyword)
                ->groupEnd();
        }

        if (!empty($jenis)) {
            $builder->where('jenis_aset', $jenis);
        }

        // 📅 FILTER tanggal (opsional)
        if (!empty($from) && !empty($to)) {
            $builder->where('tahun_perolehan >=', $from)
                ->where('tahun_perolehan <=', $to);
        }

        // 💰 TOTAL (BIAR SAMA DENGAN TABEL)
        $total1 = (clone $builder)
            ->selectSum('nilai_perolehan')
            ->get()
            ->getRow()
            ->nilai_perolehan ?? 0;
        $total2 = (clone $builder)
            ->selectSum('nilai_sekarang')
            ->get()
            ->getRow()
            ->nilai_sekarang ?? 0;

        $aset = $builder
            ->orderBy('tahun_perolehan', 'ASC')
            ->get()
            ->getResultArray();

        $data = [
            'aset'  => $aset,
            'total1' => $total1,
            'total2' => $total2,
            'from'  => $from,
            'to'    => $to
        ];

        // LOAD VIEW
        $html = view('aset/pdf_template', $data);

        // DOMPDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('F4', 'landscape');
        $dompdf->render();
        $dompdf->stream("Daftar Aset.pdf", ["Attachment" => false]);
    }
}
