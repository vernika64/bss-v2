<?php

use App\Http\Controllers\Administrator;
use App\Http\Controllers\Auth;
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