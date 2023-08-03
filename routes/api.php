<?php

use App\Http\Controllers\Administrator;
use App\Http\Controllers\Auth;
use App\Http\Controllers\CustomerIdentificationFile;
use App\Http\Controllers\JualBeliMurabahah;
use App\Http\Controllers\JurnalAkuntansi;
use App\Http\Controllers\LaporanTabungan;
use App\Http\Controllers\MetodeBerguna;
use App\Http\Controllers\Tabungan;
use App\Http\Controllers\Testing;
use App\Http\Controllers\UserManagement;
use App\Http\Middleware\CekTokenLogin;
use App\Models\BankCIF;
use App\Models\BankJualBeliMurabahah;
use App\Models\BankTransaksiTabunganWadiah;
use App\Models\SysBank;
use App\Models\SysLog;
use App\Models\SysToken;
use App\Models\SysUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

// Untuk buat kode csrf
Route::get('/buatForm', function(Request $re) {
    $token      = Hash::make(rand(1,160000));

    return response()->json([
        'csrf_token'   => $token
    ]);
});

// Untuk Testing

Route::get('/tesCookie', [Testing::class, 'tesCookie']);

// Untuk Login
Route::post('/super/login', [Auth::class, 'login']);
Route::get('/super/tknCheck', [Auth::class, 'appLevelLoginAuth']);
Route::get('/super/cekLogin', [Auth::class, 'checkSudahLogin']);
Route::get('/super/keluar', [Auth::class, 'logout']);

// Untuk Administrator

Route::post('/super/adminLogin', [Administrator::class, 'adminLogin']);

// Sub Manajemen Mahasiswa
Route::get('/super/memberList', [Administrator::class, 'getMemberDataAll']);
Route::post('/super/addNewMember', [Administrator::class, 'addNewMember']);
Route::post('/super/memberDetails/', [Administrator::class, 'getMemberDetails']);
Route::get('/super/memberListFilterBank/{bankKeys}', [Administrator::class, 'getMemberDataByBankId']);

// Sub Manajemen Grup
Route::get('/super/groupList', [Administrator::class, 'getGroupList']);
Route::post('/super/addNewGroup', [Administrator::class, 'addNewGroups']);

// Sub Manajemen Dashboard
Route::get('/bank/totalTabunganBank', function(Request $re) {
    $ModelUser                  = new SysUser();
    $data_user                  = $ModelUser->getInformasiUser($re->cookie('tkn'));

    $ModelTransaksiTabungan     = new BankTransaksiTabunganWadiah();

    $data                       = $ModelTransaksiTabungan->totalNominalTabunganByBank($data_user->kd_bank);

    return response()->json($data);
});

// Sub Manajemen Bank
Route::get('/super/bankList', [Administrator::class, 'getBankList']);
Route::get('/super/bankList/{keys}', [Administrator::class, 'getBankListById']);
Route::post('/super/addNewBank', [Administrator::class, 'addBankNew']);

Route::get('/super/cekDataJurnal/{id}', [Administrator::class, 'cekKelengkapanJurnal']);

Route::post('/super/updateDataJurnal', [Administrator::class, 'updateKelengkapanBukuAkuntansi']);

// Sub Manajemen Bank - Fitur
Route::get('/super/neraca/{id}', [Administrator::class, 'getBallanceSheet']);

// Sub Manajemen Role / Jenis Pekerjaan
Route::get('/super/roleList', [Administrator::class, 'getRoleList']);

// Sub Manajemen Buku Akuntansi
Route::get('/super/bukuakuntansi', [Administrator::class, 'getSysMasterBukuAkuntansiAll']);
Route::get('/super/cekbukuakuntansi/{id}', [Administrator::class, 'cekSubMasterBukuAkuntansi']);
Route::get('/super/tabelcekbukuakuntansi/{id}', [Administrator::class, 'cekSubMasterBukuAkuntansiById']);
Route::post('/super/addbukuakuntansi', [Administrator::class, 'insertSubMasterBukuAkuntansi']);
Route::put('/super/editbukuakuntansi', [Administrator::class, 'editSubMasterBukuAkuntansi']);

// Untuk Banking


Route::get('/listUser', [UserManagement::class, 'getDataUserAll']);

Route::get('/listUserDesc', [UserManagement::class, 'getDataUserWithDesc']);

// Untuk Info Banking

