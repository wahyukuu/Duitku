<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table            = 'kategori';
    protected $primaryKey       = 'id_kategori';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'jenis',
        'bidang',
        'rincian',
        'deskripsi'
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
        'jenis'      => 'required',
        'bidang'     => 'required',
        'rincian'    => 'required|min_length[5]',
        'deskripsi'  => 'required|min_length[5]',
    ];
    protected $validationMessages   = [
        'jenis'    => [
            'required'  => 'Jenis harus diisi',
        ],
        'bidang'   => [
            'required'  =>  'Bidang tidak boleh kosong',
        ],
        'rincian'    =>  [
            'required'      => 'Rincian harus diisi',
            'min_length'   => 'Rincian anda terlalu singkat',
        ],
        'deskripsi' => [
            'required'      => 'Deskripsi masih kosong',
            'min_length'    => 'Deskripsi anda terlalu singkat',
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

    public function getAllKategori()
    {
        return $this->findAll();
    }

    public function getKategoriById($id_kategori)
    {
        return $this->find($id_kategori);
    }

    public function updateKategori($id_kategori, $data)
    {
        return $this->update($id_kategori, $data);
    }

    public function insertKategori($data)
    {
        return $this->insert($data);
    }

    public function deleteKategori($id_kategori)
    {
        return $this->delete($id_kategori);
    }

    
}
