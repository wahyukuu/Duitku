<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Auth extends BaseController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    protected $db;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->db   =  \Config\Database::connect();
    }

    public function login()
    {
        // buat agar ketika belum login tidak bisa akses lgsung ke dashboard
        // if (session('id_user')) {
        //     return redirect()->to('home');
        // }
        return view('layout/login');
    }

    public function masuk()
    {
        $user = $this->request->getVar('username');
        $pass = $this->request->getVar('password');

        $admin = $this->admin->cekAdmin($user);

        if (! $admin) {
            return redirect()->back()->with('error', 'Akun tidak DITEMUKAN BRAYYY');
        }

        if (! password_verify($pass, $admin['password'])) {
            return redirect()->back()->with('error', 'Password SALAH BRAYYY');
        }

        session()->set([
            'id_admin'  => $admin['id_admin'],
            'username'  => $admin['username'],
            'level'     => $admin['level'],
            'logged_in' => true
        ]);

        return redirect()->to('/dashboard');
    }


    public function logout()
    {
        session()->remove('id_admin');
        return redirect()->to('login');
    }

    public function index()
    {
        //
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
        //
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
        //
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
        //
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
