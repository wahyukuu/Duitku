<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AdminModel;
use App\Models\AsetModel;
use App\Models\KategoriModel;
use App\Models\RekeningModel;
use App\Models\RencanaModel;
use App\Models\TransaksiModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    protected $db;
    protected $admin;
    protected $kategori;
    protected $rekening;
    protected $rencana;
    protected $transaksi;
    protected $aset;

    protected $helpers = ['rupiah'];

    /**
     * @return void
     */
    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        // $this->helpers = ['form', 'url'];

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);
        $this->admin = new AdminModel();
        $this->kategori = new KategoriModel();
        $this->rekening = new RekeningModel();
        $this->rencana = new RencanaModel();
        $this->transaksi = new TransaksiModel();
        $this->aset = new AsetModel();
    }
}
