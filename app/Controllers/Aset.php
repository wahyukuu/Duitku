<?php

namespace App\Controllers;

use App\Models\AsetModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

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
        $data['aset'] = $this->aset->findAll(); // cara 2
        // $data['aset'] = $this->AsetModel->findAll(); // cara 1
        return view('aset/index', $data);
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
