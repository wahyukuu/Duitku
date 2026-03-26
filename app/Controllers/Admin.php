<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Admin extends BaseController
{
    public function index()
    {
        $data['admin'] = $this->admin->getAdminAll();
        return view('admin/index', $data);
    }

    public function dataAjax()
    {
        $perPage = $this->request->getGet('perPage') ?? 5;
        $keyword = $this->request->getGet('keyword');
        $jenis = $this->request->getGet('level');
        if ($jenis) {
            $this->admin->where('level', $jenis);
        }
        if ($keyword) {
            $this->admin
                ->groupStart()
                ->like('username', $keyword)
                ->groupEnd();
        }

        $data = $this->admin->paginate($perPage, 'admin');
        $pager = $this->admin->pager;

        return $this->response->setJSON([
            'data'      => $data,
            'current'   => $pager->getCurrentPage('admin'),
            'totalPage' => $pager->getPageCount('admin'),
            'totalData' => $pager->getTotal('admin')
        ]);
    }

    public function simpanAjax()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400);
        }

        $data = [
            'username'     => $this->request->getPost('username'),
            'password'      => $this->request->getPost('password'),
            'level'         => $this->request->getPost('level'),
        ];

        if (!$this->admin->save($data)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->admin->errors()
            ]);
        }

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'User Baru berhasil ditambahkan'
        ]);
    }

    public function show($id)
    {
        $admin = $this->admin->getAdminById($id);
        unset($admin['password']);
        return $this->response->setJSON($admin);
    }

    public function updateAjax()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400);
        }

        $id = $this->request->getPost('id_admin');

        $rules = [
            'username' => "required|min_length[3]|is_unique[admin.username,id_admin,$id]",
            'level'    => 'required',
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $data = [
            'id_admin' => $id,
            'username' => $this->request->getPost('username'),
            'level'    => $this->request->getPost('level'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            );
        }

        $this->admin->save($data);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Admin berhasil diupdate'
        ]);
    }
    
    public function delete($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        $this->admin->delete($id);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Data User berhasil dihapus'
        ]);
    }
}