Route::get('/banyakCIF', function(Request $re) {
    $ModelCIF       = new BankCIF();
    $Hasil          = $ModelCIF->getCountCIF($re->cookie('tkn'));


    if($Hasil->status == true) {
        return response()->json([
            'status'    => 200,
            'message'   => 'Data banyak cif berhasil diambil',
            'count'     => $Hasil->count
        ]);
    } else {
        return response()->json([
            'status'    => 500,
            'message'   => 'Data banyak cif gagal diambil',
            'count'     => 0
        ]);
    }
});

// Sub CIF

Route::get('/bank/listCIF', [CustomerIdentificationFile::class, 'getDataCIFForTabel']);
Route::get('/bank/listCIF/{id}', [CustomerIdentificationFile::class, 'getDataCIFByIdForMurabahah']);
Route::get('/bank/listCIFAll', [CustomerIdentificationFile::class, 'getDataCIF']);
Route::post('/bank/tambahCIF', [CustomerIdentificationFile::class, 'insertDataCIF']);
Route::get('/bank/cariCIF/{id}', [CustomerIdentificationFile::class, 'getDataCIFById']);
Route::post('/bank/cariIdentitas', [CustomerIdentificationFile::class, 'getNomorIdentitas']);
Route::post('/bank/cekStatusCIF', [CustomerIdentificationFile::class, 'cekKetersediaanNomerId']);
Route::post('/bank/cariDataCIF/', [CustomerIdentificationFile::class, 'cariDataNasabah']);

// Sub Tabungan

Route::get('/bank/listProdukTabungan', [Tabungan::class, 'getDataProdukTabungan']);
Route::get('/bank/listTabunganTabel', [Tabungan::class, 'getDataTabunganForTabel']);
Route::post('/bank/tabungan/tambah', [Tabungan::class, 'insertDataTabungan']);

Route::get('/bank/listTabungan/{id}', [Tabungan::class, 'getDataTabunganForTransaksi']);
Route::get('/bank/listTabungan/kdTabungan/{id}', [Tabungan::class, 'cariDataTabunganDariKodeBukuTabungan']);
Route::post('/bank/tambahTransaksiTabungan', [Tabungan::class, 'insertTransaksiTabungan']);

// Sub Tabungan untuk cetak pdf
Route::get('/bank/laporan/riwayatTransaksiTabungan/{id}', [LaporanTabungan::class, 'TampilkanPDFBuatRiwayatTabungan']);
Route::get('/bank/laporan/buatKontrakTabungan', [LaporanTabungan::class, 'LaporanBuatTabunganWadiah']);

// Sub Jual Beli Murabahah

Route::get('/bank/listJualBeliMurabahah', [JualBeliMurabahah::class, 'getDataTransaksiMurabahah']);
Route::get('/bank/listJualBeliMurabahah/{id}', [JualBeliMurabahah::class, 'getDataTransaksiMurabahahById']);
Route::post('/bank/listJualBeliMurabahah/Add', [JualBeliMurabahah::class, 'insertTransaksiMurabahah']);
Route::get('/bank/cariJualBeliMurabahah/{id}', [JualBeliMurabahah::class, 'getDataTransaksiMurabahahForTabel']);
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

// Sub Jurnal Umum
Route::get('/bank/ambilDataJurnalUmum', [JurnalAkuntansi::class, 'getDataJurnalAkuntansi']);
Route::get('/bank/ambilDataJurnalUmum/{id}', [JurnalAkuntansi::class, 'getDataJurnalAkuntansiDetail']);

// Dummy
Route::get('/bank/cekDataNasabah', [CustomerIdentificationFile::class, 'cekDataNasabah']);

// Untuk testing

Route::get('duar', function() {
    $data = BankTransaksiTabunganWadiah::where('kd_buku_tabungan', '201-2023-07-20-2')->get();

    return number_format($data->sum('nominal_transaksi'), 3);
});

Route::get('testings', function(Request $re) {
    $tabel = DB::table('INFORMATION_SCHEMA.TABLES')
                ->select('TABLE_NAME')
                ->where('TABLE_SCHEMA', '=', 'bss')
                ->where('TABLE_TYPE', '=', 'BASE TABLE')
                ->get();

    dd($tabel);
});


Route::middleware(['login.auth'])->group(function() {
    Route::get('/teskoneksi', function() {
        return response()->json([
            'message'       => 'koneksi OK'
        ]);
    });
});