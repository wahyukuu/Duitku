<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

//controller Auth
$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');
$routes->post('/auth/masuk', 'Auth::masuk');
$routes->get('/auth/keluar', 'Auth::logout');

// AREA YANG BUTUH LOGIN
$routes->group('', ['filter' => 'auth'], function ($routes) {
  $routes->get('dashboard', 'Dashboard::index');
});

//agar level user biasa gabisa akses menu2 yang ada di admin
$routes->group('', ['filter' => ['auth', 'admin']], function ($routes) {
  $routes->get('/', 'Auth::login');
  $routes->get('admin', 'Admin::index');
  $routes->get('kategori', 'Kategori::index');
  $routes->get('rekening', 'Rekening::index');
});

//controller Dashboard
$routes->get('/dashboard/total', 'Dashboard::getTotalBulanIni');
$routes->resource('dashboard');

//controller Asset
$routes->resource('aset');

//controller Transaksi
$routes->get('/transaksi/data', 'Transaksi::dataAjax');
$routes->post('/transaksi/simpan', 'Transaksi::simpanAjax');
$routes->get('/transaksi/rencana', 'Transaksi::kategoriByRencana');
$routes->get('/transaksi/rekening', 'Transaksi::semuaRekening');
$routes->get('/transaksi/tabungan', 'Transaksi::tabunganInvestasi');
$routes->get('/transaksi/rincian/(:any)', 'Transaksi::kategoriByRincian/$1');
$routes->get('/transaksi/kategori/(:any)', 'Transaksi::kategoriByBidang/$1');
$routes->get('/transaksi/rekening/(:segment)', 'Transaksi::rekeningByBidang/$1');
$routes->get('transaksi/show/(:num)', 'Transaksi::show/$1');
$routes->post('transaksi/update/(:num)', 'Transaksi::update/$1');
$routes->get('transaksi/saldo/(:num)', 'Transaksi::saldoRekening/$1');
$routes->delete('transaksi/delete/(:num)', 'Transaksi::delete/$1');
$routes->get('transaksi/export', 'Transaksi::exportPDF');
$routes->resource('transaksi');

//controller Rekening
$routes->get('/rekening/data', 'Rekening::dataAjax');
$routes->post('/rekening/simpan', 'Rekening::simpanAjax');
$routes->get('rekening/show/(:num)', 'Rekening::show/$1');
$routes->post('rekening/update/(:num)', 'Rekening::update/$1');
$routes->delete('rekening/delete/(:num)', 'Rekening::delete/$1');
$routes->resource('rekening');

//controller Perencanaan
$routes->get('/perencanaan/data', 'Perencanaan::dataAjax');
$routes->get('/perencanaan/tabungan', 'Perencanaan::tabunganInvestasi');
$routes->post('/perencanaan/simpan', 'Perencanaan::simpanAjax');
$routes->get('perencanaan/show/(:num)', 'Perencanaan::show/$1');
$routes->post('perencanaan/update/(:num)', 'Perencanaan::update/$1');
$routes->get('perencanaan/saldo/(:num)', 'Perencanaan::saldoRekening/$1');
$routes->delete('perencanaan/delete/(:num)', 'Perencanaan::delete/$1');
$routes->resource('perencanaan');

//controller Kategori
$routes->get('/kategori/data', 'Kategori::dataAjax');
$routes->post('/kategori/simpan', 'Kategori::simpanAjax');
$routes->get('kategori/show/(:num)', 'Kategori::show/$1');
$routes->post('kategori/update/(:num)', 'Kategori::update/$1');
$routes->delete('kategori/delete/(:num)', 'Kategori::delete/$1');
$routes->get('kategori/exportxls', 'Kategori::exportxls');
$routes->post('kategori/importxls', 'Kategori::importxls');
$routes->resource('kategori');

//controller Laporan
$routes->get('/laporan/total', 'Laporan::getTotalBulanIni');
$routes->get('/laporan/preview', 'Laporan::preview');
$routes->resource('laporan');

//controller Admin
$routes->get('/admin/data', 'Admin::dataAjax');
$routes->post('/admin/simpan', 'Admin::simpanAjax');
$routes->get('/admin/show/(:num)', 'Admin::show/$1');
$routes->post('/admin/update/(:num)', 'Admin::updateAjax/$1');
$routes->delete('/admin/delete/(:num)', 'Admin::delete/$1');
$routes->resource('admin');
