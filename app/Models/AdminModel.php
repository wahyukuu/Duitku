<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
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
        'password',
        'level'
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
        'username' => 'required|min_length[4]|regex_match[/^[a-zA-Z0-9_]+$/]',
        'password' => 'min_length[4]',
        'level'    => 'required',
    ];
    protected $validationMessages   = [
        'username' => [
            'required'    => 'Username Harus Diisi',
            'min_length'  => 'Panjang karakter Username minimal 4 karakter',
            'regex_match' => 'Karakter yang anda masukkan tidak sesuai',
        ],
        'password' => [
            'min_length'  => 'Panjang Password minimal 4 karakter',
        ],
        'level'    => [
            'required'    => 'Level User Harus Diisi',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['hashPassword'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['hashPassword'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password']) && $data['data']['password'] !== '') {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }

        return $data;
    }

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
