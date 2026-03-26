<?php

namespace App\Models;

use CodeIgniter\Model;

class RekeningModel extends Model
{
    protected $table            = 'rekening';
    protected $primaryKey       = 'id_rekening';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_bank',
        'no_rekening',
        'saldo',
        'prioritas'
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
        'nama_bank'     => 'required',
        'no_rekening'   => 'required|numeric',
        'saldo'         => 'required|numeric',
        'prioritas'     => 'required',
    ];
    protected $validationMessages   = [
        'nama_bank' => [
            'required'  => 'Nama Bank masih kosong',
        ],
        'no_rekening'    => [
            'required'  => 'Nomor Rekening Tidak Boleh Kosong',
            'numeric'   => 'Nomor Rekening harus berupa Angka',
        ],
        'saldo'   => [
            'required'  => 'Saldo tidak boleh kosong',
            'numeric'   => 'Saldo harus berupa Angka',
        ],
        'prioritas'    =>  [
            'required'  => 'Prioritas Penggunaan Rekening harus diisi'
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

    public function getAllRekening()
    {
        return $this->findAll();
    }

    public function getRekeningById($id_rekening)
    {
        return $this->find($id_rekening);
    }

    public function insertRekening($data)
    {
        return $this->insert($data);
    }

    //ambil rekening BSI utama
    public function getRekeningPrioritas()
    {
        return $this->where('prioritas', 'Operasional')->first();
    }

    //ambil rekening tabungan/investasi
    public function getRekeningTabungan()
    {
        return $this->whereIn('prioritas', ['Tabungan', 'Investasi'])
            ->findAll();
    }

    //kalo mau totalin jumlah uang yang bisa dipake
    public function countRekeningPrioritas()
    {
        $operasional = 'Operasional';
        return $this->selectSum('saldo')
            ->where('prioritas', $operasional)
            ->get()
            ->getRow()
            ->saldo ?? 0;
    }

    public function totalSaldoAllRekening()
    {
        return $this->selectSum('saldo')
            ->get()
            ->getRow()
            ->saldo ?? 0;
    }
}
