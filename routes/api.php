<?php

use App\Http\Controllers\Administrator;
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

// Untuk Administrator

Route::post('/super/adminLogin', [Administrator::class, 'adminLogin']);

// Sub Manajemen Mahasiswa
Route::get('/super/memberList', [Administrator::class, 'getMemberDataAll']);
Route::post('/super/addNewMember', [Administrator::class, 'addNewMember']);

// Sub Manajemen Grup
Route::get('/super/groupList', [Administrator::class, 'getGroupList']);
Route::post('/super/addNewGroup', [Administrator::class, 'addNewGroups']);

// Sub Manajemen Bank
Route::get('/super/bankList', [Administrator::class, 'getBankList']);
Route::post('/super/addNewBank', [Administrator::class, 'addBankNew']);



// Untuk banking


Route::get('/listUser', [UserManagement::class, 'getDataUserAll']);

Route::get('/listUserDesc', [UserManagement::class, 'getDataUserWithDesc']);