<?php

namespace App\Models;

use CodeIgniter\Model;

class AsetModel extends Model
{
    protected $table            = 'aset';
    protected $primaryKey       = 'id_aset';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_aset',
        'jenis_aset',
        'jumlah',
        'satuan',
        'cara_perolehan',
        'tahun_perolehan',
        'lokasi',
        'detail',
        'nilai_perolehan',
        'nilai_sekarang'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'nama_aset'         => 'required|min_length[2]',
        'jenis_aset'        => 'required',
        'jumlah'            => 'required|numeric',
        'satuan'            => 'required',
        'cara_perolehan'    => 'required',
        'tahun_perolehan'   => 'required',
        'lokasi'            => 'required|min_length[8]',
        'detail'            => 'required|min_length[8]',
        'nilai_perolehan'   => 'required|numeric|greater_than[0]',
        'nilai_sekarang'    => 'required|numeric|greater_than[0]',
    ];
    protected $validationMessages   = [
        'nama_aset' => [
            'required'    => 'Nama Aset masih kosong',
            'min_length'  => 'Nama Aset kurang dari 2 Karakter',
        ],
        'jenis_aset'    => [
            'required'  => 'Jenis Aset Tidak Boleh Kosong',
        ],
        'jumlah'   => [
            'required'  => 'Jumlah tidak boleh kosong',
            'numeric'   => 'Harus berupa Angka',
        ],
        'satuan'    =>  [
            'required'  => 'Satuan Aset tidak boleh kosong'
        ],
        'cara_perolehan'    =>  [
            'required'  => 'Cara perolehan Aset tidak boleh kosong'
        ],
        'tahun_perolehan'    =>  [
            'required'  => 'Tahun perolehan Aset tidak boleh kosong'
        ],
        'lokasi' => [
            'required'    => 'Lokasi Aset masih kosong',
            'min_length'  => 'Lokasi Aset kurang dari 8 Karakter',
        ],
        'detail' => [
            'required'    => 'Detail Aset masih kosong',
            'min_length'  => 'Detail Aset kurang dari 8 Karakter',
        ],
        'nilai_perolehan' => [
            'required'      => 'Nilai Beli Aset masih kosong',
            'numeric'       => 'Nilai Beli harus berupa angka',
            'greater_than'  => 'Nilai Beli harus Lebih besar 0',
        ],
        'nilai_sekarang' => [
            'required'      => 'Nilai sekarang Aset masih kosong',
            'numeric'       => 'Nilai sekarang harus berupa angka',
            'greater_than'  => 'Nilai Sekarang harus Lebih besar 0',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getAllAset()
    {
        return $this->findAll();
    }

    public function getAsetById($id_aset)
    {
        return $this->find($id_aset);
    }

    public function tambahAset($data)
    {
        return $this->insert($data);
    }

    public function updateAset($id, $data)
    {
        return $this->update($id, $data);
    }
}
