<?php

use App\Http\Controllers\Administrator;
use App\Http\Controllers\Auth;
use App\Http\Controllers\CustomerIdentificationFile;
use App\Http\Controllers\JualBeliMurabahah;
use App\Http\Controllers\Tabungan;
use App\Http\Controllers\Testing;
use App\Http\Controllers\UserManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Untuk Testing

Route::get('/tesCookie', [Testing::class, 'tesCookie']);

// Untuk Login
Route::post('/super/login', [Auth::class, 'login']);
Route::get('/super/tknCheck', [Auth::class, 'tokenCheck']);
Route::get('/super/cekLogin', [Auth::class, 'checkSudahLogin']);
Route::get('/super/keluar', [Auth::class, 'logout']);

// Untuk Administrator

Route::post('/super/adminLogin', [Administrator::class, 'adminLogin']);

// Sub Manajemen Mahasiswa
Route::get('/super/memberList', [Administrator::class, 'getMemberDataAll']);
Route::post('/super/addNewMember', [Administrator::class, 'addNewMember']);
Route::get('/super/memberListFilterBank/{bankKeys}', [Administrator::class, 'getMemberDataByBankId']);

// Sub Manajemen Grup
Route::get('/super/groupList', [Administrator::class, 'getGroupList']);
Route::post('/super/addNewGroup', [Administrator::class, 'addNewGroups']);

// Sub Manajemen Bank
Route::get('/super/bankList', [Administrator::class, 'getBankList']);
Route::get('/super/bankList/{keys}', [Administrator::class, 'getBankListById']);
Route::post('/super/addNewBank', [Administrator::class, 'addBankNew']);

// Sub Manajemen Role / Jenis Pekerjaan
Route::get('/super/roleList', [Administrator::class, 'getRoleList']);

// Untuk banking


Route::get('/listUser', [UserManagement::class, 'getDataUserAll']);

Route::get('/listUserDesc', [UserManagement::class, 'getDataUserWithDesc']);

// Sub CIF

Route::get('/bank/listCIF', [CustomerIdentificationFile::class, 'getDataCIFForTabel']);
Route::get('/bank/listCIF/{id}', [CustomerIdentificationFile::class, 'getDataCIFByIdForMurabahah']);
Route::get('/bank/listCIFAll', [CustomerIdentificationFile::class, 'getDataCIF']);
Route::post('/bank/tambahCIF', [CustomerIdentificationFile::class, 'insertDataCIF']);

// Sub Tabungan

Route::get('/bank/listProdukTabungan', [Tabungan::class, 'getDataProdukTabungan']);
Route::get('/bank/listTabunganTabel', [Tabungan::class, 'getDataTabunganForTabel']);
Route::post('/bank/listTabungan/Add', [Tabungan::class, 'insertDataTabungan']);

Route::get('/bank/listTabungan/{id}', [Tabungan::class, 'getDataTabunganForTransaksi']);
Route::post('/bank/tambahTransaksiTabungan', [Tabungan::class, 'insertTransaksiTabungan']);

// Sub Jual Beli Murabahah

Route::get('/bank/listJualBeliMurabahah', [JualBeliMurabahah::class, 'getDataTransaksiMurabahah']);
Route::get('/bank/listJualBeliMurabahah/{id}', [JualBeliMurabahah::class, 'getDataTransaksiMurabahahById']);
Route::post('/bank/listJualBeliMurabahah/Add', [JualBeliMurabahah::class, 'insertTransaksiMurabahah']);
Route::put('/bank/tolakTransaksiMurabahah', [JualBeliMurabahah::class, 'rejectTransaksiMurabahah']);
Route::post('/bank/terimaTransaksiMurabahah', [JualBeliMurabahah::class, 'acceptTransaksiMurabahah']);

// Sub Permintaan barang murabahah

Route::get('/bank/listPermintaanBarang', [JualBeliMurabahah::class, 'getDataPermintaanBarang']);
Route::put('/bank/terimaBarangPermintaan', [JualBeliMurabahah::class, 'terimaBarangKeBank']);
Route::put('/bank/keluarBarangPermintaan', [JualBeliMurabahah::class, 'keluarBarangKeNasabah']);

// Sub Angsuran Murabahah

Route::get('/bank/cariAngsuranMurabahah/{id}', [JualBeliMurabahah::class, 'cariTransaksiMurabahahUntukAngsuran']);
Route::post('/bank/tambahAngsuranMurabahah', [JualBeliMurabahah::class, 'insertAngsuranMurabahah']);
Route::get('/bank/historiDataAngsuran/{id}', [JualBeliMurabahah::class, 'ambilHistoriDataAngsuran']);