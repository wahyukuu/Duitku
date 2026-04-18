<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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

    public function exportxls()
    {
        // $kontak = $this->kontak->findAll();
        $filename = 'Kategori-' . date('d-m-Y_H-i-s') . '.xlsx';
        $keyword = $this->request->getVar('search');
        $builder = $this->kategori; //cara 1
        // $builder->join('grup', 'grup.id_grup = kontak.id_grup');
        // MULAI DARI SINI YA
        if ($keyword != '') {
            $builder->like('jenis', $keyword);
            $builder->orLike('bidang', $keyword);
            $builder->orLike('rincian', $keyword);
            $builder->orLike('deskripsi', $keyword);
            $filename = 'Kategori-' . $keyword . '-' . date('d-m-Y') . '.xlsx';
        }
        $kategori = $builder->get()->getResultArray();

        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', 'No');
        $activeWorksheet->setCellValue('B1', 'Jenis');
        $activeWorksheet->setCellValue('C1', 'Bidang');
        $activeWorksheet->setCellValue('D1', 'Rincian');
        $activeWorksheet->setCellValue('E1', 'Deskripsi');

        $col = 2; //kolom start 
        foreach ($kategori as $key => $k) {
            $activeWorksheet->setCellValue('A' . $col, ($col - 1));
            $activeWorksheet->setCellValue('B' . $col, $k['jenis']);
            $activeWorksheet->setCellValue('C' . $col, $k['bidang']);
            $activeWorksheet->setCellValue('D' . $col, $k['rincian']);
            $activeWorksheet->setCellValue('E' . $col, $k['deskripsi']);
            $col++;
        }

        //agar ada bordernya
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $activeWorksheet->getStyle('A1:E' . ($col - 1))->applyFromArray($styleArray);

        //agar row untuk judul fontnya tebal
        $activeWorksheet->getStyle('A1:E1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $activeWorksheet->getStyle('A1:E1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $activeWorksheet->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $activeWorksheet->getStyle('A:E')->getFont()->setName('Bookman Old Style');
        $activeWorksheet->getStyle('A:E')->getFont()->setSize(10);
        $activeWorksheet->getStyle('A1:E1')->getFont()->setBold(true);
        $activeWorksheet->getStyle('A1:E1')->getFont()->setSize(14);

        //setting agar kolom autosize sesuai panjang tulisan
        $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('D')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('E')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('F')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('G')->setAutoSize(true);
        $writer = new Xlsx($spreadsheet);

        //agar auto save
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename);
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }

    // function importxls()
    // {
    //     $file = $this->request->getFile('file_excel');
    //     $extn = $file->getExtension();
    //     if ($extn == 'xlsx' || $extn == 'xls') {
    //         if ($extn == 'xlsx') {
    //             $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    //         } else {
    //             $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
    //         }
    //         $spreadsheet = $reader->load($file);
    //         $kontak = $spreadsheet->getActiveSheet()->toArray();

    //         foreach ($kontak as $i => $k) {
    //             if ($i == 0) {
    //                 continue;
    //             }
    //             $data = [
    //                 'nama_kontak' => $k[1],
    //                 'nama_alias' => $k[2],
    //                 'telepon' => $k[3],
    //                 'email' => $k[4],
    //                 'alamat' => $k[5],
    //                 'info' => $k[6],
    //                 'id_grup' => 2
    //             ];
    //             $this->kontak->insert($data);
    //         }
    //         return redirect()->to('/kontak')->with('success', 'Import Data berhasil Ditambahkan');
    //     } else {
    //         return redirect()->back()->with('error', 'Format File tidak sesuai');
    //     }
    // }
}
