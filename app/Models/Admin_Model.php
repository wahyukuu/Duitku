<?php

namespace App\Models;

use CodeIgniter\Model;

class Admin_Model extends Model
{
    protected $table            = 'admin';
    protected $primaryKey       = 'id_admin';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_admin',
        'username',
        'password'
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
    protected $validationRules      = [];
    protected $validationMessages   = [];
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

    public function cekAdmin($user)
    {
        return $this->where('username', $user)->first();
    }

    public function getAdminAll()
    {
        return $this->findAll();
    }

    public function getAdminById($id_admin)
    {
        return $this->find($id_admin);
    }

    public function insertAdmin($data)
    {
        return $this->insert($data);
    }

    public function updateAdmin($id_admin, $data)
    {
        return $this->update($id_admin, $data);
    }
}
