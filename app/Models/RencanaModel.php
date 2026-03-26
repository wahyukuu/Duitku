<?php

namespace App\Models;

use CodeIgniter\Model;

class RencanaModel extends Model
{
    protected $table            = 'rencana';
    protected $primaryKey       = 'id_rencana';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'deskripsi',
        'target',
        'id_rekening',
        'nama_bank',
        'jlh_sementara',
        'jangka',
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
        'deskripsi'   => 'required',
        'target'      => 'required|numeric',
        'id_rekening' => 'required',
        'jangka'      => 'required',
    ];
    protected $validationMessages   = [
        'deskripsi' => [
            'required'  => 'Deskripsi masih kosong',
        ],
        'target'    => [
            'required'  => 'Jumlah Target harus diisi',
            'numeric'   => 'Jumlah Target harus angka',
        ],
        'id_rekening'   => [
            'required'  =>  'Rekening tidak boleh kosong',
        ],
        'jangka'    =>  [
            'required'  => 'Jangka Waktu harus diisi'
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

    public function getAllRencana()
    {
        return $this->findAll();
    }

    public function getRencanaById($id_rencana)
    {
        return $this->find($id_rencana);
    }

    public function tambahRencana($data)
    {
        return $this->insert($data);
    }

    public function hapusRencana($id_rencana)
    {
        return $this->delete($id_rencana);
    }

    public function updateRencana($id_rencana, $data)
    {
        return $this->update($id_rencana, $data);
    }

    public function getRencanaJoinRekening()
    {
        return $this
            ->select('rencana.*, rekening.nama_bank')
            ->join('rekening', 'rekening.id_rekening = rencana.id_rekening', 'left');
    }

    public function getRencanaByDesc($rincian)
    {
        return $this->where('deskripsi', $rincian)->first();
    }
}
